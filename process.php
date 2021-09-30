<?php
//print_r($_POST);
require("conn.php");

if (isset($_POST['nameforsecret'])) {
	$sname = $_POST['nameforsecret'];
	$spass = $_POST['password'];
	$sservice = $_POST['selectservice'];
	$sprofile = $_POST['selectprofile'];
	$scallerid = $_POST['caller-id'];
	// $sremoteaddress = $_POST['remote-address'];
	// $slocaladdress = $_POST['local-address'];
	$scomment = $_POST['scomment'];

	$api->comm("/ppp/secret/add", array(
      "name"     => $sname,
      "password" => $spass,
      "service"  => $sservice,
      "profile"  => $sprofile,
      "caller-id"  => $scallerid,
      // "remote-address" => $sremoteaddress,
      // "local-address" => $slocaladdress,
      "comment"  => $scomment,
   	));
   	echo "Data successfully added!";
}elseif(isset($_POST['tempaandd'])){
	//print_r($_POST);
	$singledataid = $_POST['singledataid'];
	if ($_POST['tempaandd'] == "active") {

		$api->comm("/ppp/secret/set", array(
			   ".id" => "$singledataid",
			   "disabled"  => "yes",
			   )
		  	   );
		echo "Data disable successfully!";
	}else{
		$api->comm("/ppp/secret/set", array(
			   ".id" => "$singledataid",
			   "disabled"  => "no",
			   )
		  	   );
		echo "Data enable successfully!";
	}
}elseif(isset($_POST['singledatadid'])){
	$singledatadid = $_POST['singledatadid'];
	$api->comm("/ppp/secret/remove", array(
		".id" => "$singledatadid",
	));
	echo "Data deleted successfully!";
}elseif(isset($_POST['singledataeid'])) {
	$singledataeid = $_POST['singledataeid'];
	$singledataeidres = $api->comm("/ppp/secret/print", array(
    "?.id" => "$singledataeid",
  	));
  	//print_r($singledataeidres);
  	foreach ($singledataeidres as $singledataeidreskey => $singledataeidresvalue) {

  		$singledataeidresarr = array(
  			'id' => $singledataeidresvalue['.id'],
  			'name' => $singledataeidresvalue['name'],
  			'service' => $singledataeidresvalue['service'],
  			'callerid' => $singledataeidresvalue['caller-id'],
  			'password' => $singledataeidresvalue['password'],
  			'profile' => $singledataeidresvalue['profile'],
  			'lastlogouttime' => $singledataeidresvalue['last-logged-out'],
  			'disabled' => $singledataeidresvalue['disabled'],
  			'comment' => $singledataeidresvalue['comment'],
  		);

  	}
  	//print_r($singledataeidresarr);
 	echo json_encode($singledataeidresarr);
}elseif (isset($_POST['edit-item-id'])) {
	//print_r($_POST);
	$updateid = $_POST['edit-item-id'];
	$updatename = $_POST['nameforsecretedit'];
	$updatespass = $_POST['passwordedit'];
	$updatesservice = $_POST['selectserviceedit'];
	$updatesprofile = $_POST['selectprofileedit'];
	$updatescallerid = $_POST['caller-idedit'];
	// $sremoteaddress = $_POST['remote-address'];
	// $slocaladdress = $_POST['local-address'];
	$updatescomment = $_POST['scommentedit'];

	$api->comm("/ppp/secret/set", array(
      ".id"     => $updateid,
      "name"     => $updatename,
      "password" => $updatespass,
      "service"  => $updatesservice,
      "profile"  => $updatesprofile,
      "caller-id"  => $updatescallerid,
      // "remote-address" => $sremoteaddress,
      // "local-address" => $slocaladdress,
      "comment"  => $updatescomment,
   	));
   	echo "Data successfully updated!";
}
else{
	echo "Error";
}


?>