<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Exception;
use Illuminate\Http\Request;

class ModeloController extends Controller
{
    public function __construct(Modelo $modelo)
    {
        $this->modelo = $modelo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelos = $this->modelo::all();

        if (count($modelos) === 0) {
            return response()->json($modelos, 204);
        }

        return response()->json($modelos, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->modelo->rules(), $this->modelo->messages());

        try {
            $modelo = $this->modelo::create([

                'marca_id' => $request->marca_id,
                'name' => $request->name,
                'image'  => $request->image->store('images/modelos'),
                'number_doors' => $request->number_doors,
                'benches' => $request->benches,
                'air_bag' => $request->air_bag,
                'abs' => $request->abs,
            ]);
        } catch (Exception $e) {
            dd($e);
        }

        return response()->json($modelo, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modelo = $this->modelo::find($id);

        if ($modelo === null) {
            return response()->json(['error' => 'Recurso solicitado não existe'], 404);
        }

        return response()->json($modelo, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function edit(Modelo $modelo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $modelo = $this->modelo::find($id);

        if ($modelo === null) {
            return response()->json(['error' => 'Recurso solicitado não existe'], 404);
        }

        if ($request->method() === 'PATCH') {
            $rulesDinamyc = [];

            foreach ($modelo->rules() as $key => $rule) {
                if (array_key_exists($key, $request->all())) {
                    $rulesDinamyc[$key] = $rule;
                }
            }

            $request->validate($rulesDinamyc, $modelo->messages());
        } else {
            $request->validate($modelo->rules(), $modelo->messages());
        }

        try {
            $modelo->update([
                'marca_id' => $request->marca_id !== null ? $request->marca_id : $modelo->marca_id,
                'name' => $request->name !== null ? $request->name : $modelo->name,
                'image'  => $request->image !== null ? $request->image->store('images/modelos') : $modelo->image,
                'number_doors' => $request->number_doors !== null ? $request->number_doors : $modelo->number_doors,
                'benches' => $request->benches !== null ? $request->benches : $modelo->benches,
                'air_bag' => $request->air_bag !== null ? $request->air_bag : $modelo->air_bag,
                'abs' => $request->input('abs') !== null ? $request->input('abs') : $modelo->abs,
            ]);
        } catch (Exception $e) {
            dd($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modelo = $this->modelo::find($id);

        if ($modelo === null) {
            return response()->json(['error' => 'Recurso solicitado não existe'], 404);
        }

        $modelo->delete();
        return response()->json(['success' => 'Registro deletado com sucesso.'], 200);
    }
}
