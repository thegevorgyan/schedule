<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Website;
use DateTime;
use DateTimeZone;

class CheckController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        //
    }

    public function compare(Request $request)
    {
        date_default_timezone_set('America/Los_Angeles');
        $timestamp = date('Y-m-d H:i:s');

        $token = $request->input('aspire_token');
        $website_key = $request->input('website_key');       

        $website_row = DB::table('websites')
        ->join('caches', 'websites.key', '=', 'caches.key')
        ->where('caches._token', '=', $token)
        ->select('websites.session_timeout', 'caches.created_at', 'caches.updated_at')
        ->get();
			
		$xxxx = json_encode($website_row);
		$xxx = json_decode($xxxx, true);
		if(!empty($xxx)){
			
			$xxx[0]["status"] = "error";
            $xxx[0]["message"] = "Session timed out. Please validate again";
            $xxx[0]["regenerate"] = false;
            $xxx[0]["xxx"]= $request->cookie("aspire_token");
			
			$verified_time = DateTime::createFromFormat("Y-m-d H:i:s" , $xxx[0]["updated_at"]);
			$seconds = (new DateTime("now"))->getTimeStamp() - $verified_time->getTimeStamp(); //adjusted for UTC
			$seconds_left = ($xxx[0]["session_timeout"])*60 - $seconds;
			
			$xxx[0]["X"] = $seconds_left;
			
			if($seconds_left > 0){
				$xxx[0]["status"] = "ok";
                $xxx[0]["message"] =  "Still in session";
                $xxx[0]["regenerate"] = false;
                DB::table('caches')->where(['_token' => $token, 'key' => $website_key])->update([
                    'updated_at' => $timestamp,
                ]);
            }
        } else {
            $xxx[0]["status"] = "error";
            $xxx[0]["message"] = "Session timed out. Please validate again";
            $xxx[0]["regenerate"] = true;
        }
        return json_encode($xxx);
    }


    public function store(Request $request)
    {       
        $remoteIpAddresss = $request->server("REMOTE_ADDR");
        $token = $request->input('aspire_token');
        $website_key = $request->input('website_key');
        $cookies = $request->input('cks');

       /* $data_exists = DB::table('caches')->whereRaw([
                                                ['key', '=', $website_key],
                                                ['_token', '=', $token]
                                            ]);*/

           // return $data_exists;
      //  if(!empty($data_exists)){
            DB::table('stored_data')->insert([
                'remote_ip_addr' => $remoteIpAddresss,
                'key' => $website_key,
                '_token' => $token,
                '_cookies' => $cookies
            ]);
      //  }
    }




    public function check(Request $request)
    {  
        date_default_timezone_set('America/Los_Angeles');
        $timestamp = date('Y-m-d H:i:s');  
       
       $response = array( 
            "status"=>"201",
            "status_text"=>"error",
            "status_message"=>'<h2 style="display:block; padding:30px;text-align:center">Based on the information provided, you are not allowed to navigate this website</h2>',
            "redirect" => ""
        );
        $verified = false;
        /************************** */
//dd($request->server('HTTP_HOST'));
//return false;
        $data               = json_encode($request->server());
        $remoteIpAddresss   = $request->server("REMOTE_ADDR");
        $websiteAddress     = $request->server('HTTP_HOST');
        $websiteKey         = $request->input('websiteKey');
        $date               = $request->input('month') . '-' .  $request->input('day') . '-' . $request->input('year');
        $token              = $request->input('aspire_token');
        $verify             = $request->input('verify');
        //dd($request);

        $popupInfo          = DB::table('websites')
                                ->where('key', '=', $websiteKey)
                                ->get();
        $popupObject        = $popupInfo[0];
        $token_exists = DB::table('caches')->where('_token', $token)->first();
       
        switch($popupObject->type) {
            case "age":
                if($request->input("verify") == "true"){            
                    $verified = $request->input("verify");
                    DB::table('received_data')->insert([
                        'remote_ip_addr' => $remoteIpAddresss,
                        'website_addr' => $websiteAddress,
                        'key' => $websiteKey,
                        '_token' => $token,
                        'date' => 'none',
                        'verify' => $verify,
                        'data' => $data
                    ]);

                    if(empty($token_exists)){                    
                        DB::table('caches')->insert([
                            'remote_ip_addr' => $remoteIpAddresss,
                            'key' => $websiteKey,
                            '_token' => $token,
                            'created_at' => $timestamp,
                            'updated_at' => $timestamp
                        ]);
                    }else{                  
                        DB::table('caches')->where(['_token' => $token])->update([
                            'updated_at' => $timestamp,
                        ]);
                    }
                } else if($request->input("verify") == "false"){
                    
                    $response['status'] = "204";                  
                    DB::table('received_data')->insert([
                        'remote_ip_addr' => $remoteIpAddresss,
                        'website_addr' => $websiteAddress,
                        'key' => $websiteKey,
                        '_token' => $token,
                        'date' => 'none',
                        'verify' => $verify,
                        'data' => $data
                    ]);

                    $response['status'] = "204";                 
                }
                break;
            case "dob": 
                if((checkdate($request->input('month'), $request->input('day'), $request->input('year'))) &&  $request->input("verify") == "true"){

                    $tz = new DateTimeZone('America/Los_Angeles');
                    $format = 'm-d-Y';
                    
                    if($format == 'm-d-Y'){
                        $dob = DateTime::createFromFormat($format, "{$request->input('month')}-{$request->input('day')}-{$request->input('year')}");
                    }
                    if($format == 'd-m-Y'){    
                        $dob = DateTime::createFromFormat($format, "{$request->input('day')}-{$request->input('month')}-{$request->input('year')}");
                    }   
                    $age = $dob->diff(new DateTime('now'))->format('%Y');
                    if ($age >= $popupObject->age){
                        $verified = true;
                    }

                    DB::table('received_data')->insert([
                        'remote_ip_addr' => $remoteIpAddresss,
                        'website_addr' => $websiteAddress,
                        'key' => $websiteKey,
                        '_token' => $token,
                        'date' => $date,
                        'verify' => $verify,
                        'data' => $data
                    ]);                   

                    if(empty($token_exists)){
                        DB::table('caches')->insert([
                            'remote_ip_addr' => $remoteIpAddresss,
                            'key' => $websiteKey,
                            '_token' => $token,
                            'created_at' => $timestamp,
                            'updated_at' => $timestamp
                        ]);
                    }else{
                        DB::table('caches')->where(['_token' => $token])->update([
                            'updated_at' => $timestamp,
                        ]);
                    }

                } else if($request->input("verify") == "false"){
                    
                    $response['status'] = "204";
                    if(checkdate($request->input('month'), $request->input('day'), $request->input('year'))){
                        DB::table('received_data')->insert([
                            'remote_ip_addr' => $remoteIpAddresss,
                            'website_addr' => $websiteAddress,
                            'key' => $websiteKey,
                            '_token' => $token,
                            'date' => $date,
                            'verify' => $verify,
                            'data' => $data
                        ]);

                        $response['status'] = "204";
                    }
                }else {
                    $response['status_code'] = "202";
                    $response["status_message"] = "<h2 style='display:block, padding:30px; text-align:center'>Date of birth entered incorrectly</h2>";
                    if($popupObject->reject_redirect_url != ""){ // reject redirect url
						$response["redirect"] = $popupObject->reject_redirect_url;
					}
                }
                break;
            default:
                return 'error';
                break;
        }

        if($verified == "true"){  
            $response["status"] ="200";
            $response["status_text"] = "OK";
            $response["status_message"] = "Your information was successfully verified";
            if($popupObject->verified_redirect_url != ""){
				$response["redirect"] = $popupObject->verified_redirect_url;
			}
        }

       return json_encode($response, JSON_PRETTY_PRINT);
    }
}
