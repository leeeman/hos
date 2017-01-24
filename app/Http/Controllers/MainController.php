<?php 
#namespace & use
	namespace App\Http\Controllers;
	use Illuminate\Support\Facades\Input;
	use Illuminate\Support\Facades\Validator;
	use Illuminate\Support\Facades\Session;
	use Illuminate\Support\Facades\Response;
	use View;
	use DB;
	use TCPDF;

class MainController extends Controller {
	
	public function get_index(){
		return View::make('login');	
	}

	public function post_index(){
		$data = array
					(
						'username'=> Input::get('user_login'), 
						'password'=> Input::get('user_password')
						
					);

		$rules = array
					(	
						'username' => 'required|min:4',
						'password' => 'required|min:4'
					);

		$validator = Validator::make($data, $rules);

		if($validator->passes()){
			//if($data['login_type']=='admin'){
			$user = DB::table('app_users')
				->where('username', $data['username'])
				->where('password', $data['password'])
				->first();
			/*}else{
				$user=DB::table('employees')
				->where('username', $data['username'])
				->where('password', $data['password'])
				->first();
			}*/
			if(count($user) > 0){
				Session::start();
				Session::put('username', $data['username']);
				Session::put('role_id', $user->role_id);
				
				return Response::json(['success' => true, 'role_id'=> $user->role_id, 'error' => 'No Error']);
				//return View::make('index')->with('title', 'JST Pharma');
			}else{
				$msg = $validator->messages()->toJson();
				return Response::json(['success' => false, 'error' => array($msg)]);
			}
		}
		else{
			$msg = $validator->messages()->toJson();
			return Response::json(array('success'=>false, 'error' => array($msg)));
		}//if validator->passes()
	}

	public function Dashboard(){
		return View::make('dasboard');
	}

	public static function print_general($html, $page_orientation = 'P'){
		//------------------------------------------------------------------------------------------------------
		$pdf = new TCPDF($page_orientation, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// set margins
		$pdf->SetMargins(8, 8, 8);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 8);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		    require_once(dirname(__FILE__).'/lang/eng.php');
		    $pdf->setLanguageArray($l);
		}
		

		$pdf->AddPage();
		$pdf->SetFont('calibri', '', 10, '', false);
		$pdf->setFontSubsetting(false); 


		$pdf->writeHTML($html, true, false, true, false, '');
		//$pdf->writeHTMLCell($w=280, $h=190, '', '', $html=$html, $border=1, $ln=0, $fill=false, $reseth=true, $align='L', $autopadding=true);

		return $pdf->Output('FeeDefaulters.pdf', 'I');
	}

}
