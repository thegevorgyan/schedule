<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Website;

class WebsitesController extends Controller
{
    
	public function __construct()
    {        
        $this->middleware('auth');
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function generateCacheFiles($websiteKey)
    {     
        $termsDisplay = '';
        $popupInfo = DB::table('websites')
                    ->where('key', '=', $websiteKey)
                    ->get();
        $popupObject = $popupInfo[0];
        $popupObject->terms_conditions == '-' ? $termsDisplay = 'none' : $termsDisplay = 'block'; 
        
        $template = "avc1";
        $vars = array(
            '{BGURL}' => Config('path.aspireUrl') . "cache/{$popupObject->filename}",
            '{HTMLFILEURL}' => Config('path.aspireUrl') . "cache/{$websiteKey}.html",
            '{CSSFILEURL}' => Config('path.aspireUrl') . "cache/{$websiteKey}.css",
            '{HTMLFILE}' => $websiteKey.".html",
            '{CSSFILE}' => $websiteKey.".css",
            '{JSFILE}' => $websiteKey.".js",
            '{WEB}' => $popupObject->website_addr,
            '{HEADER}' => $popupObject->header,
            '{BODY}' => "<span id='website' style='display:none'>{$popupObject->website_addr}</span><span id='required_key' style='display:none'>{$websiteKey}</span>{$popupObject->text}",
            '{HINT}' => $popupObject->hint,
            '{BGCOLOR}' => $popupObject->bg_color,
            '{VERURL}' => $popupObject->verified_redirect_url,
            '{REJURL}' => $popupObject->reject_redirect_url,
            //'{AGE}' => $popupObject->age,
            '{ENTER}' => $popupObject->enter_btn_text,            
            '{CANCEL}' => $popupObject->cancel_btn_text,
            '{INFO}' => $popupObject->info_btn_text,
            '{INFODESC}' => $popupObject->info_description,
            '{TIMEOUT}' => $popupObject->session_timeout,
            '{TERMS}' => $popupObject->terms_conditions,   
            '{TERMSDISPLAY}' => $termsDisplay,   
            '{KEY}' => $websiteKey,
            '{ASPIREURL}' => Config('path.aspireUrl')
        );

  
        //generate CSS file for the Key  
        $css_include = ob_get_clean();
        $css_include = file_get_contents("../templates/{$template}/{$popupObject->type}/default.css", TRUE);      
        $css_include = strtr($css_include, $vars); // replace variables
        file_put_contents("../public/cache/".$vars["{CSSFILE}"], $css_include);

        //generate JS file for the Key
        $js_include = ob_get_clean();
        $js_include = file_get_contents("../templates/{$template}/{$popupObject->type}/default.js", TRUE);
        $js_include = strtr($js_include, $vars); // replace variables
        file_put_contents("../public/cache/".$vars["{JSFILE}"], $js_include);

        //generate HTML file for the Key
        $html_include = ob_get_clean();
        $html_include = file_get_contents("../templates/{$template}/{$popupObject->type}/default.html", TRUE);
        $html_include = strtr($html_include, $vars); // replace variables
        file_put_contents("../public/cache/".$vars["{HTMLFILE}"], $html_include); 
    }  


    public function index()
    {
        //        
    }

    public function create()
    {
        //
    }

    public function store(Request $request, $template = "avc1")
    {     
        ob_start();        
        /* $this->validate($request, [
            'age'  => 'required|numeric',
            'name'  => 'active_url'
        ]);*/

        $key = $this->generateRandomString(16);
        if($request->get('image_num') == '0'){
            $imageSize = $request->get('image_size');
            $imageType = $request->get('image_type');
            $image = $request->get('image');            
        }else{
            $imageType = 'image/jpeg';
            $imageDefault = file_get_contents('../public/img/bg/bg' . $request->get('image_num') . '.jpeg');
            $image = 'data:image/jpeg;base64,' . base64_encode($imageDefault);
        }
        $image = str_replace('data:' . $imageType . ';base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageExt = str_replace('image/', '', $imageType);
        $imageName = $key . '.' . $imageExt;
        if( $imageType === 'image/jpeg' || $imageType === 'image/jpg' || $imageType === 'image/gif' || $imageType === 'image/png' ) {
            file_put_contents(storage_path('../public/cache/') . $imageName, base64_decode($image));
            DB::table('websites')->insert([
                                            'website_addr' => $request->input('website_addr'),
                                            'header' => $request->input('header'),
                                            'text' => $request->input('text'),
                                            'hint' => $request->input('hint'),
                                            'age' => $request->input('age'),
                                            'type' => $request->input('type'),
                                            'key' => $key,
                                            'filename' => $key . '.' . $imageExt,
                                            'bg_color' => $request->input('bg_color'),
                                            'verified_redirect_url' => preg_replace('/\s+/', '', $request->input('verified_redirect_url')),
                                            'reject_redirect_url' => preg_replace('/\s+/', '', $request->input('reject_redirect_url')),
                                            'enter_btn_text' => $request->input('enter_btn_text'),
                                            'cancel_btn_text' => $request->input('cancel_btn_text'),
                                            'info_btn_text' => $request->input('info_btn_text'),
                                            'info_description' => $request->input('info_description'),
                                            'session_timeout' => $request->input('session_timeout'),
                                            'terms_conditions' => $request->input('terms_conditions'),
                                            'username' => Auth::user()->name
                                        ]);                                      
            $this->generateCacheFiles($key);            
        } else {
            return 'err';
        }

    }

    public function show($id)
    {
        //       
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {     
        $website_row = DB::table('websites')     
        ->where(['id'=> $id, 'username' => Auth::user()->name])
        ->get();

        if(count($website_row) == 1){
            ob_start();
            $imageSize = $request->get('image_size');
            if($request->get('image_num') == '0'){            
                $imageType = $request->get('image_type');
                $image =  $request->get('image');            
            }else{
                $imageType = 'image/jpeg';
                $imageDefault = file_get_contents('../public/img/bg/bg' . $request->get('image_num') . '.jpeg');
                $image = 'data:image/jpeg;base64,' . base64_encode($imageDefault);
            }
            $image = str_replace('data:' . $imageType . ';base64,', '', $image);
            $image = str_replace(' ', '+', $image);      
            $imageExt = str_replace('image/', '', $imageType);   
            $imageName = $request->input('key') . '.' . $imageExt;
            
            if(($imageType === 'image/jpeg' || $imageType === 'image/jpg' || $imageType === 'image/gif' || $imageType === 'image/png')) {
                if($imageSize != '0'){
                    file_put_contents(storage_path("../public/cache/") . $imageName, base64_decode($image));
                }

                DB::table('websites')->where('id', '=', $id)->update([
                                                                        'website_addr' => $request->input('website_addr'),
                                                                        'header' => $request->input('header'),
                                                                        'text' => $request->input('text'),
                                                                        'hint' => $request->input('hint'),
                                                                        'age' => $request->input('age'),
                                                                        'type' => $request->input('type'),
                                                                        'filename' => $request->input('key') . '.' . $imageExt,                                                            
                                                                        'bg_color' => $request->input('bg_color'),
                                                                        'verified_redirect_url' => preg_replace('/\s+/', '', $request->input('verified_redirect_url')),
                                                                        'reject_redirect_url' => preg_replace('/\s+/', '', $request->input('reject_redirect_url')),
                                                                        'enter_btn_text' => $request->input('enter_btn_text'),
                                                                        'cancel_btn_text' => $request->input('cancel_btn_text'),
                                                                        'info_btn_text' => $request->input('info_btn_text'),
                                                                        'info_description' => $request->input('info_description'),
                                                                        'session_timeout' => $request->input('session_timeout'),
                                                                        'terms_conditions' => $request->input('terms_conditions')
                                                                    ]);
                $this->generateCacheFiles($request->input('key'));
            } else {
                return 'err';
            }
        } else {
           return 'You do not have an access';
        }
    }

    public function destroy(Request $request)
    {
        DB::table('websites')
            ->where('id', '=', $request->input('id'))
            ->delete();
    }

    public function getDestroy(Request $request)
    {

        abort('404');

    }    
   
}
