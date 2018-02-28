<?php

use App\Model\ThumbnailSize;
use Illuminate\Database\Seeder;

class ThumbnailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        ThumbnailSize::create([
            'title' => '100 x 50',
            'prefix' => '100_50_',
            'width' => '100',
            'height' => '50',
            'description' => 'Admin Listanézet',
        ]);

        ThumbnailSize::create([
            'title' => '400 x 200',
            'prefix' => '400_200_',
            'width' => '400',
            'height' => '200',
            'description' => 'Crud create edit megjelenés',
        ]);
        ThumbnailSize::create([
            'title' => '2050 x 550',
            'prefix' => '2050_550_',
            'width' => '2050',
            'height' => '550',
            'description' => 'FE Slider',
        ]);
        ThumbnailSize::create([
            'title' => '370 x 290',
            'prefix' => '370_290_',
            'width' => '370',
            'height' => '290',
            'description' => 'FE mini_description',
        ]);
    }
}
