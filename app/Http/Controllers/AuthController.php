<?php

    namespace App\Http\Controllers;

    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Validator;

    /**
     * Class AuthController
     * @package App\Http\Controllers
     *
     * This class handles the authentication operations such as login.
     */
    class AuthController extends Controller {

        /**
         * Login a user.
         *
         * This method validates the request data and attempts to authenticate the user.
         * If the validation fails or the authentication attempt fails, it returns a JSON response with an error message.
         * If the authentication is successful, it returns a JSON response with a success message and a token.
         *
         * @param Request $request The incoming HTTP request.
         * @return \Illuminate\Http\JsonResponse The JSON response.
         */
        public function login(Request $request) {

            $validation = Validator::make($request->all(), [
                'email'    => 'required|string|email',
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
    }
