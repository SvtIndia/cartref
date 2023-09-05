<?php

namespace App\Http\Controllers\Api\V1;

use App\Size;
use App\ProductSubcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DependentDropdownController extends Controller {
    
	public function index() {
		
		$params = request()->all();
		
		if(!empty($params['options']['wherehas']))
		{
		// dropdown for all other which is dependant on subcategory dropdown - except from sizes dropdown

			if($params['options']['wherehas'] == 'productsizes')
			{
				$options = app($params['model'])::whereHas($params['options']['wherehas'], function($q) use($params){
					$q->where('status', 1)->where('id', '=', $params['value']);
				})
				->get()
				->pluck($params['options']['label'], $params['options']['key']);
			}else{
				$options = app($params['model'])::whereHas($params['options']['wherehas'], function($q) use($params){
					$q->where('status', 1)->where('id', '=', $params['value']);
				})
				->get()
				->pluck($params['options']['label'], $params['options']['key']);
			}
			
		}else{
		// dropdown which is dependant on previous dropdown
			$options = app($params['model'])
			->where($params['options']['where'], '=', $params['value'])
			->pluck($params['options']['label'], $params['options']['key']);

		}
		
		return response()->json([
			'dropdown' => sprintf('#%s', $params['options']['name']),
			'options' => $options
		], 200);
	
	}
}