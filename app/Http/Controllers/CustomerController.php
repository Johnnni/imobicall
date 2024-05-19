<?php

    namespace App\Http\Controllers;

    use App\Models\Customer;
    use App\Models\EstateAgent;
    use App\Rules\CelularValidationRule;
    use App\Rules\CpfValidationRule;
    use Illuminate\Http\Request;

    class CustomerController extends Controller {
        /**
         * Display a listing of the resource.
         */
        public function index(string $page) {

            return Customer::paginate(10, ['*'], 'page', $page);
        }

        public function indexByEstateAgent(string $page, string $estate_agent_id) {

            $estateAgent = EstateAgent::find($estate_agent_id);
            if ($estateAgent) {
                return $estateAgent->customers()->paginate(10, ['*'], 'page', $page);
            }

            return response()->json(['message' => 'Agente imobiliário não encontrado.'], 404);
        }


        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request) {

            $request->validate([
                'celular'         => ['required', 'string', 'unique:customers', new CelularValidationRule],
                'email'           => 'required|email|unique:customers',
                'nome'            => 'required|string',
                'cpf'             => ['required', 'string', 'unique:customers', new CpfValidationRule],
                'estate_agent_id' => 'required|exists:estate_agents,id'
            ]);

            $request->cpf     = preg_replace('/[^0-9]/', '', $request->cpf);
            $request->celular = preg_replace('/[^0-9]/', '', $request->celular);

            $customer                  = new Customer();
            $customer->celular         = $request->celular;
            $customer->email           = $request->email;
            $customer->nome            = $request->nome;
            $customer->cpf             = $request->cpf;
            $customer->estate_agent_id = $request->estate_agent_id;
            $customer->save();

            return $customer;
        }

        /**
         * Display the specified resource.
         */
        public function show(string $id) {

            return Customer::findOrFail($id);
        }


        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, string $id) {

            $request->validate([
                'celular'         => ['required', 'string', 'unique:customers,celular,'.$id, new CelularValidationRule],
                'email'           => 'required|email|unique:customers,email,'.$id,
                'nome'            => 'required|string',
                'cpf'             => ['required', 'string', 'unique:customers,cpf,'.$id, new CpfValidationRule],
                'estate_agent_id' => 'required|exists:estate_agents,id'
            ]);

            $request->cpf = preg_replace('/[^0-9]/', '', $request->cpf);

            $customer                  = Customer::findOrFail($id);
            $customer->celular         = $request->celular;
            $customer->email           = $request->email;
            $customer->nome            = $request->nome;
            $customer->cpf             = $request->cpf;
            $customer->estate_agent_id = $request->estate_agent_id;
            $customer->save();

            return $customer;
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(string $id) {

            $customer = Customer::findOrFail($id);
            $customer->delete();

            return response()->json(['message' => "Cliente $customer->nome removido com sucesso."]);
        }
    }
