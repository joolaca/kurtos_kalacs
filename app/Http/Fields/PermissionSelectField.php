<?php
/**
 * Created by PhpStorm.
 * User: erik
 * Date: 3/20/17
 * Time: 4:07 PM
 */

namespace App\Http\Fields;


use App\Model\Permission;
use Illuminate\Support\Facades\Auth;

/**
 * Class PermissionSelectField - Jogosultsághoz kötött select mező
 * @package App\Http\Fields
 */
class PermissionSelectField extends SelectField
{
    protected $type = 'permission_select';

    protected $blade_edit_location = 'common/fields/edit_elements/permissionselect';


    /**
	 * HTML Form-okhoz. A belépet felhasználó jogolutságainek megfeleő options tömböt készít.
	 * @param Collection $options
	 *
     * @return \Illuminate\Http\Response
     */
	public function setOptions($options) {


		if(!empty($options)) {
			foreach($options as $option) {
				$permission = Permission::where('slug', '=', $option->slug)->first();
				if(!empty($permission))
					{
						if(Auth::user()->allowedPermission($permission->slug))
							{
								$this->options[$option->id] = $option->name;
							}
					}
				else
					{
						$this->options[$option->id] = $option->name;
					}
			}
		}
		return $this;
	}

    /**
	 * HTML Form-okhoz
	 * @param $item
	 *
     * @return \Illuminate\Http\Response
     */
    public function getFormHtml($item = null){

		//var_dump($item);die;
        $value = '';
        if(!is_null($item)){
            $value = $item->{$this->getName()};
        }elseif (isset($this->default)){
            $value = $this->default;
        }

        $options = $this->options;


        $field = $this;
        return view($this->getBladeEditLocation() , compact('field', 'options', 'value'))->render();
    }
}