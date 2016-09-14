<?php
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Filter;
$request = new Request();
$response = new Response();
$filter = new Filter();
if($request->isPost() == true){
    $email = $request->getPost("email");
    $name = $request->getPost("name");      
}
$response->setStatusCode(200, "Success");
$response->setContent($name);
$response->send();
?>
