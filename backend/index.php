<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
include 'readfile.php';

  	class getCSVDatas 
  	{
  		use readFile;
  		public $path="data.csv";
  		public function getAllProduct($product_id="")
  		{
  			$readscsv=$this->readfile($this->path);
  			//print_r($readscsv);
  			$headers = array_shift($readscsv);
  			$array = [];
  			// if($product_id==''){
  			// 	$array[] = [
					// 	   "id"     => ucwords($headers[0]),
					// 	   "name"   => ucwords($headers[1]), 
					// 	   "state"  => ucwords($headers[2]),
					// 	   "zip"    => ucwords($headers[3]),
					// 	   'amount' => ucwords($headers[4]),
					// 	   'qty'    => ucwords($headers[5]),
					// 	   'item'   => ucwords($headers[6]),
					// 	   'is_edit_show' => '0'
					// 		];
  			// }
			// Combine the headers with each following row
			
			foreach ($readscsv as $row) {
				  // echo $row[0];
					
					if($product_id!=''){
						if($row[0]==$product_id){
							$array[] = array_combine($headers, $row);
						}
					}else{
						$array[] = array_combine($headers, $row);
					}			    
			}
			return $array;
  		}
  		public function removeProduct($product_id)
  		{
  			try {
  			    if($product_id>0){
	  				/*---------------Update CSV FIle---------------------*/
	  				$readscsv=$this->readfile($this->path);
	  				$data=array();
	  				foreach ($readscsv as $key => $products) {
	  					$data1=array();
	  					if($product_id!=$products[0]){
					          $data1 = [
							   "id"     => $products[0],
							   "name"   => $products[1], 
							   "state"  => $products[2],
							   "zip"    => $products[3],
							   'amount' => $products[4],
							   'qty'    => $products[5],
							   'item'   => $products[6]
								];
					         array_push($data,$data1);
			  			}
			  			
	  				}
				   	if($this->updateFile($this->path,$data)){
				   	    $status="200";
				   		$msg="Data has been removed successfully!.";
				    }
	  			}else{
	  				throw new Exception("Something went wrong!.");
	  			}
	  			
	  		}
	  		catch(Exception $e) {
			  $status='203';
			  $msg= 'Error: ' .$e->getMessage();
			}
			return $output=json_encode(['status'=>$status,"msg"=>$msg]);
  		}
  		public function test_input($data)
  		{
  			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
  		}

  		public function addUpdateProduct($post_data=[])
  		{
  			$status="203";
		    $msg="Something went wrong!.";
			try {
			  if(empty($post_data['name'])){//
	  				$errors=true;
	  				 throw new Exception("Name is required");
	  			}else{
	  				$name=$this->test_input($post_data['name']);
	  			}

	  			if(empty($post_data['state'])){
	  				 throw new Exception("State is required");
	  			}else{
	  				$state=$this->test_input($post_data['state']);
	  			}

	  			if(empty($post_data['zip'])==true || (!is_numeric($post_data['zip'])==true) ){
	  				 throw new Exception("Invalid Zip code ");
	  			}else{
	  				$zip=$this->test_input($post_data['zip']);
	  			}

	  			if(empty($post_data['amount'])==true || (!is_numeric($post_data['amount'])==true) ){
	  				throw new Exception("Invalid Product Amount ");
	  			}else{
	  				$amount=$this->test_input($post_data['amount']);
	  			}

	  			if(empty($post_data['qty'])==true || (!is_numeric($post_data['qty'])==true) ){
	  				throw new Exception("Invalid Product qty ");
	  			}else{
	  				$qty=$this->test_input($post_data['qty']);
	  			}

	  			if(empty($post_data['item'])==true){
	  				throw new Exception("Item is required");
	  			}else{
	  				$item=$this->test_input($post_data['item']);
	  			}
	  			//return true;
	  			$product_id=$post_data['product_id'];
	  			if($product_id>0){
	  				/*---------------Update CSV FIle---------------------*/
	  				$readscsv=$this->readfile($this->path);
	  				$data=array();
	  				foreach ($readscsv as $key => $products) {
	  					$data1=array();
	  					if($products[1]==$name && $product_id!=$products[0]){
	  						throw new Exception("Same Name Already Exits!.");
			  			}elseif($product_id==$products[0]){

			  			   $data1 = [
						   "id"     => $product_id,
						   "name"   => $name, 
						   "state"  => $state,
						   "zip"    => $zip,
						   'amount' => $amount,
						   'qty'    => $qty,
						   'item'   => $item
							];
			  			}else{
					          $data1 = [
							   "id"     => $products[0],
							   "name"   => $products[1], 
							   "state"  => $products[2],
							   "zip"    => $products[3],
							   'amount' => $products[4],
							   'qty'    => $products[5],
							   'item'   => $products[6]
								];
					         
			  			}
			  			array_push($data,$data1);
	  				}
				   	if($this->updateFile($this->path,$data)){
				   	    $status="200";
				   		$msg="Data Updated successfully!.";
				    }
	  			}else{
	  				/*---------------Add New Row in CSV FIle---------------------*/
				    $readscsv=$this->readfile($this->path);
	  				$data=$readscsv;
	  				foreach ($data as $key => $products) {	  					
	  					if($products[1]==$name){
			  				throw new Exception("Data Already Exits!.");
			  			}
	  				}
	  				$newdata = ["id"    => count($data), 
							   "name"   => $name, 
							   "state"  => $state,
							   "zip"    => $zip,
							   'amount' => $amount,
							   'qty'    => $qty,
							   'item'   => $item];
				    array_push($data, $newdata);

				    if($this->updateFile($this->path,$data)){
				   	    $status="200";
				   		$msg="Data Added successfully!.";
				    }
	  			}
	  			
			}

			//catch exception
			catch(Exception $e) {
			  $status='203';
			  $msg= 'Error: ' .$e->getMessage();
			}

			return $output=json_encode(['status'=>$status,"msg"=>$msg]);
			
  		}

  		
  	}
  $obj=new getCSVDatas();

  if(isset($_GET['getCSVdata']) && $_GET['getCSVdata']=='getall' ){
  	  // echo $obj->getAllProduct();
  	    echo json_encode(['status'=>'200','details'=>$obj->getAllProduct()]);
  }

  if(isset($_GET['Id']) && $_GET['Id']!=''){
  	   //echo $obj->getAllProduct($_GET['Id']);
  	   echo json_encode(['status'=>'200','details'=>$obj->getAllProduct($_GET['Id'])]);
  }

  $data = json_decode(file_get_contents("php://input"));
  /*--------------------------------add new Product-----------------------------*/
  if(isset($data->service) && $data->service=='Addnewuser'){
  	// Posted Values
	$name=$data->name;
	$state=$data->state;
	$zip=$data->zip;	
	$amount=$data->amount;
	$qty=$data->qty;
	$item=$data->item;	

	$post_inputs=array('name'=>$name,'state'=>$state,'zip'=>$zip,'amount'=>$amount,'qty'=>$qty,'item'=>$item,'product_id'=>'');
	$msg="Add New Product";
	$status="0";
	try {
		    $addProduct=$obj->addUpdateProduct($post_inputs);
		    if($addProduct){//
  				echo $addProduct;
  			}else{
  			   	  throw new Exception("Something went wrong!.");
  			}
  		}
    catch(Exception $e) {
		  return 'Error: ' .$e->getMessage();
		}

  }	

  /*--------------------------------Update Product-----------------------------*/
  if(isset($data->service) && $data->service=='Edituser'){
  	// Posted Values
	$name=$data->name;
	$state=$data->state;
	$zip=$data->zip;	
	$amount=$data->amount;
	$qty=$data->qty;
	$item=$data->item;	
	$product_id=$data->user_id;	
	//Update Function Calling
	$post_inputs=array('name'=>$name,'state'=>$state,'zip'=>$zip,'amount'=>$amount,'qty'=>$qty,'item'=>$item,'product_id'=>$product_id);
	$msg="Update Product";
	$status="0";
	try {
		    $updateProduct=$obj->addUpdateProduct($post_inputs);
		    //print_r($updateProduct);
		    if($updateProduct){//
  				echo $updateProduct;
  			}else{
  			   	  throw new Exception("Something went wrong!.");
  			}
  		}
    catch(Exception $e) {
		  return 'Error: ' .$e->getMessage();
		}

  }

  /*-------------------------------------Remove Product-------------------------------*/
  if(isset($data->item_id) && $data->item_id!=''){
  		try {
		    $remove=$obj->removeProduct($data->item_id);
		    if($remove){//
  				echo $remove;
  			}else{
  			   	  throw new Exception("Something went wrong!.");
  			}
  		}
        catch(Exception $e) {
		  return 'Error: ' .$e->getMessage();
		}
  }	
 
   

?>
