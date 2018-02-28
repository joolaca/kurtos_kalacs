<?php

use App\Model\Lang;
use App\Model\Slide;
use Illuminate\Database\Seeder;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->ds = "/";

        $slider_gallery = \App\Model\Gallery::create([
            'title' => 'Index Slider Gallery'
        ]);

        $slider_category = \App\Model\Category::create([
            'title' => 'Index Slider Categiry',
            'type' =>'slide',
        ]);

        $langs = Lang::all();

        for($i=1;$i<4;$i++){
            $slide = new Slide();
            $slide->id = $i;
            $slide->category_id = $slider_category->id;
            $slide->image = 'page-1_slide01.jpg';
            $slide->file_dir = 'file'.$this->ds.'slides'.$this->ds.'0'.$this->ds.'000'.$slide->id.$this->ds.'';

            $slide->save();


            foreach ($langs as $lang) {
                \App\Model\SlideContent::create([
                    'slide_id' => $slide->id,
                    'lang' => $lang->lang,
                    'content' => '<h2>Index Slide '.$slide->id. '</h2>',
                    'title' => '<h2>Index Slide '.$slide->id. '</h2>',
                ]);
            }

            if (!file_exists(public_path($slide->file_dir))) {
                mkdir(public_path($slide->file_dir), 0777, true);
            }

            File::copy(public_path('assets/test_images/page-1_slide0'.$slide->id.'.jpg'), public_path($slide->file_dir . $slide->image));
            $slide->generateThumbnail();

            $slide->galleries()->attach($slider_gallery->id);
        }


        $slider_gallery = \App\Model\Gallery::create([
            'title' => 'Finomságok Gallery'
        ]);

        $slider_category = \App\Model\Category::create([
            'title' => 'Finomságok Categiry',
            'type' =>'slide',
        ]);


        for($i=4;$i<7;$i++){
            $slide = new Slide();
            $slide->id = $i;
            $slide->category_id = $slider_category->id;
            $slide->image = 'page-1_slide01.jpg';
            $slide->file_dir = 'file'.$this->ds.'slides'.$this->ds.'0'.$this->ds.'000'.$slide->id.$this->ds.'';

            $slide->save();


            foreach ($langs as $lang) {
                \App\Model\SlideContent::create([
                    'slide_id' => $slide->id,
                    'lang' => $lang->lang,
                    'content' => '<h2>Finomság'.$slide->id. '</h2>',
                    'title' => '<h2>Finomság Slide'.$slide->id. '</h2>',
                ]);
            }


            if (!file_exists(public_path($slide->file_dir))) {
                mkdir(public_path($slide->file_dir), 0777, true);
            }

            File::copy(public_path('assets/test_images/page-3_img'.$slide->id.'_original.jpg'), public_path($slide->file_dir . $slide->image));
            $slide->generateThumbnail();

            $slide->galleries()->attach($slider_gallery->id);
        }



    }
}
