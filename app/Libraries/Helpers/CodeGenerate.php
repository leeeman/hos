<?php
namespace App\Libraries\Helpers;
use DB;
use Storage;
use Carbon\Carbon;
class CodeGenerate {
	
	

	public static function rfqCode() {	

		 $fname = storage_path().DIRECTORY_SEPARATOR."app".DIRECTORY_SEPARATOR."gen_code".DIRECTORY_SEPARATOR."RFQCodes.json";
		 //dd($fname);
		 $file = fopen($fname,"r+");
		 $block = 1; //block other processes

		 // exclusive lock
		 if( flock($file,LOCK_EX, $block) ){
		  $data = fread($file, 2048);
		  $data = json_decode($data, false);
		    
		  if(date('Y-m-d', strtotime($data->date)) != date('Y-m-d')){
		   $data->date = date('Y-m-d');
		   $data->counter = 1;
		   $code = 'RFQ-'.date('Ymd').'-'.$data->counter;
		  } else{
		  	$data->counter += 1;
		   $code = 'RFQ-'.date('Ymd').'-'.$data->counter;
		   //$data->counter += 1;
		  }

          //sleep(5);
		  ftruncate($file, 0);
		  rewind($file);
		  fwrite($file, json_encode($data));
		  return $code;
		 } else {
		  echo "Error locking file!";
		 }

		 // release lock
		 flock($file,LOCK_UN);
		 // echo '\nReleased: '.date('h:i:s');
		 fclose($file);

		
}

	public static function poCode(){

		 $fname = storage_path().DIRECTORY_SEPARATOR."app".DIRECTORY_SEPARATOR."gen_code".DIRECTORY_SEPARATOR."POCodes.json";
		 $file = fopen($fname,"r+");
		 $block = 1; //block other processes

		 // exclusive lock
		 if( flock($file,LOCK_EX, $block) ){
		  $data = fread($file, 2048);
		  $data = json_decode($data, false);
		    
		  if(date('Y-m-d', strtotime($data->date)) != date('Y-m-d')){
		   $data->date = date('Y-m-d');
		   $data->counter = 1;
		   $code = 'PO-'.date('Ymd').'-'.$data->counter;
		  } else{
		   $data->counter += 1;
		   $code = 'PO-'.date('Ymd').'-'.$data->counter;
		   //$data->counter += 1;
		  }

          //sleep(5);
		  ftruncate($file, 0);
		  rewind($file);
		  fwrite($file, json_encode($data));
		  return $code;
		 } else {
		  echo "Error locking file!";
		 }

		 // release lock
		 flock($file,LOCK_UN);
		 // echo '\nReleased: '.date('h:i:s');
		 fclose($file);
	}

	public static function grCode(){


		$fname = storage_path().DIRECTORY_SEPARATOR."app".DIRECTORY_SEPARATOR."gen_code".DIRECTORY_SEPARATOR."GRCodes.json";
		 //dd($fname);
		 $file = fopen($fname,"r+");
		 $block = 1; //block other processes

		 // exclusive lock
		 if( flock($file,LOCK_EX, $block) ){
		  $data = fread($file, 2048);
		  $data = json_decode($data, false);
		    
		  if(date('Y-m-d', strtotime($data->date)) != date('Y-m-d')){
		   $data->date = date('Y-m-d');
		   $data->counter = 1;
		   $code = 'GR-'.date('Ymd').'-'.$data->counter;
		  } else{
		   $data->counter += 1;
		   $code = 'GR-'.date('Ymd').'-'.$data->counter;
		   //$data->counter += 1;
		  }

          //sleep(5);
		  ftruncate($file, 0);
		  rewind($file);
		  fwrite($file, json_encode($data));
		  return $code;
		 } else {
		  echo "Error locking file!";
		 }

		 // release lock
		 flock($file,LOCK_UN);
		 // echo '\nReleased: '.date('h:i:s');
		 fclose($file);


	}
	public static function soCode(){


		$fname = storage_path().DIRECTORY_SEPARATOR."app".DIRECTORY_SEPARATOR."gen_code".DIRECTORY_SEPARATOR."SOCodes.json";
		 //dd($fname);
		 $file = fopen($fname,"r+");
		 $block = 1; //block other processes

		 // exclusive lock
		 if( flock($file,LOCK_EX, $block) ){
		  $data = fread($file, 2048);
		  $data = json_decode($data, false);
		    
		  if(date('Y-m-d', strtotime($data->date)) != date('Y-m-d')){
		   $data->date = date('Y-m-d');
		   $data->counter = 1;
		   $code = 'SO-'.date('Ymd').'-'.$data->counter;
		  } else{
		  	$data->counter += 1;
		   $code = 'SO-'.date('Ymd').'-'.$data->counter;
		   //$data->counter += 1;
		  }

          //sleep(5);
		  ftruncate($file, 0);
		  rewind($file);
		  fwrite($file, json_encode($data));
		  return $code;
		 } else {
		  echo "Error locking file!";
		 }

		 // release lock
		 flock($file,LOCK_UN);
		 // echo '\nReleased: '.date('h:i:s');
		 fclose($file);


	}
	public static function piCode(){

		$fname = storage_path().DIRECTORY_SEPARATOR."app".DIRECTORY_SEPARATOR."gen_code".DIRECTORY_SEPARATOR."PICodes.json";
		 //dd($fname);
		 $file = fopen($fname,"r+");
		 $block = 1; //block other processes

		 // exclusive lock
		 if( flock($file,LOCK_EX, $block) ){
		  $data = fread($file, 2048);
		  $data = json_decode($data, false);
		    
		  if(date('Y-m-d', strtotime($data->date)) != date('Y-m-d')){
		   $data->date = date('Y-m-d');
		   $data->counter = 1;
		   $code = 'PI-'.date('Ymd').'-'.$data->counter;
		  } else{
		  	$data->counter += 1;
		   $code = 'PI-'.date('Ymd').'-'.$data->counter;
		   
		  }

          //sleep(5);
		  ftruncate($file, 0);
		  rewind($file);
		  fwrite($file, json_encode($data));
		  return $code;
		 } else {
		  echo "Error locking file!";
		 }

		 // release lock
		 flock($file,LOCK_UN);
		 // echo '\nReleased: '.date('h:i:s');
		 fclose($file);


	}

	
}