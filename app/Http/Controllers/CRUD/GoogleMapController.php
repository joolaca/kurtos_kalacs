<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2017.10.06.
 * Time: 12:02
 */

namespace App\Http\Controllers\CRUD;


class GoogleMapController extends BaseCrudController
{
    public function renderFrontendHtml(){
        return view('page/google_map/rolunk')
            ->render();
    }
}