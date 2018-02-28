<?php

use App\Model\Content;
use Illuminate\Database\Seeder;

class ContentMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $about_us = \App\Model\Menu::where('slug', 'rolunk')->first();
        $contents = Content::where('slug', 'Like', '%rolunk%')->get();

        foreach ($contents as $content) {
            DB::Table('content_menu')->insert([
                'menu_id' => $about_us->id,
                'related_id' => $content->id,
                'content_controller' => '\\App\\Http\\Controllers\\CRUD\\ContentController',
                'type' => 'normal',
            ]);
        }

    }
}
