<?php
session_start();
define('DB_SERVER','localhost');
define('DB_USER','root');
define('DB_PASS' ,'');
define('DB_NAME', 'myDB');
class DB_con
{
function __construct()
{

	// Create connection
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE myDB";
if (mysqli_query($conn, $sql)) {
  //echo "Database created successfully";
} else {
  //echo "Error creating database: " . mysqli_error($conn);
}

mysqli_close($conn);

$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
$this->dbh=$con;
// Check connection
if (mysqli_connect_errno())
{
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// create database table
$create_table="CREATE TABLE IF NOT EXISTS `tblusers` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `name` varchar(255) NOT NULL,
	  `state` varchar(150) NOT NULL,
	  `zip` varchar(120) NOT NULL,
	  `amount` DECIMAL(10,2) NOT NULL,
	  `qty` DECIMAL(10,2) NOT NULL,
	  `item` varchar(255) NOT NULL,
	   PRIMARY KEY (id),
	  `PostingDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";
mysqli_query($this->dbh,$create_table);
}



//Data Insertion Function
	public function insert($name,$state,$zip,$amount,$qty,$item)
	{
		$ret=mysqli_query($this->dbh,"insert into tblusers(name,state,zip,amount,qty,item) values('$name','$state','$zip','$amount','$qty','$item')");
		return $ret;
	}

	//Data updation Function
	public function update($name,$state,$zip,$amount,$qty,$item,$userid)
	{
		$updaterecord=mysqli_query($this->dbh,"update  tblusers set name='$name',state='$state',zip='$zip',amount='$amount',item='$qty',Address='$item' where id='$userid' ");
		return $updaterecord;
	}
	//Data Deletion function Function
	public function delete($userid)
	{
		$deleterecord=mysqli_query($this->dbh,"delete from tblusers where id=$userid");
		return $deleterecord;
	}
}
?>