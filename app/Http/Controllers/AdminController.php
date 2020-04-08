<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClientDevice;
use App\Visit;
class AdminController extends Controller
{
    //sending the client
    function migrate_client(){
        error_log('sending client program to client side');
        return view('admin_client');
    }

    function send_client_data(){
        $response = array('status'=>'OK');
        try{
            $response['data'] = json_encode(ClientDevice::all());
        }catch(\Exception $e){
            $response['status'] = $e.getMessage();
        }
        return $response;
    }
    
    function send_visit_data_by_fingerprint(Request $request){
        $response = array('status'=>'OK');
        try{
            $fingerprint = $request->fingerprint;
            $visit = Visit::where('fingerprint','=',$fingerprint)->get();
            $response['data'] = json_encode($visit);
            // error_log($response['data']);
        }catch(\Exception $e){
            $response['status'] = $e.getMessage();
        }
        return $response;
    }
}
