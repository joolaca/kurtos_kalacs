<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017.03.01.
 * Time: 14:43
 */

namespace App\Http\Fields;

/**
 * Class DatetimeField - Naptáros dátum választó
 * @package App\Http\Fields
 */
class DatetimeField extends DateField
{
    protected $type = 'datetimepicker';
    protected $attributes = ['class' => 'form-control datetimepicker'];

    protected $blade_edit_location = 'common/fields/edit_elements/datetime';

}