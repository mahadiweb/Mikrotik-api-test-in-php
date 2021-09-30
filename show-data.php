<?php
require('conn.php');
$showdata = $api->comm('/ppp/secret/print');

$showresarr = array();

foreach ($showdata as $showdatavalue) {

  		$showresarr["data"][] = array(
  			'id' => $showdatavalue['.id'],
  			'name' => $showdatavalue['name'],
  			'service' => $showdatavalue['service'],
  			'callerid' => $showdatavalue['caller-id'],
  			'password' => $showdatavalue['password'],
  			'profile' => $showdatavalue['profile'],
  			'lastlogouttime' => $showdatavalue['last-logged-out'],
  			'disabled' => $showdatavalue['disabled'],
  			'comment' => $showdatavalue['comment'],
  		);

  	}

echo json_encode($showresarr);
?>