<?php

    namespace App\Http\Controllers;

    use App\Models\EstateAgent;
    use App\Rules\CelularValidationRule;
    use App\Rules\CpfValidationRule;
    use Illuminate\Http\Request;

    class EstateAgentController extends Controller {
        /**
         * Display a listing of the resource.
         */
        public function index(string $page) {

            return EstateAgent::paginate(10, ['*'], 'page', $page);
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request) {

            $request->validate([
                'celular' => 'required|string',
                'email'   => 'required|email|unique:estate_agents',
                'nome'    => 'required|string',
                'cpf'     => ['required', 'string', 'unique:estate_agents', new CpfValidationRule]
            ]);

            $request->cpf = preg_replace('/[^0-9]/', '', $request->cpf);

            $estateAgent          = new EstateAgent();
            $estateAgent->celular = $request->celular;
            $estateAgent->email   = $request->email;
            $estateAgent->nome    = $request->nome;
            $estateAgent->cpf     = $request->cpf;
            $estateAgent->save();

            return $estateAgent;
        }

        /**
         * Display the specified resource.
         */
        public function show(string $id) {

            return EstateAgent::findOrFail($id);
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, string $id) {

            $request->validate([
                'celular' => ['required', 'string', new CelularValidationRule],
                'email'   => 'required|email|unique:estate_agents,email,'.$id,
                'nome'    => 'required|string',
                'cpf'     => ['required', 'string', 'unique:estate_agents,cpf,'.$id, new CpfValidationRule]
            ]);

            $request->cpf     = preg_replace('/[^0-9]/', '', $request->cpf);
            $request->celular = preg_replace('/[^0-9]/', '', $request->celular);

            $estateAgent          = EstateAgent::findOrFail($id);
            $estateAgent->celular = $request->celular;
            $estateAgent->email   = $request->email;
            $estateAgent->nome    = $request->nome;
            $estateAgent->cpf     = $request->cpf;
            $estateAgent->save();

            return $estateAgent;
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(string $id) {

            $estateAgent = EstateAgent::findOrFail($id);

            if ($estateAgent->customers->count() > 0) {
                foreach ($estateAgent->customers as $customer) {
                    $customer->estate_agent_id = null;
                    $customer->save();
                }
            }

            $estateAgent->delete();

            return response()->json(['message' => "Corretor $estateAgent->nome deletado com sucesso!", "id" => $id]);
        }
    }
