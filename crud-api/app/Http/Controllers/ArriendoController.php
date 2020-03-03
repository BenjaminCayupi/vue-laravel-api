<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Arriendo;
use Illuminate\Support\Facades\Validator;

class ArriendoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Listar todos los arriendos
        $arriendos = Arriendo::orderBy('created_at','desc')->get();

        //Validando que lleguen datos
        if(is_object($arriendos)){
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'arriendo' => $arriendos
            ],200);
        }else{
            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => 'Ha ocurrido un error en la peticion'
            ],400);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Obtener y Validar los datos
        $validator = Validator::make(request()->all(), [
            'producto_id' => 'required|integer',
            'cliente_id' => 'required|integer',
            'fentrega' => 'required',
            'ftermino' => 'required',
            'cantidad' => 'required|integer',
            'estado' => 'required',
        ],[
            'producto_id.required' => 'El producto es requerido',
            'producto_id.integer' => 'El producto debe ser un numero',
            'cliente_id.required' => 'El cliente es requerido',
            'cliente_id.integer' => 'El cliente debe ser un numero',
            'fentrega.required' => 'La fecha de entrega es requerida',
            'ftermino.required' => 'La fecha de termino es requerida',
            'cantidad.required' => 'La cantidad es requerida',
            'cantidad.integer' => 'La cantidad debe ser un numero',
            'estado.required' => 'El estado es requerid0',

        ]);

        //Enviar mensaje al api si la validacion falla
        if($validator->fails()){
            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => 'El arriendo no ha podido ser registrado'
            ]);
        }

        //Guardar los datos validados en la base de datos
        $arriendo = new Arriendo();
        $arriendo->producto_id = $request->producto_id;
        $arriendo->cliente_id = $request->cliente_id;
        $arriendo->fentrega = $request->fentrega;
        $arriendo->ftermino = $request->ftermino;
        $arriendo->cantidad = $request->cantidad;
        $arriendo->estado = $request->estado;
        $arriendo->save();
        
        //Enviar los datos al api
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'arriendo' => $arriendo
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($arriendo)
    {
        // Buscar arriendo por id
        $arr = Arriendo::find($arriendo);

        //Validar que el arriendo exista y enviar estado al api
        if(is_object($arr)){
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'arriendo' => $arr
            ],200);
        }else{
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'No se ha encontrado el arriendo'
            ],404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $arriendo)
    {
        //Buscar arriendo por id
        $arr = Arriendo::find($arriendo);

        //Validar que el arriendo exista
        if(!$arr){
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'El arriendo no ha podido ser encontrado o no existe'
            ],404);
        }

        //Validar datos
        $validator = Validator::make(request()->all(), [
            'producto_id' => 'required|integer',
            'cliente_id' => 'required|integer',
            'fentrega' => 'required',
            'ftermino' => 'required',
            'cantidad' => 'required|integer',
            'estado' => 'required',

        ],[
            'producto_id.required' => 'El producto es requerido',
            'producto_id.integer' => 'El producto debe ser un numero',
            'cliente_id.required' => 'El cliente es requerido',
            'cliente_id.integer' => 'El cliente debe ser un numero',
            'fentrega.required' => 'La fecha de entrega es requerida',
            'ftermino.required' => 'La fecha de termino es requerida',
            'cantidad.required' => 'La cantidad es requerida',
            'cantidad.integer' => 'La cantidad debe ser un numero',
            'estado.required' => 'El estado es requerid0',


        ]);

        //Si la validacion falla enviar mensaje al pi
        if($validator->fails()){
            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => 'El arriendo no ha podido ser registrado'
            ]);
        }

        //Actualizar datos
        $arr->producto_id = $request->producto_id;
        $arr->cliente_id = $request->cliente_id;
        $arr->fentrega = $request->fentrega;
        $arr->ftermino = $request->ftermino;
        $arr->cantidad = $request->cantidad;
        $arr->estado = $request->estado;
        $arr->save();
        
        //Enviar datos actualizados al api
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'arriendo' => $arr
        ],200);
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($arriendo)
    {
        //Buscar arriendo por id para eliminar
        $arr = Arriendo::find($arriendo);

        //Validar que el arriendo por id exista
        if(!$arr){
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'El arriendo no ha podido ser encontrado o no existe'
            ],404);
        }else{
            $arr->delete();
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'arriendo' => $arr
            ],200);
        }

    }

}
