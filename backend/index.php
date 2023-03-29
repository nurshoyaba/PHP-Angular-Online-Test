<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

// this will be your backend
// some things this file should do
// get query string 
// handle get requests
// open and read data.csv file
// handle post requests
// (optional) write to csv file. 
// format data into an array of objects 
// return all data for every request. 
// set content type of response.
// return JSON encoded data



   // header('Content-Type: text/csv');
   // header('Content-Disposition: attachment; filename="data.csv"');

  /**
   * 
   */
  class AddUpdateCSV 
  {
  	

  	   public function addnewRow($name,$state,$zip,$amount,$qty,$item)
	   {
	   		 // csv file open
		   if (($open = fopen("data.csv", "r")) !== FALSE) 
		   {
		      // csv file get data and convert to array  
		      while (($getdata = fgetcsv($open, 1000, ",")) !== FALSE) 
		      {        
		         $data[] = $getdata; 
		      }
		      // file close
		      fclose($open);
		   }
		   // Append to new data in csv file  
		   $data[] = ["id" => count($data), 
		   "name" => $name, 
		   "state" => $state,
		   "zip"=> $zip,
		   'amount'=> $amount,
		   'qty'=> $qty,
		   'item'=>$item];

		   // csv File update
		   $path = 'data.csv';
		   $file_Path = fopen($path, 'w');
		   foreach ( $data as $data ) 
		   {
		      fputcsv($file_Path, $data);
		   }
		   // File close
		   fclose($file_Path);
		   return true;
	   }

	   public function updateRow($name,$state,$zip,$amount,$qty,$item,$user_id)
	   {
	   		 // csv file open
		   if (($open = fopen("data.csv", "r")) !== FALSE) 
		   {
		      // csv file get data and convert to array  
		   	$i=0;
		      while (($getdata = fgetcsv($open, 1000, ",")) !== FALSE) 
		      {        
		         
		         if($getdata[0]==$user_id){
		         	$data[] = [
					   "id" => $user_id,
					   "name" => $name, 
					   "state" => $state,
					   "zip"=> $zip,
					   'amount'=> $amount,
					   'qty'=> $qty,
					   'item'=>$item
					];
		         }else{
		         	$data[] = $getdata; 
		         }
		         $i++;
		      }
		      // file close
		      fclose($open);
		   }
		   
		   // csv File update
		   $path = 'data.csv';
		   $file_Path = fopen($path, 'w');
		   foreach ( $data as $data ) 
		   {
		      fputcsv($file_Path, $data);
		   }
		   // File close
		   fclose($file_Path);
		   return true;
	   }

	   public function deleteRow($user_id)
	   {
	       // csv file open
		   if (($open = fopen("data.csv", "r")) !== FALSE) 
		   {
		      // csv file get data and convert to array  
		   	$i=0;
		      while (($getdata = fgetcsv($open, 1000, ",")) !== FALSE) 
		      {        
		         if($getdata[0]!=$user_id){
		         	$data[] = $getdata; 
		         }
		         $i++;
		      }
		      // file close
		      fclose($open);
		   }
		   // csv File update
		   $path = 'data.csv';
		   $file_Path = fopen($path, 'w');
		   foreach ( $data as $data ) 
		   {
		      fputcsv($file_Path, $data);
		   }
		   // File close
		   fclose($file_Path);
		   return true;
	   }

	   public function getAllData()
	   {
	   		 // csv file open
	   	   $data                = array();
	   	   $response['details'] = array();
		   if (($open = fopen("data.csv", "r")) !== FALSE) 
		   {
		  
		      // csv file get data and convert to array  
		   	$i=0;
		      while (($getdata = fgetcsv($open, 1000, ",")) !== FALSE) 
		      { 
       
		         //$data[] = $getdata; 
		         $newdata            = array();
		         if($i==0){
		         	 $newdata['id']           = ucwords($getdata[0]);
			         $newdata['name']         = ucwords($getdata[1]);
			         $newdata['state']        = ucwords($getdata[2]);
			         $newdata['zip']          = ucwords($getdata[3]);
			         $newdata['amount']       = ucwords($getdata[4]);
			         $newdata['qty']          = ucwords($getdata[5]);
			         $newdata['item']         = ucwords($getdata[6]);
			         $newdata['is_edit_show'] ='0';
		         }else{
		         	 $newdata['id']           = $getdata[0];
			         $newdata['name']         = $getdata[1];
			         $newdata['state']        = $getdata[2];
			         $newdata['zip']          = $getdata[3];
			         $newdata['amount']       = $getdata[4];
			         $newdata['qty']          = $getdata[5];
			         $newdata['item']         = $getdata[6];
			         $newdata['is_edit_show'] ='1';
		         }
		         $i++;
		        


		         array_push($response['details'], $newdata);
		      }

		      // file close
		      fclose($open);
		   }
		   return json_encode(['status'=>'200','details'=>$response['details']]);
	   }
	   public function getDataById($id)
	   {
	   		 // csv file open
	   	   $data                = array();
	   	   $response['details'] = array();
		   if (($open = fopen("data.csv", "r")) !== FALSE) 
		   {
		  
		      // csv file get data and convert to array  
		   	 $i=0;
		   	 $newdata            = array();
		      while (($getdata = fgetcsv($open, 1000, ",")) !== FALSE) 
		      { 
		         //$data[] = $getdata; 
		      	if($getdata[0]==$id){
		      		 $newdata            = array();
		         	 $newdata['id']           = $getdata[0];
			         $newdata['name']         = $getdata[1];
			         $newdata['state']        = $getdata[2];
			         $newdata['zip']          = $getdata[3];
			         $newdata['amount']       = $getdata[4];
			         $newdata['qty']          = $getdata[5];
			         $newdata['item']         = $getdata[6];
		      	}
		        $i++;		         
		      }

		      // file close
		      fclose($open);
		   }
		   return json_encode(['status'=>'200','details'=>$newdata]);
	   }
  }

  

  if(isset($_GET['getCSVdata']) && $_GET['getCSVdata']=='getall' ){
  	     $newvar = new AddUpdateCSV();
  		 echo $newvar->getAllData();
  }

  if(isset($_GET['Id']) && $_GET['Id']!=''){
  	$newvar = new AddUpdateCSV();
  	 echo $newvar->getDataById($_GET['Id']);
  }
 		
  if(isset($_POST['service'])){
  		echo "ok";
  }


  $data = json_decode(file_get_contents("php://input"));
  // add new record to database
  //print($data->service); die();
  if(isset($data->service) && $data->service=='Addnewuser'){
  	// creating object
  	$newvar = new AddUpdateCSV();

  	// Posted Values
	$name=$data->name;
	$state=$data->state;
	$zip=$data->zip;	
	$amount=$data->amount;
	$qty=$data->qty;
	$item=$data->item;	
	//Insert Function Calling
	$addnewRow=$newvar->addnewRow($name,$state,$zip,$amount,$qty,$item);
	if($addnewRow)
	{
		// Message for successfull insertion
		echo json_encode(['status'=>'200','msg'=>'Record inserted successfully']);
	}
	else
	{
		// Message for unsuccessfull insertion
		echo json_encode(['status'=>'203','msg'=>'Something went wrong. Please try again']);
	}
	die();

  }	

  // Edit User
  if(isset($data->service) && $data->service=='Edituser'){
  	// creating object
  	$updatetdata=new AddUpdateCSV();

  	// Posted Values
	$name=$data->name;
	$state=$data->state;
	$zip=$data->zip;	
	$amount=$data->amount;
	$qty=$data->qty;
	$item=$data->item;	
	$user_id=$data->user_id;	
	//Update Function Calling
	$update=$updatetdata->updateRow($name,$state,$zip,$amount,$qty,$item,$user_id);
	if($update)
	{
		// Message for successfull 
		echo json_encode(['status'=>'200','msg'=>'Record Updated successfully']);
	}
	else
	{
		// Message for unsuccessfull
		echo json_encode(['status'=>'203','msg'=>'Something went wrong. Please try again']);
	}
	die();

  }

  //print_r($data);
  if(isset($data->item_id) && $data->item_id!=''){
  		// creating object
  	    $deletedata=new AddUpdateCSV();
  	    $item_id=$data->item_id;
  	    //Update Function Calling
		$delete=$deletedata->deleteRow($item_id);
		if($delete)
		{
			// Message for successfull 
			echo json_encode(['status'=>'200','msg'=>'Record has been removed successfully']);
		}
		else
		{
			// Message for unsuccessfull 
			echo json_encode(['status'=>'203','msg'=>'Something went wrong. Please try again']);
		}
		die();
  }	
 
   

?>
