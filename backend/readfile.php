<?php
trait readFile {
	// Read CSV FILE
	public function readFile($path)
	{
		try {
			  if(!file_exists($path)){
	  				$errors=true;
	  				 throw new Exception("No such file exits!.");
	  			}else{
	  			   if (($open = fopen($path, "r")) !== FALSE) 
					 {
					      // csv file get data and convert to array  
					      while (($getdata = fgetcsv($open, 1000, ",")) !== FALSE) 
					      {        
					         $data[] = $getdata; 
					      }
					      // file close
					      fclose($open);
					}
					return $data;
	  			   
	  			}
	  		}
	    catch(Exception $e) {
			  return 'Error: ' .$e->getMessage();
			}

	}
	// Update CSV FILE
	public function updateFile($path,$data=[])
	{
		try {
			  if(!file_exists($path)){
	  				$errors=true;
	  				 throw new Exception("No such file exits!.");
	  			}else{
	  			   if(count($data)>0){
	  			   	   $file_Path = fopen($path, 'w');
					   foreach ( $data as $data ) 
					   {
					      fputcsv($file_Path, $data);
					   }
					   // File close
					   fclose($file_Path);
	  			   }else{
	  			   	  throw new Exception("Something went wrong!.");
	  			   }
	  			   return true;
	  			   
	  			}
	  		}
	    catch(Exception $e) {
			  return 'Error: ' .$e->getMessage();
			}
	   
	}
 
}