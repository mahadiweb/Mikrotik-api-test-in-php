<?php
require('conn.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Mikrotik api</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.2/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

	<div class="container">
		<div class="topbanner bg-primary p-3 mb-1 text-white text-center"><h3>Mikrotik api</h3></div>
		<div class="py-2"><button class="btn btn-primary" data-toggle="modal" data-target="#addmodal">Add user</button></div>
		<div class="card p-2">
			<table id="example" class="table table-dark">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Name</th>
						<th scope="col">Password</th>
						<th scope="col">Service</th>
						<th scope="col">Profile</th>
						<th scope="col">Comment</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$tes = $api->comm('/ppp/secret/print');
      //print_r($tes);
					$id = 1;
					foreach ($tes as $key) { 
        // $datas = json_encode($key);
        // echo $datas;
						?>

						<tr>
							<th scope="row"><?php echo $id++ ?></th>
							<td><?php echo $key['name']; ?></td>
							<td><?php echo $key['password']; ?></td>
							<td><?php echo $key['service']; ?></td>
							<td><?php echo $key['profile']; ?></td>
							<td>
								<?php 
								if(empty($key['comment'])) {
									echo "";
								}else{
									echo $key['comment'];
								}
								?>
							</td>
							<td><?php
							if ($key['disabled'] == "false") {
								echo "<button class='btn btn-primary tempaandd' data-id='".$key['.id']."' data-status='".$key['disabled']."'>E</button>";
							}else{
								echo "<button class='btn btn-danger tempaandd' data-id='".$key['.id']."' data-status='".$key['disabled']."'>D</button>";
							}
							?> | <button class="btn btn-primary cursore-pointer text-white clickededit" data-eid="<?php echo $key['.id']; ?>"><i class="fa fa-edit"></i></button> | <button class="btn btn-danger cursore-pointer text-white btndatadelete" data-did="<?php echo $key['.id']; ?>"><i class="fa fa-trash"></i></button></td>
						</tr>

						<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<div id="text"></div>
	<!-- add modal start -->

	<!-- Modal -->
	<div class="modal fade" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add secret</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="secretaddform" method="post" action="">
						<div class="form-group">
							<label for="namesecrete">Name</label>
							<input type="text" class="form-control" id="namesecrete" placeholder="Enter name" name="nameforsecret" required="">
							<small id="emailHelp" class="form-text text-muted"></small>
						</div>
						<div class="form-group">
							<label for="passsecret">Password</label>
							<input type="password" class="form-control" id="passsecret" placeholder="Password" name="password" required="">
						</div>
						<div class="form-group">
							<label for="selectservice">Select service</label>
							<select class="form-control" name="selectservice" required="">
								<option value="any">any</option>
								<option value="pppoe">pppoe</option>
								<option value="pptp">pptp</option>
								<option value="l2tp">l2tp</option>
								<option value="ovpn">ovpn</option>
							</select>
						</div>
						<div class="form-group">
							<label for="selectservice">Select profile</label>
							<select class="form-control" name="selectprofile">
								<?php
								$profiles = $api->comm('/ppp/profile/print');
								foreach ($profiles as $keys) {
									echo "<option value='".$keys['name']."'>".$keys['name']."</option>";
								}
		    		//echo "<option>".print_r($profiles)."</option>";
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="caller-id">Caller Id</label>
							<input type="text" class="form-control" id="caller-id" placeholder="Enter Caller id" name="caller-id">
						</div>
<!-- 		  <div class="form-group">
		    <label for="remote-address">Remote Address</label>
		    <input type="text" class="form-control" id="remote-address" placeholder="Enter Remote Address" name="remote-address">
		  </div>
		  <div class="form-group">
		    <label for="local-address">Local Address</label>
		    <input type="text" class="form-control" id="local-address" placeholder="Enter Local Address" name="local-address">
		</div> -->
		<div class="form-group">
			<label for="scomment">Comment</label>
			<textarea class="form-control" id="scomment" placeholder="Enter Your Comment" name="scomment"></textarea>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Submit</button>
	</div>
</form>
</div>
</div>
</div>
<!-- add modal end -->

<!-- edit modal start -->

<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit secret</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="secreteditform" method="post" action="">
					<div class="form-group">
						<label for="namesecrete">Name</label>
						<input type="text" class="form-control editmodalname" id="namesecrete" placeholder="Enter name" name="nameforsecretedit" required="">
						<small id="emailHelp" class="form-text text-muted"></small>
					</div>
					<div class="form-group">
						<label for="passsecret">Password</label>
						<input type="password" class="form-control editmodalpassword" id="passsecret" placeholder="Password" name="passwordedit" required="">
					</div>
					<input type="hidden" name="edit-item-id" id="edit-item-id" value="">
					<div class="form-group">
						<label for="selectservice">Select service</label>
						<select class="form-control editmodalservice" name="selectserviceedit" required="">
							<option value="any">any</option>
							<option value="pppoe">pppoe</option>
							<option value="pptp">pptp</option>
							<option value="l2tp">l2tp</option>
							<option value="ovpn">ovpn</option>
						</select>
					</div>
					<div class="form-group">
						<label for="selectservice">Select profile</label>
						<select class="form-control editmodalprofile" name="selectprofileedit">
							<?php
							$profiles = $api->comm('/ppp/profile/print');
							foreach ($profiles as $keys) {
								echo "<option value='".$keys['name']."'>".$keys['name']."</option>";
							}
		    		//echo "<option>".print_r($profiles)."</option>";
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="caller-id">Caller Id</label>
						<input type="text" class="form-control editmodalcallerid" id="caller-id" placeholder="Enter Caller id" name="caller-idedit" >
					</div>
					<div class="form-group">
						<label for="scomment">Comment</label>
						<textarea class="form-control editmodalcomment" id="scomment" placeholder="Enter Your Comment" name="scommentedit"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- edit modal end -->
<div class="textt"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> -->
<script type="text/javascript" src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.2/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#example').DataTable({
			// "ajax": {
			// 	url:"show-data.php",
			// },
			// "columns": [
   //          { "data": "id" },
   //          { "data": "name" },
   //          { "data": "password" },
   //          { "data": "service" },
   //          { "data": "profile" },
   //          { "data": "comment" },
   //          { "render": function(data, type, row, meta){
   //          	if (row['disabled'] == "false") {
   //          		res = "<button class='btn btn-primary tempaandd' data-id='"+row['id']+"' data-status='"+row['disabled']+"'>E</button>";
   //          	}else{
   //          		res = "<button class='btn btn-danger tempaandd' data-id='"+row['id']+"' data-status='"+row['disabled']+"'>D</button>";
   //          	}
   //          	return res;
   //          }
   //      	}
   //      	]
});
	});
