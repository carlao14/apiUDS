<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use Validator;
use Illuminate\Http\Response;
class ClienteController extends Controller
{
    public function index(){
        $retorno = Cliente::all();
        return response($retorno,200)
                        ->header('Content-Type', 'aplication/json');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $param){

        $validator = Validator::make($param->all(),[
            'nome' => 'required',
            'email' => 'required'
        ]);
        if($validator->fails()){    
            return response($validator->errors(), 200)
                            ->header('Content-Type', 'aplication/json');
        }else{
            $cliente = new Cliente();
            $cliente->nome = $param->nome;
            $cliente->email = $param->email;
            if($cliente->save()){
                $msg["status"] = "OK";
                return response(json_encode($msg), 200)
                            ->header('Content-Type', 'aplication/json');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        return Cliente::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $param, $id){
        $validator = Validator::make($param->all(),[
            'nome' => 'required',
            'email' => 'required'
        ]);
        if($validator->fails()){    
            return response($validator->errors(), 200)
                            ->header('Content-Type', 'aplication/json');
        }else{
            $cliente = Cliente::find($id);
            $cliente->nome = $param->nome;
            $cliente->email = $param->email;
            if($cliente->save()){
                $msg["status"] = "OK";
                return response(json_encode($msg), 200)
                            ->header('Content-Type', 'aplication/json');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id){
        $del["status"] = Cliente::destroy($id);
        return response(json_encode($del), 200)
                            ->header('Content-Type', 'aplication/json');
    }
}
