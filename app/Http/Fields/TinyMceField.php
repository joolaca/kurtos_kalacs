<?php

namespace App\Http\Fields;

/**
 * Class TinyMceField - WYSIWYG szöveg doboz mező
 * @package App\Http\Fields
 */
class TinyMceField extends TextareaField
{

    protected $type = 'textarea';

	protected $attributes = [
		'class' => 'tinymce',
	];
}