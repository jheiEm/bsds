
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Students</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Add New Student</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-striped">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="30%">
					<col width="20%">
					<col width="20%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Created</th>
						<th>Name</th>
						<th>Gender</th>
						<th>Age</th>
						<th>Birthday</th>
						<th>Contact No.</th>
						<th>Address</th>
						<th>Remarks</th>
						<th>Status</th>
						<th>Assigned District</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					$qry = $conn->query("SELECT *,concat(lastname,', ',firstname,' ', middlename) as name from `student_list` order by concat(lastname,', ',firstname,' ', middlename) asc ");
					while($row = $qry->fetch_assoc()):
					?>
					
					
				
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td><?php echo $row['name'] ?></td>
							<td><?php echo $row['gender'] ?></td>
							<td><?php echo $row['age'] ?></td>
							<td><?php echo $row['dob'] ?></td>
							<td><?php echo $row['contact'] ?></td>
							<td><?php echo $row['address'] ?></td>
							<td><?php echo $row['remarks'] ?></td>
							<td><?php echo $row['status'] ?></td>
							<td><?php echo $row['location_id'] ?></td>
				
                            </td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
							 <a class="dropdown-item" href="?page=student/view_details&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
				                    <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this Student permanently?","delete_category",[$(this).attr('data-id')])
		})
		$('#create_new').click(function(){
			uni_modal("<i class='fa fa-plus' style='color:black;'></i> <label style='color:black;'> Add New Student </label>","student/manage_student.php","mid-large")
		})
		$('.edit_data').click(function(){
			uni_modal("<i class='fa fa-plus' style='color:black;'></i> <label style='color:black;'> Add New Student </label>","student/manage_student.php?id="+$(this).attr('data-id'),"mid-large")
		})
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable();
	})
	function delete_category($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_patient",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occurred.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occurred.",'error');
					end_loader();
				}
			}
		})
	}
</script>