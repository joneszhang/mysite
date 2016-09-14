<?php
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Filter;
$request = new Request();
$response = new Response();
$filter = new Filter();
$rcode = "s";
if($request->isPost() == true){
    $email = $request->getPost("email");
    $pwd = $request->getPost("password");
    $con = mysql_connect("localhost","root","686993");
    if(!$con){
        $rcode = "cc";
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db("app_users", $con);
    $result = mysql_query("SELECT * FROM users where email='" . $email . "'", $con);
    $row = mysql_fetch_array($result);
    if($row == false) $rcode = "nouser";
    else{
       #$ppwd = $row[]
       if($row['password'] != $pwd) $rcode = "wpwd";
    }
    mysql_close($con);
}
$response->setStatusCode(200, "Success");
$response->setContent($rcode);
$response->send();
?>
