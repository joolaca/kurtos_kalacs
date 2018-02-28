<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoogleMap extends Model
{
    /** Amikor egy menühöz hozzárendelünk egy galériát
     * akkor ezeket a választhatjuk ki hogy milyen módon rendelelődjön FE en
     * admin/menu/1/edit
     * @return array
     */
    public function getAttachType(){
        return [

        ];
    }
}
