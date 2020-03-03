<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cliente = Cliente::orderBy('created_at', 'desc')->get();
        if(is_object($cliente)){
            $data = [
                'code' => 200,
                'status' => 'success',
                'cliente' => $cliente
            ];
        }else{
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'La peticion ha fallado'
            ];
        }
        return response()->json($data, $data['code']);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'nombre' => 'required',
            'email' => 'required|email',
            'telefono' => 'required',
            'direccion' => 'required'  
        ],[
            'nombre.required' => 'El nombre es requerido',
            'email.required' => 'El email es requerido',
            'email.email' => 'El campo email debe ser valido',
            'telefono.required' => 'El telefono es requerido',
            'direccion.required' => 'La direccion es requerido',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => 'El cliente no ha podido ser registrado',
                'error' => $validator->errors()
            ],400);
        }
        
        $cliente = new Cliente();
        $cliente->nombre = $request->nombre;
        $cliente->email = $request->email;
        $cliente->telefono = $request->telefono;
        $cliente->direccion = $request->direccion;
        $cliente->save();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'cliente' => $cliente
        ],200);
    }

    public function show($cliente)
    {
        $cliente = Cliente::find($cliente);
        if(is_object($cliente)){
            $data = [
                'code' => 200,
                'status' => 'success',
                'cliente' => $cliente
            ];
        }else{
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'No se han encontrado resultados'
            ];
        }

        return response()->json($data, $data['code']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cliente)
    {
        // Encontrar cliente
        $cli = Cliente::find($cliente);
        if(!$cli){
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'El cliente no se ha encontrado'
            ], 404);
        }

         // Validar datos
         $validator = Validator::make(request()->all(), [
             'nombre' => 'required',
             'email' => 'required|email',
             'telefono' => 'required',
             'direccion' => 'required'  
         ],[
             'nombre.required' => 'El nombre es requerido',
             'email.required' => 'El email es requerido',
             'email.email' => 'El campo email debe ser valido',
             'telefono.required' => 'El telefono es requerido',
             'direccion.required' => 'La direccion es requerido',
         ]);

         // Si la validacion falla, enviar errores al api
         if ($validator->fails()) {
             return response()->json([
                 'code' => 400,
                 'status' => 'error',
                 'message' => 'El cliente no ha podido ser modificado',
                 'error' => $validator->errors()
             ],400);
         }

        // Actualizar datos
        $cli->nombre = $request->nombre;
        $cli->email = $request->email;
        $cli->telefono = $request->telefono;
        $cli->direccion = $request->direccion;
        $cli->update();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'cliente' => $cli
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cliente)
    {
        $cliente = Cliente::find($cliente);

        if(!$cliente){
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'El cliente no se ha encontrado'
            ], 404);
        }else{
            $cliente->delete();
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'cliente' => $cliente
            ], 200);
        }
    }
}
