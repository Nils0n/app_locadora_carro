<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{
    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marcas = $this->marca::all();

        if (count($marcas) == 0) {
            return response()->json($marcas, 204);
        }

        return response()->json($marcas, 200);
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
        $request->validate($this->marca->rules(), $this->marca->messages());

        try {
            $marca = $this->marca::create([
                'name' => $request->name,
                'logo' => $request->logo->store('images/marcas'),
            ]);
        } catch (Exception $e) {
            dd($e);
        }

        return response()->json($marca, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca = $this->marca::find($id);
        if ($marca === null) {
            return response()->json(['O recurso solicitado não existe'], 404);
        }

        return response()->json($marca, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $marca = $this->marca::find($id);

        if ($marca === null) {
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe'], 404);
        }

        if ($request->method() === 'PATCH') {
            $rulesDinamyc = [];

            foreach ($marca->rules() as $key => $rule) {
                if (array_key_exists($key, $request->all())) {
                    $rulesDinamyc[$key] = $rule;
                }
            }

            $request->validate($rulesDinamyc, $marca->messages);
        } else {

            $request->validate($marca->rules(), $marca->messages());
        }

        try {
            $marca->update([
                'name' => $request->name === null ? $marca->name : $request->name,
                'logo' => $request->logo === null ? $marca->logo : $request->logo->store('images/marcas'),
            ]);
        } catch (Exception $e) {
            dd($e);
        }

        return response()->json($marca, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marca = $this->marca::find($id);

        if ($marca === null) {
            return response()->json(['error' => 'O recurso solicitado não existe'], 404);
        }

        try {
            $marca->delete();
        } catch (Exception $e) {
            dd($e);
        }

        return response()->json(['succes' => 'Registro deletado com sucesso'], 200);
    }
}
