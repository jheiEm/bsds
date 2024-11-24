<?php
// include('db.php');
//
// Fetch all individuals (Initially, no filter)
//$scheme_list_qry = $conn->query("SELECT * FROM scheme_list where id ='{$scheme_id}'");
//$result_scheme = $scheme_list_qry->fetch_array();

?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Individual</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <table class="table table-bordered table-stripped">
                    <colgroup>
                        <col width="4%">
                        <col width="4%">
                        <col width="10%">
                        <col width="15%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="25%">
                        <!--					<col width="5%">-->
                        <!--					<col width="5%">-->
                    </colgroup>
                    <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>#</th>
                        <th>Tracking Code</th>
                        <th>Name</th>
                        <th hidden>Gender</th>
                        <th>Scheme</th>
                        <th>Contact</th>

                        <th>Schedule of Disbursement</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    $qry = $conn->query("SELECT *,concat(lastname,', ',firstname,' ', middlename) as name from `individual_list` where status = 1  and status_client = 0 order by concat(lastname,', ',firstname,' ', middlename) asc ");
                    while($row = $qry->fetch_assoc()):
                        $scheme_id = $row['scheme_id'];
                        ?>
                        <tr>
                            <td><input type="checkbox" class="individualCheck" data-id="<?= $row['id'] ?>"></td>
                            <td class="text-center"><?php echo $row['id'] ?></td>
                            <td><?php echo $row['tracking_code'] ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td hidden><?php echo $row['gender'] ?></td>
                            <?php
                            // Fetch the scheme name based on scheme_id
                            $scheme_list_qry = $conn->query("SELECT name FROM scheme_list WHERE id = '{$scheme_id}'");
                            // Fetch the result from scheme_list
                            $result_scheme = $scheme_list_qry->fetch_assoc();
                            $scheme_name = $result_scheme ? $result_scheme['name'] : 'No Scheme'; // Handle missing scheme
                            ?>
                            <td><?php echo $scheme_name; ?></td>
                            <td><?php echo $row['contact'] ?></td>
                            <td style="font-size: 10px;" >
                                <?php
                                if ($row['schedule'] == "0000-00-00" || $row['schedule'] == "0000-00-00 00:00:00" ) {
                                    echo '<span style="text-align:center" >Disbursement Schedule Pending.</span>';
                                }
                                else {
                                    $schedule = date('F-d-Y h:i a', strtotime($row['schedule']));
                                    echo 'Disbursement Schedule: ' . $schedule . '<br>';
                                }

                                ?>
                            </td>
                            <td class="text-center">
                                <?php if($row['status'] == 1): ?>
                                    <!--                                    <span class="badge badge-primary rounded-pill">Disbursement Completed (Partially Disbursed)</span>-->
                                    <span class="badge badge-primary rounded-pill">Approved for Disbursement</span>
                                <?php elseif($row['status'] == 3): ?>
                                    <span style="background-color:red;border-radius:20px;padding:5px;">Cancelled</span>
                                <?php else: ?>


                                    <span class="badge badge-light text-dark rounded-pill">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td align="center">
                                <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    Action
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="?page=individual/view_details&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
                                    <a class="dropdown-item" href="?page=individual/manage_individual&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
                <button id="massUpdateBtn" class="btn btn-success">Approved for Fully Disbursed</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.delete_data').click(function(){
            _conf("Are you sure to delete this Individual permanently?","delete_individual",[$(this).attr('data-id')])
        })
        $('.table td,.table th').addClass('py-1 px-2 align-middle')
        $('.table').dataTable();
    })
    function delete_individual($id){
        start_loader();
        $.ajax({
            url:_base_url_+"classes/Master.php?f=delete_individual",
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

    // Initialize DataTable

    // $('#individualTable').DataTable({
    //     columnDefs: [
    //         { targets: 1, searchable: false } // Disable search/filter for the first column
    //     ]
    // });
    // Select All Checkboxes
    $('#selectAll').on('click', function () {
        $('.individualCheck').prop('checked', this.checked);
    });


    $('#massUpdateBtn').on('click', function() {
        // Collect selected individual IDs
        var selectedIds = [];
        $('.individualCheck:checked').each(function() {
            selectedIds.push($(this).data('id'));
        });

        // Ensure at least one record is selected
        if (selectedIds.length === 0) {
            alert('Please select at least one individual');
            return;
        }

        // Prompt for new status
        var newStatus = prompt("Enter new status (0: Pending, 1: Approved for Disbursement, 2: Fully Disbursed):");

        // Validate input
        if (newStatus !== '0' && newStatus !== '1' && newStatus !== '2') {
            alert('Invalid status value');
            return;
        }
        if (newStatus === '2') {
            var disbursementDate = prompt("Enter disbursement date (YYYY-MM-DD):");

            // Validate date format
            var dateRegex = /^\d{4}-\d{2}-\d{2}$/;
            if (!dateRegex.test(disbursementDate)) {
                alert('Invalid date format. Please use YYYY-MM-DD.');
                return;
            }


            // You can now use disbursementDate variable as needed, for example, log it
            console.log('Disbursement Date:', disbursementDate);
        }

        if (newStatus === '2') {
            var reviewedBy = prompt("Enter reviewed by:");
        }

        // Send AJAX request to update the selected records
        $.ajax({
            url: 'individual/mass_update.php', // We'll create this file next
            type: 'POST',
            data: { ids: selectedIds, status: newStatus, disbursement_date: disbursementDate, reviewed_by: reviewedBy },
            success: function(response) {
                alert(response);
                location.reload(); // Reload page to reflect the changes
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('An error occurred during the mass update');
            }
        });
    });
</script>