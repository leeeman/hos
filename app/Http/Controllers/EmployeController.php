<?php 
#namespace & use
	namespace App\Http\Controllers;
	use Illuminate\Support\Facades\Input;
	use Illuminate\Support\Facades\Validator;
	use Illuminate\Support\Facades\Session;
	use Illuminate\Support\Facades\Response;
	use Illuminate\Http\Request;
	use View;
	use DB;
	use TCPDF;
class EmployeController extends Controller {
	
	public function getEmployeesMain(){	
		$data = DB::table('employees as emp' )
		->leftJoin('employe_type as empt','empt.id','=','employe_type_id')
		->select('emp.*', 'empt.label as desi')
		->get();
		return view('EmployeMain')->with('data', $data);		
	}

	

	public function getNewEmploye(){
		if(Input::has('id')){
			$id = Input::get('id');
		}
		else{
			$id = 0;
		}

		
		$et = DB::table('employe_type')
		->get();
		return View::make('add_employe')->with('et', $et);
	}


	public function getEditEmploye(Request $req){

		if(Input::has('id')){
			$id = Input::get('id');
		}
		else{
			$id = 0;
		}

		$data = DB::table('employees')
			->where('id', $id)
			->first();

		$et = DB::table('employe_type')
		->get();
		return View::make('edit_employe')->with('data',$data)->with('et', $et);
	}

	public function postSaveEmploye(Request $req){
		$data = $req->all();
		unset($data['_token']);

		$v = Validator::make( $data, [
			'name' 			=> 'required|string',
			'contact_1' 	=> 'required|string'
		]);

		if(!$v->passes()) {
			$msg = $v->messages()->toJson();
			return Response::json(array('success'=>false, 'error' => array($msg)));
		}

		if( Input::get('id') > 0){
			$update = DB::table('employees')
				->where('id', $req->input('id'))
				->update($data)
			;
		} else{
			$insert = DB::table('employees')
				->insertGetId($data)
			;
		}
		return Response::json(array('success'=>true, 'error' => 'no error', 'msg'=>'Changes saved'));
	}


	public function getNewAppuser(){

		$employe = DB::table('employees')
		->get();
		$emp_role=DB::table('roles')
		->get();
		return View::make('add_admin_users',compact('employe','emp_role'));
	}

	public function postAppUser(Request $req){

		if(Input::has('emp_id')){
			$id = Input::get('emp_id');
			$get_app_data=DB::table('app_users')
				->where('emp_id', $req->input('emp_id'))
				->first();
			if(count($get_app_data)==0){

				$get_app_data=null;				
			}	
			return Response::json(array('success'=>true, 'app_data' =>$get_app_data));

		}
		else{
			$id = 0;
			return Response::json(array('success'=>false, 'error' => 'Not a Valid User'));
		}


	}
	public function postSaveAppuser(Request $req){

		$data = $req->all();
		unset($data['_token']);

		$v = Validator::make( $data, [
			'username' 			=> 'required|string',
			'password' 	=> 'required|string',
			'emp_id'=>'required|string'
		]);

		if(!$v->passes()) {
			$msg = $v->messages()->toJson();
			return Response::json(array('success'=>false, 'error' => array($msg)));
		}

		$emp_data = DB::table('employees')
                ->where('id', Input::get('emp_id'))
                ->first();
        if(!count($emp_data)){
        $resp=array('msg'=>"Employe not exist");
        return Response::json(array('success'=>false, 'error' =>$resp));		
        }  else{

        	$data['email_address']=$emp_data->email;

        }      
         $update=0;       
		if( Input::get('emp_id') > 0){
			$update = DB::table('app_users')
				->where('emp_id', Input::get('emp_id'))
				->update($data);
				//dd($update);
			if($update>0){
				return Response::json(array('success'=>true, 'error' => 'no error', 'msg'=>'Changes update'));
			}
		} if($update==0){
			$insert = DB::table('app_users')
				->insertGetId($data);
		return Response::json(array('success'=>true, 'error' => 'no error', 'msg'=>'Added new app user'));		
				dd($insert);
		}
		

	}

	public function getEmployeCategoryMain(){
		 $cats = DB::table('employe_type')                        
                            ->get();
		return View::make('EmployeCategoryMain',compact('cats'));
	}

	public function getEditEmployeCategory(){
		$cat = DB::table('employe_type')
                ->where('id', Input::get('id'))
                ->first();
		return View::make('EditEmployeCategory', compact('cat'));
		
	}	

	public function getNewEmployeCategory(){
		return View::make('NewEmployeCategory');
	}	
	
	public function postSaveEmployeCategory(Request $req){
		$data = $req->all();
		unset($data['_token']);

		$v = Validator::make( $data, [
			'type' 	=> 'required|string',
			'label' 		=> 'required|string',
		]);
		
		if(!$v->passes()) {
			$msg = $v->messages()->toJson();
			return Response::json(array('success'=>false, 'error' => array($msg)));
		}

		if( Input::get('id') > 0){
			$update = DB::table('employe_type')
				->where('id', $req->input('id'))
				->update($data)
			;
		} else{
			$insert = DB::table('employe_type')
				->insertGetId($data)
			;
		}
		return Response::json(array('success'=>true, 'error' => 'no error', 'msg'=>'Changes saved'));
	}		
}
