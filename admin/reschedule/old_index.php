<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Reschedule Requests</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <table class="table table-bordered table-stripped">
                    <colgroup>
                        <col width="5%">
                        <col width="10%">
                        <col width="15%">
                        <col width="5%">
                        <col width="15%">
                        <col width="10%">
                        <col width="25%">
                        <col width="5%">
                        <col width="5%">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Tracking Code</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>

                        <th>Schedule of Disbursement</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    $qry = $conn->query("SELECT *,concat(lastname,', ',firstname,' ', middlename) as name from `individual_list` order by concat(lastname,', ',firstname,' ', middlename) asc ");
                    while($row = $qry->fetch_assoc()):
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td><?php echo $row['tracking_code'] ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['gender'] ?></td>

                            <td><?php echo $row['contact'] ?></td>
                            <td style="font-size: 10px;" >
                                <?php
                                if ($row['schedule'] == "0000-00-00" || $row['schedule'] == "0000-00-00 00:00:00" ) {
                                    echo '<span style="text-align:center" >First Disbursement Schedule Pending.</span>';
                                }

                                else if ($row['schedule_2'] == "0000-00-00" || $row['schedule_2'] == "0000-00-00 00:00:00" ) {
                                    $schedule = date('F-d-Y h:i a', strtotime($row['schedule']));
                                    echo 'First Disbursement Schedule: ' . $schedule . '<br>';
                                    echo '<span style="text-align:center" > Second Disbursement Schedule Pending. </span>';
                                }

                                else if ($row['schedule_3'] == "0000-00-00" || $row['schedule_3'] == "0000-00-00 00:00:00" ) {
                                    $schedule = date('F-d-Y h:i a', strtotime($row['schedule']));
                                    echo 'First Disbursement Schedule: ' . $schedule . '<br>';
                                    $schedule_2 = date('F-d-Y h:i a', strtotime($row['schedule_2']));
                                    echo 'Second Disbursement Schedule: ' . $schedule_2 . '<br>';
                                    $schedule_3 = date('F-d-Y h:i a', strtotime($row['schedule_3']));
                                    echo '<span style="text-align:center"> Third Disbursement Schedule Pending </span>';
                                }

                                else {
                                    $schedule = date('F-d-Y h:i a', strtotime($row['schedule']));
                                    echo 'First Disbursement Schedule: ' . $schedule . '<br>';
                                    $schedule_2 = date('F-d-Y h:i a', strtotime($row['schedule_2']));
                                    echo 'Second Disbursement Schedule: ' . $schedule_2 . '<br>';
                                    $schedule_3 = date('F-d-Y h:i a', strtotime($row['schedule_3']));
                                    echo 'Third Disbursement Schedule: ' . $schedule_3 . '<br>';
                                }

                                ?>
                            </td>
                            <td class="text-center">
                                <?php if($row['status'] == 1): ?>
                                    <span class="badge badge-primary rounded-pill">1st Disbursement Completed (Partially Disbursed)</span>
                                <?php elseif($row['status'] == 2): ?>
                                    <span class="badge badge-success rounded-pill">2nd Disbursement Completed (Partially Disbursed)</span>
                                <?php elseif($row['status'] == 4): ?>
                                    <span class="badge badge-success rounded-pill">3rd Disbursement Completed (Fully Disbursed)</span>
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
</script>