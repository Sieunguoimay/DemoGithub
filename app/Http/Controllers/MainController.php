<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Validator;
use App\ClientDevice;
use App\Visit;
class WebGLSupport
{
    public function loadFile($filename){
        return File::get(public_path($filename));;
    }
}
class MainController extends Controller
{
    private $webGLSupport;
    public function __construct(){
        $this->webGLSupport = new WebGLSupport();
    }

    public function home(){
        $files = File::allFiles(getcwd()."/assets/shaders");
        $shaders= array();
        foreach($files as $file){
            array_push($shaders,['name'=>basename($file),'content'=>File::get($file)]);
        }
        return view('home')->with('shaders',$shaders);
    }

    public function get_data_to_display(){
        $response = array('status'=>'OK');
        try{

            $response['bell_count'] = ClientDevice::where('belled', '=', true)->count();

        }catch(\Exception $e){
            $response['status'] = $e.getMessage();
        }
        return $response;
    }

    public function menu(Request $request){
        $response = array('status'=>'OK');
        try{
            if($request->name == 'a_sieunguoimay')
                $response['html'] = strVal(view('menu.sieunguoimay'));
            else if($request->name == 'a_sieunguoimay_github')
                $response['html'] = $this->fetchGithubApi();
            else if($request->name == 'a_sieunguoimay_about_me')
                $response['html'] = strVal(view('menu.sieunguoimay.about_me'));
            else if($request->name == 'a_sieunguoimay_youtube')
                $response['html'] = strVal(view('menu.sieunguoimay.youtube'));
            else if($request->name == 'a_sieunguoimay_facebook')
                $response['html'] = $this->fetchFacebookData();
            else
                $response['html'] = "This section is under constructing. Visit later.".$request->name;

        }catch(\Exception $e){
            $response['status'] = $e.getMessage();
        }
        return $response;
    }
    private function fetchGithubApi(){
        $userData = Http::get("https://api.github.com/users/sieunguoimay");
        if(isset($userData['name'])){
            $reposData = Http::get("https://api.github.com/users/sieunguoimay/repos");
            return strVal(view('menu.sieunguoimay.github')->with(['userData'=>$userData,'reposData'=>$reposData->json()]));
        }
        return  $userData->json();//view('menu.sieunguoimay.github')->with(['userData'=>$userData,'reposData'=>$reposData]);
    }

    private function fetchFacebookData(){
        // $app_id = '2241097489463539';
        // $app_secret = '7b84931aa6b1b81fbb86492953445ea8';
        //https://developers.facebook.com/tools/debug/accesstoken
        $access_token = "EAAf2RCvEOPMBAK2OppKyvKeONSmaD4XEt3Aj1pjPDbMpku6bMO48rFE8bA2ZC9aVO8JMr9inydLOvEZBmWqnz3qnNNSDn2mE95DeBJamrYzFIkmtZBvI8stRfme9xH4qxtAyu0kTpovjqZCgKUzyTHZA7lJrS7cxZCkdcnP4G5EXTREBXQV2F7";//file_get_contents($access_token); // returns 'accesstoken=APP_TOKEN|APP_SECRET'
        $userId = "1328965760635346";
        $baseUrl = "https://graph.facebook.com/$userId?access_token=$access_token";

        $facebookAccount = Http::get($this->appendFieldsToFacebookApiUrl($baseUrl,
            ['name','email','hometown','birthday','picture.type(large)','link',
            'accounts{category,emails,id,picture,link,name,feed{id,message,created_time,from,full_picture,shares,via,permalink_url,privacy}}']));
        if(isset($facebookAccount['error'])){
            throw 1;
        }
        return strVal(view('menu.sieunguoimay.facebook')->with('fbAccount',$facebookAccount));
    }
    private function appendFieldsToFacebookApiUrl($url,$fields){
        $url.="&fields=";
        foreach($fields as $field){
            $url.=$field.",";
        }
        $url = rtrim($url, ", ");
        return $url;
    }


    public function collect_client_device_data(Request $request){
        $response = array('status'=>'OK');
        try{

            $client_data = json_decode($request->client_data)->device;

            $client_device = ClientDevice::where('fingerprint', '=', $client_data->fingerprint)->first();
            if ($client_device === null) {
            // client_device doesn't exist
                $locationData = Http::get('http://ip-api.com/json/'.$request->ip);
                $client_data->geoloc = $locationData->json();
                
                $client_device = new ClientDevice();
                $client_device->ip = $client_data->ip;
                $client_device->fingerprint = $client_data->fingerprint;
                $client_device->platform = 
                    $client_data->platform->os->name.' '.$client_data->platform->os->version.', '
                    .$client_data->platform->browser->name.' '.$client_data->platform->browser->version;
                $client_device->city = $client_data->geoloc['city'];
                $client_device->country = $client_data->geoloc['country'];
                $client_device->isp = $client_data->geoloc['isp'];
                $client_device->lon = $client_data->geoloc['lon'];
                $client_device->lat = $client_data->geoloc['lat'];
                $client_device->json = json_encode($client_data);
                $client_device->access_count = 1;
                $client_device->belled = $client_data->belled;



                $response['action'] = "created";
                error_log('created');//->platform->os->name
            }else{
                $client_device->access_count++;
                $response['action'] = "updated";
                error_log('updated');//->platform->os->name
            }
            $client_device->save();

            $visiting_data = json_decode($request->client_data)->visiting_data;
            $visit = new Visit();
            $visit->fingerprint = $client_data->fingerprint;
            $visit->clicks = json_encode($visiting_data->clicks);
            $visit->loading_time = $visiting_data->loading_time;
            $visit->visiting_time = $visiting_data->visiting_time ;
            $visit->save();
            error_log($visit->clicks);
        }catch(\Exception $e){
            $response['status'] = $e->getMessage();
            error_log($e->getMessage());
        }
        return $response;
    }

    public function ring_the_bell(Request $request){
        $response = array('status'=>'OK');
        try{
            
            $client_device = ClientDevice::where('fingerprint', '=', $request->fingerprint)->first();
            if($client_device===null){
                //the bell is rung
                //tell the ClientDataCollector about this. :)))
                //so that he will tell us again when he sends us data
                $response['bell_count'] = ClientDevice::where('belled', '=', true)->count()+1;
                $response['bell'] = "new_bell_new_client";
            }else{
                if($client_device->belled){
                    //already belled
                    $response['bell'] = "already_belled";
                }else{
                    //new bellllll.!!! yeah!!! 
                    $client_device->belled = true;
                    $client_device->save();
                    $response['bell'] = "new_bell";

                    $response['bell_count'] = ClientDevice::where('belled', '=', true)->count();
                }
            }
            error_log($response['bell']);
        }catch(\Exception $e){
            $response['status'] = $e->getMessage();
            error_log($e->getMessage());
        }
        return $response;
    }
}



/*
378903472644925?fields=bio,picture,name,link,feed
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '2241097489463539',
      xfbml      : true,
      version    : 'v6.0'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>


<div
  class="fb-like"
  data-share="true"
  data-width="450"
  data-show-faces="true">
</div>


https://developers.facebook.com/docs/facebook-login/web/

            My name is 
            <strong title="You already know it if you are on this website, otherwise it not really matters to you, doesn't it?" 
                style="cursor: pointer;">...</strong>
*/