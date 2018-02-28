<?php

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu_category = \App\Model\MenuCategory::create([
            'slug' => 'magyar_fomenu',
            'title' => 'Magyar főmenu',
            'lang' => 'hu',
        ]);

        \App\Model\Menu::create([
            'category_id' => $menu_category->id,
            'title' => 'Rólunk',
            'slug' => 'rolunk',
            'lang' => 'hu',
        ]);

        \App\Model\Menu::create([
            'category_id' => $menu_category->id,
            'title' => 'Szolgáltatásaink',
            'slug' => 'szolgaltatasaink',
            'lang' => 'hu',
        ]);


        $menu_category = \App\Model\MenuCategory::create([
            'slug' => 'en_main_menu',
            'title' => 'Angol főmenu',
            'lang' => 'en',
        ]);

        \App\Model\Menu::create([
            'category_id' => $menu_category->id,
            'title' => 'About us',
            'slug' => 'about_us',
            'lang' => 'en',
        ]);




    }
}
