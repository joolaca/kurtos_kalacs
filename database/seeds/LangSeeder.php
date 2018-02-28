<?php

use Illuminate\Database\Seeder;

class LangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\Lang::create([
            'lang' => 'hu',
            'title' => 'Magyar',
        ]);
        \App\Model\Lang::create([
            'lang' => 'en',
            'title' => 'Angol',
        ]);
        \App\Model\Lang::create([
            'lang' => 'de',
            'title' => 'Német',
        ]);
        \App\Model\Lang::create([
            'lang' => 'jp',
            'title' => 'Japán',
            'body_class' => 'direction_rtl',
        ]);
        \App\Model\Lang::create([
            'lang' => 'ae',
            'title' => 'Arab',
            'body_class' => 'direction_rtl',
        ]);
    }
}
