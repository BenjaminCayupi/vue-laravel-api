<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use Illuminate\Support\Facades\Validator;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Llamar a todos los productos y ordenarlos por fecha de creacion
        $producto = Producto::orderBy('created_at','desc')->get();

        // Validar que lleguen los datos, y definir la data para el api
        if(is_object($producto)){
            $data = [
                'code' => 200,
                'status' => 'success',
                'producto' => $producto
            ];
        }else{
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'La peticion ha fallado'
            ];
        }

        //Response al API
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
        //Validar campos
        $validator = Validator::make(request()->all(),[
            'marca' => 'required',
            'modelo' => 'required',
            'categoria' => 'required',
            'nserie' => 'required',
        ],[
            'marca.required' => 'La marca es requerida',
            'modelo.required' => 'El modelo es requerido',
            'categoria.required' => 'La categoria es requerida',
            'nserie.required' => 'El numero de serie es requerido',
        ]);
            
        //Enviar respuesta si la validacion falla
        if($validator->fails()){
            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => 'Los datos no son validos',
                'error' => $validator->errors()
            ],400);
        }

        //Guardar
        $producto = new Producto();
        $producto->marca = $request->marca;
        $producto->modelo = $request->modelo;
        $producto->categoria = $request->categoria;
        $producto->nserie = $request->nserie;
        $producto->save();

        //API
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'producto' => $producto
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($producto)
    {
        //Buscar producto por el id
        $prod = Producto::find($producto);

        //Validar que lleguen los datos y mandar los mensajes correspondientes
        if(is_object($prod)){
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'producto' => $prod
            ],200);
        }else{
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'No se ha encontrado el registro'
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
    public function update(Request $request, $producto)
    {
        //Buscar el producto por id
        $prod = Producto::find($producto);

        //Validar que exista el producto que se desea modificar
        if(!$prod){
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'No se ha encontrado el producto'
            ],404);
        }

        //Validar los datos
        $validator = Validator::make(request()->all(),[
            'marca' => 'required',
            'modelo' => 'required',
            'categoria' => 'required',
            'nserie' => 'required',
        ],[
            'marca.required' => 'La marca es requerida',
            'modelo.required' => 'El modelo es requerido',
            'categoria.required' => 'La categoria es requerida',
            'nserie.required' => 'El numero de serie es requerido',
        ]);

        //Enviar mensaje si falla la validacion
        if($validator->fails()){
            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => 'Los datos no son validos'
            ],400);
        }

        //Actualizar el producto
        $prod->marca = $request->marca;
        $prod->modelo = $request->modelo;
        $prod->categoria = $request->categoria;
        $prod->nserie = $request->nserie;
        $prod->update();

        //Enviar al API
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'producto' => $prod
        ],200);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($producto)
    {
        //Buscar producto a eliminar
        $prod = Producto::find($producto);

        //Validar que el producto exista
        if(!$prod){
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'No se ha encontrado el producto'
            ],404);
        }else{
            $prod->delete();
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'producto' => $prod
            ],200);
        }
    }
}
