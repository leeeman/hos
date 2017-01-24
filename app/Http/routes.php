<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::filter('authenticate', function(){
	// DB::statement('call update_fine()');
	if ( !Session::has('username') ){
		
		return Redirect::to('/');
	}
});

Route::get('/', array('as'=>'signin', 'uses'=>'MainController@get_index'));

Route::get('unauthorized', function(){
	return View::make('unauthorized');
});
/*Route::post('/', array('uses'=>'MainController@post_index'));*/

Route::post('Signin', array('uses'=>'MainController@post_index'));

Route::group(['before' => 'authenticate'], function(){

	Route::get('logout', function(){
		Session::flush();
		return Redirect::to('/');
	});

	Route::controller('stock', 'StockController');
	
	
	Route::controller('admin', 'AdminController');
	
	Route::get('dashboard', function () {
    return view('index');
 });

Route::get('customer', function () {
	$cats= DB::table('menu_categories')
                            ->where('status', 'active')
                            ->where('parent_id',0)
                            ->get();
    //dd(Session::all());   
    $Order_Data=0;                    
    return view('index1',compact('cats'));
 });

    Route::get('waiter', function () {
    return view('index2');

});

});//main group


/*Route::get('/', function () {
    return view('login');
});*/
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
Route::get('test',function(){
	/*$data = DB::table('payments')
	->groupBy('id')
	->select(DB::raw('id, count(1) as rows'))
	->lists('rows', 'id');
	dd($data['9']);*/

	return CodeGen::poCode();
});


Route::get('test1',function(){
	/*$data = DB::table('keys as k')
	->join('userdetails as ud','k.user_id','=','ud.user_id')
	->join('user_plans as up','k.user_id','=','up.user_id')
	->select('k.user_id as user_id',DB::raw("DATE_FORMAT(FROM_UNIXTIME(k.date_created), '%Y-%m-%d') AS creat_at"),DB::raw("DATE_FORMAT(FROM_UNIXTIME(up.start_date), '%Y-%m-%d') AS p_start"),DB::raw("DATE_FORMAT(FROM_UNIXTIME(up.end_date), '%Y-%m-%d') AS p_end"),'ud.user_name')
	->get();*/
	//$newfile='user_detail.json';
	//Storage::put($newfile, json_encode($data));
  /*$csv="User_Id,User_Name,Creat_At,Plan_Start,Plan_End".PHP_EOL;

	foreach($data as $new_data){

		$csv.=$new_data->user_id.',"';
		$csv.=$new_data->user_name.'",';
		$csv.=$new_data->creat_at.',';
		$csv.=$new_data->p_start.',';
		$csv.=$new_data->p_end.PHP_EOL;
	}
	$filename="new_user_details.csv";
	Storage::put($filename, $csv);*/
	//dd($data);

	//return CodeGen::poCode();
});
