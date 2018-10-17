<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Carbon\Carbon;

class ApiAuthController extends Controller
{
  public function getKey(){
    $key = "ThEtRuThIsInWhAtYoUbElIeVe";
    return $key;
  }

  public function logar(Request $param){
    //return $param->bearerToken();
    return response($this->gerarToken($param), 200)->header('Content-Type', 'application/json');
  }

  public function gerarToken($param){

    $usu = new UsuarioController();
    if($usu->logarApi($param->login,$param->passwd)){
      $token = array(
        "login" => $param->login,
        "passwd" => $param->passwd,
        "expire" => Carbon::now()->addDays(10)
      );

      $jwt = JWT::encode($token, $this->getKey());
      return json_encode($jwt);

    }

    return "false";
  }

  public function getCredentials($token){

    try {
      if(JWT::decode($token, $this->getKey(), array('HS256'))){
        $decoded = JWT::decode($token, $this->getKey(), array('HS256'));

        if($decoded->expire < Carbon::now()){
          $token = $this->gerarToken($decoded);
          if($token != "false"){
              return $token;
          }
        }
        else {
          $token = $this->gerarToken($decoded);
          if($token != "false"){
              return $token;
          }
        }
        return "error";
      }
    }catch (\Exception $e) {
        return "error";
    }


  }

}
