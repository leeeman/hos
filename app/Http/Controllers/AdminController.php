<?php 
#namespace & use
	namespace App\Http\Controllers;
	use Illuminate\Support\Facades\Input;
	use Illuminate\Support\Facades\Validator;
	use Illuminate\Support\Facades\Session;
	use App\Libraries\Helpers\Response;
	use Illuminate\Http\Request;
	use View;
	use DB;
	use Helper;
class AdminController extends Controller {
	public function getRoles(){
		$data = DB::table('roles')->get();
		return View::make('RolesMain', compact('data'));
	}

	public function getUserPrivileges(){
		if(!Input::has('role_id')){
			$role_id = DB::table('roles')->where('full_name', 'new')->pluck('id');
			if($role_id == null){
				$role_id = DB::table('roles')->insertGetId(['full_name'=>'new']);
				$query = "INSERT INTO privileges(uri, method, access, function_id, role_id, type)	
				SELECT uri, method, 0, function_id, $role_id, type FROM privileges WHERE role_id = 1
				";	
				DB::statement(DB::raw($query));
			}
		}
		$role_id = Input::get('role_id');
		$role_data = DB::table('roles')->where('id', $role_id)->first();
		
		$query =
		"SELECT 
			p.role_id, p.function_id, pf.category_id, pfc.name as category, pf.name as function, 
		    GROUP_CONCAT(if(type = 'V', access, NULL)) AS 'View', 
		    GROUP_CONCAT(if(type = 'A', access, NULL)) AS 'Add', 
		    GROUP_CONCAT(if(type = 'E', access, NULL)) AS 'Edit',
		    GROUP_CONCAT(if(type = 'D', access, NULL)) AS 'Delete'
		FROM 
			privileges as p
		INNER JOIN privileges_functions as pf ON p.function_id = pf.id
		INNER JOIN pf_categories as pfc ON pf.category_id = pfc.id
		WHERE 
			p.role_id = $role_id
		GROUP BY
			p.role_id, p.function_id, pf.category_id, pf.name";

		$data = DB::select(DB::raw($query));
		// dd($data);
		return View::make('UserPrivileges',compact('data', 'role_data'));
	}

	public function postSaveRole(Request $request){
		$data = $request->all();
		$v = Validator::make($data, [
			'role_name'		=> 	'required'
		]);

		if($v->fails()){
			$msg = $v->messages()->toJson();
			return Response::ValidationError($msg);
		}
		$role_name = $data['role_name'];
		unset($data['role_name']);
		$role_short_name = $data['role_short_name'];
		unset($data['role_short_name']);

		$role_id = $data['role_id'];
		unset($data['role_id']);


		DB::beginTransaction();
		try{
			DB::table('roles')
			->where('id', $role_id)
			->update(['full_name'=>$role_name, 'short_name'=>$role_short_name]);
			
			DB::table('privileges')
			->where('role_id', $role_id)
			->update(['access'=>0]);

			foreach ($data as $k=>$v) {
				$type = explode('_', $k)[0];
				$function_id = explode('_', $k)[1];
				DB::table('privileges')
				->where('function_id', $function_id)
				->where('type', $type)
				->where('role_id', $role_id)
				->update(['access'=>1]);
			}
			DB::commit();
			return Response::Success('Changes Saved Successfully');
		} catch(\Exception $e){
			DB::rollback();
			dd($e);
		}
	}
	
	public function getNewRole(){

		return view::make('NewappuserRole');
	}

	public function postSaveAppRole(Request $request){
		$data = $request->all();
		$v = Validator::make($data, [
			'full_name'		=> 	'required',
			'short_name'    => 	'required'
		]);

		if($v->fails()){
			$msg = $v->messages()->toJson();
			return Response::ValidationError($msg);
		}

		DB::beginTransaction();
		try{
			$id = DB::table('roles')
					->insertGetId($data)
				;

			$query = "
				INSERT INTO privileges(uri, method, access, function_id, type, role_id)
				SELECT uri, method, 0, function_id, type, $id
				FROM privileges
				WHERE role_id = 1
			";

			DB::statement($query);
			DB::commit();
		} catch(\Exception $e){
			DB::rollback();
		}

		return Response::Success('Changes Saved Successfully');
	}
}
