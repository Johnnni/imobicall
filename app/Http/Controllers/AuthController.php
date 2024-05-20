<?php

    namespace App\Http\Controllers;

    use App\Models\User;
    use Illuminate\Auth\Events\PasswordReset;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Password;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Str;

    /**
     * Class AuthController
     *
     * @package App\Http\Controllers
     * This class handles the authentication operations such as login.
     */
    class AuthController extends Controller {

        /**
         * Login a user.
         * This method validates the request data and attempts to authenticate the user.
         * If the validation fails or the authentication attempt fails, it returns a JSON response with an error
         * message. If the authentication is successful, it returns a JSON response with a success message and a token.
         *
         * @param  Request  $request  The incoming HTTP request.
         *
         * @return \Illuminate\Http\JsonResponse The JSON response.
         */
        public function login(Request $request) {

            $validation = Validator::make($request->all(), [
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'message' => 'Erro ao validar dados',
                    'success' => false,
                ]);
            }

            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'message' => 'Usuário ou senha incorretos.',
                    'success' => false,
                ]);
            } else {
                $user = User::where('email', $request->email)->first();
                if ($user) {
                    return response()->json([
                        'message' => 'Sucesso!',
                        'success' => true,
                        'token'   => $user->createToken(md5($user->email).$user->email)->plainTextToken,
                    ]);
                }
            }

            return response()->json([
                'message' => 'Erro inesperado',
                'success' => false,
            ]);
        }

        /**
         * Logout a user.
         * This method revokes the user's token and returns a JSON response with a success message.
         *
         * @param  Request  $request  The incoming HTTP request.
         *
         * @return \Illuminate\Http\JsonResponse The JSON response.
         */
        public function logout(Request $request) {

            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logout realizado com sucesso.',
                'success' => true,
            ]);
        }

        public function forgotPassword(Request $request): JsonResponse {

            $validation = Validator::make($request->all(), [
                'email' => 'required|email'
            ]);

            if ($validation->fails()) {
                $fields = $validation->errors()->keys();

                return response()->json([
                    'message' => 'Erro ao validar dados',
                    'fields'  => $fields,
                    'success' => false,
                ]);
            }

            $status = Password::sendResetLink(
                $request->only('email')
            );

            return $status === Password::RESET_LINK_SENT
                ? response()->json(['status' => __($status)], 200)
                : response()->json(['email' => __($status)], 400);
        }

        public function resetPassword(Request $request): JsonResponse {

            $validation = Validator::make($request->all(), [
                'token'     => 'required',
                'email'     => 'required|email',
                'password'  => 'required|min:8',
            ]);

            if ($validation->fails()) {
                $fields = $validation->errors()->keys();

                return response()->json([
                    'message' => 'Erro ao validar dados',
                    'fields'  => $fields,
                    'success' => false,
                ]);
            }


            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {

                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            return $status == Password::PASSWORD_RESET
                ? response()->json(['status' => __($status)], 200)
                : response()->json(['email' => [__($status)]], 400);
        }

    }
