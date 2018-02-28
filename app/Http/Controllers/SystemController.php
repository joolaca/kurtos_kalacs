<?php
/**
 * Created by PhpStorm.
 * User: gepem
 * Date: 2017.06.25.
 * Time: 16:01
 */

namespace App\Http\Controllers;


use App\Model\Lang;
use Illuminate\Http\Request;

class SystemController
{
    public function home(){
        return view('admin/home');
    }

    public static function getLang(){
        if(is_null(session('lang')) ){
            session(['lang'=> 'hu']);
            $lang = Lang::where('lang', 'hu')->first();
            session(['lang_obj'=> $lang->toArray()]);
        }

        return session('lang');

    }

    public function changeLang(Request $request){
        session(['lang' => $request->lang]);
        $lang = Lang::where('lang', $request->lang)->first();
        session(['lang_obj'=> $lang->toArray()]);

        return redirect('/');
    }


}