<?php

use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\Model\Content::create([
            'title' => 'Rólunk',
            'slug' => 'rolunk',
            'content' => 'Mi vagyunk itten OLÉÉÉ',
            'lang' =>'hu',
            'lead' => 'lead',
        ]);
        \App\Model\Content::create([
            'title' => 'Rólunk Kettes Content',
            'slug'  => 'rolunk_kettes',
            'content' => 'Rólunk Kettes Content azta',
            'lang' =>'hu',
            'lead' => '',
        ]);


        \App\Model\Content::create([
            'title' => 'About us',
            'content' => 'About us Content',
            'lang' =>'en',
            'lead' => 'lead',
        ]);

    }
}
