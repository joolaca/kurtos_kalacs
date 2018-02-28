<?php

use Illuminate\Database\Seeder;

class IndexPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $gallery = \App\Model\Gallery::where('slug', 'index_slider_gallery')->first();

        //slider_full_with
        \App\Model\IndexPage::create([
            'lang'  => 'hu',
            'type'  => 'slider_full_with',
            'gallery_id' =>$gallery->id,
        ]);

        //mini_description
        for($i=1; $i<4;$i++){
            \App\Model\IndexPage::create([
                'lang' => 'hu',
                'type' => 'mini_description',
                'slide_id' => $i,
                'content' => 'mini_description content '.$i,
                'title' => 'title '.$i,
                'href'  => 'href '.$i,
            ]);
        }

        //image_list_little
        for($i=1; $i<4;$i++){
            \App\Model\IndexPage::create([
                'lang' => 'hu',
                'type' => 'image_list_little',
                'slide_id' => $i,
                'content' => 'image_list_little content '.$i,
                'title' => 'title '.$i,
                'href'  => 'href '.$i,
            ]);
        }

        //long_description_content_right
        \App\Model\IndexPage::create([
            'lang' => 'hu',
            'type' => 'long_description_content_right',
            'slide_id' => 1,
            'content' => 'long_description_content_right content '.$i,
            'title' => 'long_description_content_right title '.$i,
            'href'  => 'long_description_content_right href '.$i,
        ]);

        //long_description_content_left
        \App\Model\IndexPage::create([
            'lang' => 'hu',
            'type' => 'long_description_content_left',
            'slide_id' => 2,
            'content' => 'long_description_content_left content '.$i,
            'title' => 'long_description_content_left title '.$i,
            'href'  => 'long_description_content_left href '.$i,
        ]);

        //2_button
        \App\Model\IndexPage::create([
            'lang' => 'hu',
            'type' => '2_button',
            'content' => '2_button content '.$i,
            'title' => '2_button title '.$i,
            'href'  => '2_button href '.$i,
            'href2'  => '2_button href '.$i,
        ]);
        //slogen
        \App\Model\IndexPage::create([
            'lang' => 'hu',
            'type' => 'slogan',
            'slide_id' => 1,
            'content' => 'slogan content '.$i,
            'title' => '',
            'href'  => '',
        ]);
    }
}
