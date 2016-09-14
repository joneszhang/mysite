<?php
#getms.php for sending messages
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Filter;

function rad($d){
    return $d * pi() / 180.0;
}

function distance($lat1, $lng1, $lat2, $lng2){
    $radLat1 = rad($lat1);
    $radLat2 = rad($lat2);
    $a = $radLat1 - $radLat2;
    $b = rad($lng1) - rad($lng2);
    $dis = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));
    $dis = $dis * 6378.137;
    $dis = round($dis * 10000) / 10000;
    return $dis;
}

$request = new Request();
$response = new Response();
$filter = new Filter();
$rcode = "f";

$time = "aa";
$lat = 12.24;
$lng = 11.10;
$type = 5;

if($request->isPost() == true){
    $data = $request->getJsonRawBody();
    $time = $data->{'time'};
    $lat = $data->{'lat'};
    $lng = $data->{'lng'};
    $type = $data->{'type'};
    $con = mysql_connect("localhost","root","686993");
    if(!$con){
        $rcode = "cc";
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db("app_users", $con);
    $sqlw = "SELECT * FROM messages WHERE TIMESTAMPDIFF(minute, deadtime,'" . $time . "')<0" ;
    $result = mysql_query($sqlw);
    $rarray = array();
    while($row = mysql_fetch_array($result)){
        $distance = distance($lat, $lng, $row['lat'], $row['lng']);
	if($distance > 10) continue;
        $item = array("email"=>$row['id'], "time"=>$row['time'], "deadtime"=>$row['deadtime'], "title"=>$row['title'], "desc"=>$row['description'], "type"=>$row['type'], "tag"=>$row['tag'], "lat"=>$row['lat'], "lng"=>$row['lng'], "nickname"=>$row['nickname']);
	array_push($rarray, $item);
    }
    mysql_close($con);
}

$response->setStatusCode(200, "Success");
$rcode = json_encode($rarray);
$response->setContent($rcode);
$response->send();
?>
