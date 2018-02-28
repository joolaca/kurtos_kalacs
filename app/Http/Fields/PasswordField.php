<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017.03.01.
 * Time: 14:43
 */

namespace App\Http\Fields;

/**
 * Class PasswordField - Jelszó mező
 * @package App\Http\Fields
 */
class PasswordField extends TextField
{
    protected $hide_index = TRUE;

    protected $type = 'password';
	protected $icon = 'lock';
    protected $attributes = ['class' => 'form-control input-xlarge password_input'];

    protected $blade_edit_location = 'common/fields/edit_elements/password';

    public function getFormHtml($item = null){

        $field = $this;
        return view($this->getBladeEditLocation() , compact('field', 'item'))->render();

    }

}