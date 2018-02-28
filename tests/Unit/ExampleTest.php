<?php

namespace Tests\Unit;

use App\Helper\StrHelper;
use App\Model\Content;
use App\Model\Gallery;
use App\Model\Menu;
use App\Model\Slide;
use App\Model\Thumbnail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {

        $test = Slide::find(1);
        dd($test->content('hu')->first()->toArray());
    }
}
