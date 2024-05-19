<?php

    namespace App\Http\Controllers;

    use App\Models\EstateAgents;
    use App\Rules\CpfValidationRule;
    use Illuminate\Http\Request;

    class EstateAgentController extends Controller {
        /**
         * Display a listing of the resource.
         */
        public function index(string $page) {
            return EstateAgents::paginate(10, ['*'], 'page', $page);
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

            $estateAgent          = new EstateAgents();
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
            return EstateAgents::findOrFail($id);
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(string $id) {
            //
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, string $id) {
            //
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(string $id) {
            //
        }
    }
