<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Budget Amount</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>   Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-striped">
				<colgroup>
					<col width="5%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
					<col width="5%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Created</th>
						<th>Budget Name</th>
						<th>Amount</th>
						<th>Status</th>
                        <th>Issued Amount</th>
                        <th>Remaining Amount</th>
                        <th>Last Updated</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT * from `budget` order by `date_created` asc ");
						if (!$qry) {
							echo "Query failed: " . $conn->error;
						}
						while($row = $qry->fetch_assoc()):
							echo "Row ID: " . $row['id']; // Debug output
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td><?php echo $row['budget_name'] ?></td>
							<td><?php echo $row['amount'] ?></td>
							<td class="text-center">
                                <?php if($row['status'] == 1): ?>
                                    <span class="badge badge-success">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $row['issued_amount'] ?></td>
                            <td><?php echo $row['remaining_amount'] ?></td>
                            <td><?php echo $row['last_updated'] ?></td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
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
<!-- <script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this Budget amount permanently?","delete_category",[$(this).attr('data-id')])
		})
		$('#create_new').click(function(){
			uni_modal("<i class='fa fa-plus' style='color:black;'></i> <label style='color:black';>Add New Budget</label>","maintenance/manage_budget.php","mid-large")
		})
		$('.edit_data').click(function(){
			uni_modal("<i class='fa fa-plus' style='color:black;'></i> <label style='color:black';>Add New Budget</label>","maintenance/manage_budget.php?id="+$(this).attr('data-id'),"mid-large")
		})
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable();
	})
	function delete_category($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_budget",
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
</script> -->
<script>
    $(document).ready(function() {
        $('.delete_data').click(function() {
            var budgetId = $(this).attr('data-id'); // Get the data-id
            console.log("Sending delete request for ID: " + budgetId); // Log the ID
            _conf("Are you sure to delete this Budget amount permanently?", "delete_category", [budgetId]);
        });
        $('#create_new').click(function() {
            uni_modal("<i class='fa fa-plus' style='color:black;'></i> <label style='color:black';>Add New Budget</label>", "maintenance/manage_budget.php", "mid-large");
        });
        $('.edit_data').click(function() {
            uni_modal("<i class='fa fa-plus' style='color:black;'></i> <label style='color:black';>Add New Budget</label>", "maintenance/manage_budget.php?id=" + $(this).attr('data-id'), "mid-large");
        });
        $('.table td, .table th').addClass('py-1 px-2 align-middle');
        $('.table').dataTable();
    });

    function delete_category($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_budget",
            method: "POST",
            data: { id: $id },
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        });
    }
</script>
