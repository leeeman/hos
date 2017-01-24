<?php
namespace App\Libraries\Helpers;
use Illuminate\Support\Facades\Response as Resp;
class Response {
	public static $TYPE = 'JSON';
	
	public static function Success($msg='', $data=null){
		return Resp::json([
			'success'	=>	true, 
			'data'		=> 	$data,
			'msg'		=> 	$msg
		], 200);
	}

	public static function ValidationError($errors, $form='formid'){
		return Resp::json([
			'success'	=>	false, 
			'error' 	=> 	[$errors],
			'form'		=>	$form
		]);
	}

	public static function SimpleError($msg, $fieldname='field_name', $form='formid'){
		$error = [
					$fieldname	=>	[$msg] 
				];
		$error = json_encode($error);
		$errors = array($error);

		return Resp::json([
			'success'	=>	false, 
			'error' 	=> 	$errors,
			'form'		=>	$form
		], 200);
	}

	public static function ServerError($msg){
		return Resp::json([
			'success'	=>	false, 
			'msg' 	=> 	$msg,
		], 500);
	}

	public static function NotFound($msg){
	    return Resp::json([
	        	'success' => false,
	        	'msg' => $msg
	        ], 404);
	}

	public static function PreconditionFailed($msg){
	    return Resp::json([
	        	'success' => false,
	        	'msg' => $msg
	        ], 412);
	}


}