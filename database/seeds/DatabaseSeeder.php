<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserSeeder::class);
         $this->call(MenuSeeder::class);
         $this->call(ContentSeeder::class);
         $this->call(ContentMenuSeeder::class);
         $this->call(LangSeeder::class);
         $this->call(CategorySeeder::class);
         $this->call(ThumbnailSeeder::class);
         $this->call(SlideSeeder::class);
         $this->call(IndexPageSeeder::class);



    }
}
