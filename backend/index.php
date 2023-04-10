<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
//echo 'Welcome';
include 'readfile.php';

  	class getCSVDatas 
  	{
  		use readFile;
  		public $path="data.csv";
  		// fetch all product lists
  		public function getAllProduct($product_id="")
  		{
  			$array = [];
  			$readscsv=$this->readfile($this->path);
			try {
				  $readscsv=$this->readfile($this->path);
				  if(count($readscsv)==0){
		  				return $array;
		  			}else{
		  			   $headers = array_shift($readscsv);
			  			
			  			// Combine the headers with each following row
						foreach ($readscsv as $row) {
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
		  		}
		    catch(Exception $e) {
				  return 'Error: ' .$e->getMessage();
				}
  		}
  		// remove product lists
  		public function removeProduct($product_id)
  		{
  			try {
  			    if($product_id>0){
	  				/*---------------Update CSV FIle---------------------*/
	  				$readscsv=$this->readfile($this->path);
	  				$product_arr=array();
	  				foreach ($readscsv as $key => $products) {
	  					$new_arr=array();
	  					if(!in_array($products[0], $product_id)){
					          $new_arr = [
							   "id"     => $products[0],
							   "name"   => $products[1], 
							   "state"  => $products[2],
							   "zip"    => $products[3],
							   'amount' => $products[4],
							   'qty'    => $products[5],
							   'item'   => $products[6]
								];
					         array_push($product_arr,$new_arr);
			  			}
			  			
	  				}
				   	if($this->updateFile($this->path,$product_arr)){
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
        // filter unwanted characters from data
  		public function escape_string($data)
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
				// defining the variables and  escaping its unwanted strings
			    $name=$this->escape_string($post_data['name']);
			    $state=$this->escape_string($post_data['state']);
			    $zip=$this->escape_string($post_data['zip']);
			    $amount=$this->escape_string($post_data['amount']);
			    $qty=$this->escape_string($post_data['qty']);
			    $item=$this->escape_string($post_data['item']);

			    if(empty($name)){
	  				 throw new Exception("Name is required");
	  			}
	  			if(empty($state)){
	  				 throw new Exception("State is required");
	  			}
	  			if(empty($zip)==true || (!is_numeric($zip)==true) ){
	  				 throw new Exception("Invalid Zip code ");
	  			}

	  			if(empty($amount)==true || (!is_numeric($amount)==true) ){
	  				throw new Exception("Invalid Product Amount ");
	  			}

	  			if(empty($qty)==true || (!is_numeric($qty)==true) ){
	  				throw new Exception("Invalid Product qty ");
	  			}

	  			if(empty($item)==true){
	  				throw new Exception("Item is required");
	  			}

	  			$product_id=$post_data['product_id'];
	  			if($product_id>0){
	  				/*---------------Update CSV FIle---------------------*/
	  				$readscsv=$this->readfile($this->path);
	  				$product_arr=array();
	  				foreach ($readscsv as $key => $products) {
	  					$new_product_arr=array();
	  					if($products[1]==$name && $product_id!=$products[0]){
	  						throw new Exception("Same Name Already Exits!.");
			  			}elseif($product_id==$products[0]){

			  			   $new_product_arr = [
						   "id"     => $product_id,
						   "name"   => $name, 
						   "state"  => $state,
						   "zip"    => $zip,
						   'amount' => $amount,
						   'qty'    => $qty,
						   'item'   => $item
							];
			  			}else{
					          $new_product_arr = [
							   "id"     => $products[0],
							   "name"   => $products[1], 
							   "state"  => $products[2],
							   "zip"    => $products[3],
							   'amount' => $products[4],
							   'qty'    => $products[5],
							   'item'   => $products[6]
								];
					         
			  			}
			  			array_push($product_arr,$new_product_arr);
	  				}
	  				//return json_encode($product_arr);
				   	if($this->updateFile($this->path,$product_arr)){
				   	    $status="200";
				   		$msg="Data Updated successfully!.";
				    }
	  			}else{
	  				/*---------------Add New Row in CSV FIle---------------------*/
				    $readscsv=$this->readfile($this->path);
	  				$product_arr=$readscsv;
	  				foreach ($product_arr as $key => $products) {	  					
	  					if($products[1]==$name){
			  				throw new Exception("Data Already Exits!.");
			  			}
	  				}
	  				$new_product_arr = ["id"    => count($product_arr), 
							   "name"   => $name, 
							   "state"  => $state,
							   "zip"    => $zip,
							   'amount' => $amount,
							   'qty'    => $qty,
							   'item'   => $item];
				    array_push($product_arr, $new_product_arr);

				    if($this->updateFile($this->path,$product_arr)){
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

			return json_encode(['status'=>$status,"msg"=>$msg]);
			
  		}

  		
  	}
  $obj=new getCSVDatas();

  if(isset($_GET['getCSVdata']) && $_GET['getCSVdata']=='getall' ){
  	    echo json_encode(['status'=>'200','details'=>$obj->getAllProduct()]);
  }

  if(isset($_GET['Id']) && $_GET['Id']!=''){
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
  	if(is_numeric($data->item_id)){
  		$product_id[]=$data->item_id;
  	}else{
  		$product_id=$data->item_id;
  	}
  	//print_r($product_id); die();
  		try {
		    $remove=$obj->removeProduct($product_id);
		    if($remove){
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
