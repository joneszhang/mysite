<?php
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Filter;
$request = new Request();
$response = new Response();
$filter = new Filter();
$rcode = "f";

$id = "id";
$time = "aa";
$dtime = "aa";
$lat = 12.24;
$lng = 11.10;
$title = "asdf";
$desc = "asdf";
$type = 5;
$tag = "aaa";
$nickname = "bb";

if($request->isPost() == true){
       $data = $request->getJsonRawBody();
       $id = $data->{'email'};
       $time = $data->{'time'};
       $dtime = $data->{'dead_time'};
       $lat = $data->{'lat'};
       $lng = $data->{'lng'};
       $title = $data->{'title'};
       $desc = $data->{'desc'};
       $type = $data->{'type'};
       $tag = $data->{'tags'};
       $nickname = $data->{'nickname'};
       $off = "', '";
       $sqlw = "INSERT INTO messages (id, time, deadtime, lat, lng, title, description, type, tag, nickname) VALUES ('" . $id . $off . $time . $off . $dtime . $off . $lat . $off . $lng . $off . $title . $off . $desc . $off . $type . $off . $tag . $off . $nickname . "')";
        $con = mysql_connect("localhost","root","686993");
    if(!$con){
        $rcode = "cc";
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db("app_users", $con);
        mysql_query($sqlw);
	mysql_close($con);
	$rcode = "s";
}

$response->setStatusCode(200, "Success");
$response->setContent($rcode);
$response->send();
?>
