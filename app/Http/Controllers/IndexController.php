<?php

namespace App\Http\Controllers;

use App\Model\IndexPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Laracasts\Flash\Flash;

class IndexController extends Controller
{

    /** Admin oldalon az index oldalak szerkesztése
     * @param Request $request
     */
    public function edit(Request $request){

        if(!session()->has('index_edit_lang')){
            session(['index_edit_lang' => 'hu']);
        }


        $index_sections = $this->getIndexPageElements( session('index_edit_lang'));

        return view('admin/index_page/index_edit', compact('index_sections'));
    }

    /**Tömbösítve visszaadja az index oldalon lévő típusokat slide, balolbecsúszós ....
     * @param $lang
     */
    private function getIndexPageElements($lang = hu){
        $index_sections = [];
        $index_pages = IndexPage::where('lang' ,$lang)
            ->with('slide')
            ->get();
//        dd($index_pages[1]->slide->getImageThumbUrl('image', 'admin_form_'));
        foreach ($index_pages as $item) {
            switch ($item->type) {
                case "slider_full_with":
                    $index_sections['slider_full_with'][] = $item;
                    break;
                case 'bootstrap_gallery':
                    $index_sections['bootstrap_gallery'][] = $item;
                    break;
                case 'mini_description':
                    $index_sections['mini_description'][] = $item;
                    break;
                case 'image_list_little':
                    $index_sections['image_list_little'][] = $item;
                    break;
                case 'image_list_little':
                    $index_sections['image_list_little'][] = $item;
                    break;
                case 'long_description_content_right':
                    $index_sections['long_description_content_right'][] = $item;
                    break;
                case 'long_description_content_left':
                    $index_sections['long_description_content_left'][] = $item;
                    break;
                case '2_button':
                    $index_sections['2_button'][] = $item;
                    break;
                case 'slogen':
                    $index_sections['slogen'][] = $item;
                    break;
            }
        }


        return $index_sections;
    }

    public function update(Request $request){
        $index_page_element = IndexPage::find($request->id);
        Log::info($request->all());
        if(is_null($index_page_element)){
            $index_page_element = new IndexPage();
            $index_page_element->lang = session('index_edit_lang');

            $index_page_element->fill($request->all())->save();
        }else{
            $index_page_element->fill($request->all())->update();
        }
        Flash::success('Sikeres módosítás');
         return redirect(URL::previous() .  '#element_form_id_'.$request->id);
    }

    public function store(Request $request){
        IndexPage::create([
            'lang' => session('index_edit_lang'),
            'type' => $request->type,
        ]);
        Flash::success('Sikeres létrehozás');
        return redirect(URL::previous() .  '#new_element_'.$request->type);

    }


    /** Teljes képernyős szlidert generál
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    public static function renderSliderFullWith(){
        return view('common/slider_full_with')->render();
    }


    /** Szerkesztésnél megváltoztatja a nyelvet
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeIndexEditLang(Request $request){

        session(['index_edit_lang' => $request->lang]);
        return redirect()->back();
    }

    public function delete(Request $request){
        $item = IndexPage::find($request->id);
        $item->delete();
        return redirect()->back();
    }

    /** Frontend oldalon elkészíti az index oldalt
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function renderPage(Request $request){
        if(!session()->has('lang')){
            session(['lang' => SystemController::getLang()]);
        }
        $index_sections = $this->getIndexPageElements(session('lang'));
        return view('page/index_page/index_page_content', compact('index_sections'));
    }
}