</script>
<script type="text/javascript">
	
	$(document).ready(function(){

		$("#secretaddform").on('submit',function(e){
			e.preventDefault();
			$.ajax({
				method:"post",
				url:"process.php",
				data:$(this).serialize(),
				success:function(data){
					$("#addmodal").modal('hide');
					alert(data);
				}
			})
			//alert("hello");
		})

	})

	$(".tempaandd").on('click',function() {
		singledataid = $(this).attr('data-id');
		if ($(this).attr('data-status')== "false") {
			$.ajax({
				method:"post",
				url:"process.php",
				data:{tempaandd:"active", singledataid:singledataid},
				success:function(data){
					alert(data);
				}
			})
		}else{
			$.ajax({
				method:"post",
				url:"process.php",
				data:{tempaandd:"deactive", singledataid:singledataid},
				success:function(data){
					alert(data);
				}
			})
		}
	});

	$(".btndatadelete").on('click',function() {
		if (confirm("Are you sure!")) {
			singledatadid = $(this).attr('data-did');
			$.ajax({
				method:"post",
				url:"process.php",
				data:{singledatadid:singledatadid},
				success:function(data){
					alert(data);
				}
			})
		}
	})

	$(".clickededit").on('click',function(){
		editid = $(this).attr('data-eid');
		$.ajax({
			method:"POST",
			url:"process.php",
			data:{singledataeid:editid},
			dataType: "JSON",
			success:function(data){
				console.log(data);
				$(".editmodalname").val(data.name);
				$(".editmodalpassword").val(data.password);
				$(".editmodalservice").val(data.service);
				$(".editmodalprofile").val(data.profile);
				$(".editmodalcallerid").val(data.callerid);
				$(".editmodalcomment").text(data.comment);
				$("#edit-item-id").val(data.id);

			}
		})
		$("#editmodal").modal("show");
	})

		//update

		$("#secreteditform").on('submit',function(e){
			e.preventDefault();
			$.ajax({
				method:"post",
				url:"process.php",
				data:$(this).serialize(),
				success:function(data){
					$("#editmodal").modal('hide');
					alert(data);
				}
			})
			//alert("hello");
		})

		// function showdatas(){
		// $.ajax({
		// 		method:"GET",
		// 		url:"show-data.php",
		// 		dataType:"json",
		// 		success:function(showdata){
		// 			console.log(showdata);
		// 			idnum = 1;
		// 			showdatatable = '';
		//           $.each(showdata,function(index, showvalue) {
		//           	showdatatable += '<tr>';

		//           	showdatatable += '<td>'+ idnum++ +'</td>';
		//           	showdatatable += '<td>'+showvalue.name+'</td>';
		//           	showdatatable += '<td>'+showvalue.password+'</td>';
		//           	showdatatable += '<td>'+showvalue.service+'</td>';
		//           	showdatatable += '<td>'+showvalue.profile+'</td>';
		//           	showdatatable += '<td>'+showvalue.comment+'</td>';

		//           	showdatatable += '</tr>';
		//           });
		//           $("#data-show-table").html(showdatatable);
		// 		}
		// })
		// }
		// showdatas();
	</script>
</body>
</html>