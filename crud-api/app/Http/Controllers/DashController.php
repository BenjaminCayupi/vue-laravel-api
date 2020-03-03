<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Arriendo;
use App\Cliente;
use Carbon\Carbon;


class DashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arriendo = Arriendo::get();
        $last_15_days = Arriendo::where('created_at','>=',Carbon::now()->subdays(15))->get(['id','created_at'])->count();
        $last_month = Arriendo::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->get(['id','created_at'])->count();
        $favorite_client = Arriendo::select('cliente_id')->groupBy('cliente_id')->orderByRaw('COUNT(*) DESC')->limit(1)->get()->pluck('cliente');
        $ult_arriendos = Arriendo::orderBy('created_at','desc')->take(3)->get();
        
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'last_15' => $last_15_days,
            'last_month' => $last_month,
            'fav_client' => $favorite_client,
            'ult_arriendos' => $ult_arriendos

        ]);
    }

    
}
