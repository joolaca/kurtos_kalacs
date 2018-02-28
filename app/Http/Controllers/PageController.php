<?php
/**
 * Created by PhpStorm.
 * User: gepem
 * Date: 2017.06.25.
 * Time: 16:01
 */

namespace App\Http\Controllers;


use App\Exceptions\UserCreateException;
use App\Model\ContentMenu;
use App\Model\Menu;
use Illuminate\Support\Facades\Request;

class PageController
{
    public function adminHomeView(){
        return view('admin/home');
    }

    public function create(){
        return view('admin/page/create');
    }


    public function homeView(){
        return view('page/home');
    }


    /** Ez készíti el az aloldalakat
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws UserCreateException
     */
    public function renderPage(Request $request, $slug){

        $menu = Menu
            ::where('slug', $slug)
            ->where('lang', SystemController::getLang())
            ->first();
        $menu_contents = ContentMenu::where('menu_id', $menu->id)->get();

        $contents = [];
        foreach ($menu_contents as $menu_content) {
            if(!class_exists($menu_content->content_controller)){
                throw new UserCreateException('Nincs olyan class ami a rendelelést megcsinálná ezt hívja: '. $menu_content->content_controller);
            }
            $controller = new $menu_content->content_controller();

            if(!method_exists($controller,'renderFrontendHtml')){
                throw new UserCreateException('Nincs a '.$menu_content->content_controller.' nek renderFrontendHtml()  függvénye');
            }

            $contents[]= $controller->renderFrontendHtml($request,$menu_content);
        }


        return view('page/contents', compact('contents'));
    }


    
    
}