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
class StockController extends Controller {
	
	public function getManageStock(){
		 $stock = DB::table('menus as s')
		 					->join('menu_categories','s.cat_id','=','menu_categories.id')
		 					->select('s.*','menu_categories.name as cat_name')
                            ->where('s.status', 'ACTIVE')
                            ->get();
		/*$stock = DB::table('menus')->get();*/
		return View::make('StockMain',compact('stock'));

	}

	public function getAll(){
		$result = DB::table('menus')->get();
		return Response::json(array('success'=>true, 'error' => 'no error', 'msg' => $result));
	}

	public function getCatById(Request $req){

		if(Input::has('cat_id')){
			$id = Input::get('cat_id');
			$data = DB::table('menus')
			->where('cat_id', $id)
			->get();
			return Response::json(array('success'=>true, 'error' => 'no error', 'data' => $data));
		}
		else{
			$id = 0;
			return Response::json(array('success'=>false, 'error' => 'Nothing Found'));
		}

		
	}
	public function getNewStock(){
		if(Input::has('id')){
			$id = Input::get('id');
		}
		else{
			$id = 0;
		}

		$data = DB::table('menus')
			->where('id', $id)
			->first();		
		
/**/

		$cats = DB::table('menu_categories')
                ->where('status', 'active')
                ->where('parent_id',0)
                ->get();
		return View::make('add_stock', compact('data', 'cats'));	
	}

	public function postSaveStock(Request $req){
		$prefix = 'YZ-';
		$data = $req->all();
		unset($data['_token']);

		$v = Validator::make( $data, [
			'cat_id' 	=> 'required|integer',
			// 'code' 		=> 'required|string',
			'name'		=> 'required|string',
			
				
			
		]);
		
		if(!$v->passes()) {
			$msg = $v->messages()->toJson();
			return Response::json(array('success'=>false, 'error' => array($msg)));
		}

		if( Input::get('id') > 0){
			$update = DB::table('menus')
				->where('id', $req->input('id'))
				->update($data);
			$id = $req->input('id');
			
		} else{
			$id = DB::table('menus')
				->insertGetId($data);

			
			
			
			
			
		}
		return Response::json(array('success'=>true, 'error' => 'no error', 'msg'=>'Menu Added successfully'));
	}

	public function getEditStock(Request $req){

		$v = Validator::make( $req->all(), [
			'id' => 'required|integer'
		]);
		if(!$v->passes()) {
			$msg = $v->messages()->toJson();
			return Response::json(array('success'=>false, 'error' => array($msg)));
		}
		if(Input::has('id')){
			$id = Input::get('id');
		}
			$data = DB::table('menus')
			->where('id', $id)
			->first();

			

		    $cats = DB::table('menu_categories')
                ->where('status', 'active')
                ->where('parent_id',0)
                ->get();

			return View::make('edit_stock', compact('data', 'supplier', 'cats'));	
		
	}

	public function postEditStock(Request $req){
		$data = $req->all();
		$id=Input::get('p_id');
		unset($data['_token']);

		$v = Validator::make( $data, [
			'cat_id' 	=> 'required|integer',
			// 'code' 		=> 'required|string',
			'name'		=> 'required|string',
			
				
			
		]);
		
		if(!$v->passes()) {
			$msg = $v->messages()->toJson();
			return Response::json(array('success'=>false, 'error' => array($msg)));
		}


		if( $id > 0){
			unset($data['m_id']);
			unset($data['p_id']);
			$data['id']=$id;
			$update = DB::table('menus')
				->where('id', $req->input('p_id'))
				->update($data);
				return Response::json(array('success'=>true, 'error' => 'no error', 'msg'=>'Changes saved'));
		} 
		
	}

	public function postDeleteStock(Request $req){
		$v = Validator::make( $req->all(), [
			'id' => 'required|integer'
		]);
		if(!$v->passes()) {
			$msg = $v->messages()->toJson();
			return Response::json(array('success'=>false, 'error' => array($msg)));
		}
		$delete = DB::table('menus')
			->where('id', Input::get('id'))
			// ->update(['status'=>'ACTIVE'])
			->delete()
			;
		if( $delete )
			return Response::json(array('success'=>true, 'error' => 'no error', 'msg'=>'Deleted successfully!'));
		else
			return Response::json(array('success'=>false, 'error' => "Cant't Delete"));		
	}

	public function getManageCategories(){
		 $cats = DB::table('menu_categories')
                            ->where('status', 'active')
                            ->where('parent_id',0)
                            ->get();
		return View::make('StockCategoryMain',compact('cats'));
	}


	public function Categories(){
		 $cats = DB::table('menu_categories')
                            ->where('status', 'active')
                            ->where('parent_id',0)
                            ->get();
		return $cats;
	}	

	public function getEditStockCategory(){
		$cat = DB::table('menu_categories')
                ->where('id', Input::get('id'))
                ->first();
		return View::make('EditStockCategory', compact('cat'));
		
	}	

	public function getNewStockCategory(){
		return View::make('NewStockCategory');
	}	
	
	public function postSaveStockCategory(Request $req){
		
		$data = $req->all();
		unset($data['_token']);

		$v = Validator::make( $data, [
			'name' 		=> 'required|string',
		]);
		
		if(!$v->passes()) {
			$msg = $v->messages()->toJson();
			return Response::json(array('success'=>false, 'error' => array($msg)));
		}

		if( Input::get('id') > 0){
			$update = DB::table('menu_categories')
				->where('id', $req->input('id'))
				->update($data)
			;
			$id = $req->input('id');
		} else{
			DB::beginTransaction();
			try{
				$id = DB::table('menu_categories')
					->insertGetId($data)
				;

				
				DB::commit();
			} catch(\Exception $e){
				DB::rollback();
				return Response::json(array('success'=>false, 'error' => 'Error in storing'));		
			}
		}
		return Response::json(array('success'=>true, 'error' => 'no error', 'msg'=>'Changes saved.'));
	}	

  public function postSaveSession(Request $req){
		
		$data = $req->all();
		//dd($data);
		if(Session::has('Order_Data')){
			//Session::push('Order_Data', $data['data']);
			$data_arr=Session::get('Order_Data');
			$res=array_merge($data_arr,$data['data']);
			//dd($res);
			$res=array_map("unserialize", array_unique(array_map("serialize", $res)));
			Session::put('Order_Data', $res);
		}else{
			Session::put('Order_Data', $data['data']);
	 	}
		//Session::forget('key');
		return Response::json(array('success'=>true, 'error' => 'no error', 'msg'=>'Order is saved'));
  	
  }

  public function postRemoveSession(Request $req){
		
		
		//dd($data);
		
		Session::forget('Order_Data');
		return Response::json(array('success'=>true, 'error' => 'no error', 'msg'=>'Order is removed'));
  	
  }

}
