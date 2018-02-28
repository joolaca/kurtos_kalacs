<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017.03.01.
 * Time: 14:43
 */

namespace App\Http\Fields;

/**
 * Class DatetimeField - Email text field
 * @package App\Http\Fields
 */
class EmailField extends TextField
{
    protected $type = 'email';
	protected $icon = 'envelope';
}