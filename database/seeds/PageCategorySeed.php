<?php

use Illuminate\Database\Seeder;

class PageCategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\PageCategory::create([
            'slug' => 'gallery',
            'name' => 'Galéria',
            'lang' => 'hu',
        ]);
        \App\Model\PageCategory::create([
            'slug' => 'about_us',
            'name' => 'Rólunk',
            'lang' => 'hu',
        ]);
    }
}
