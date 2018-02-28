<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017.03.01.
 * Time: 14:43
 */

namespace App\Http\Fields;

/**
 * Class VideoField - Videó feltöltés mező
 * @package App\Http\Fields
 */
class VideoField extends FileField
{
    protected $type = 'video';
	protected $validation_rules = 'mimes:mp4,mov,ogg,qt'; // mime type ellenörzések

}