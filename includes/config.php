<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'spot';

$con = new mysqli($host,$username,$password,$dbname);

if($con -> connect_error)
{
	die("connection failed".$con->connect_error);
}
else
	{
	//echo "connected successfully <br>";
}

?>