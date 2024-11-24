<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Reschedule Requests</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered table-striped">
                <colgroup>
                    <col width="5%">
                    <col width="10%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="5%">
                </colgroup>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Tracking ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Remarks</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                $qry = $conn->query("SELECT r.*, CONCAT(i.lastname, ', ', i.firstname, ' ', i.middlename) AS name 
                                          FROM reschedule_list r 
                                          LEFT JOIN individual_list i ON r.email = i.email 
                                          ORDER BY r.initiated_date DESC");

                while ($row = $qry->fetch_assoc()):
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td><?php echo $row['id']; ?></td> <!-- Assuming ID as tracking code -->
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo date('F d, Y', strtotime($row['from_date'])); ?></td>
                        <td><?php echo date('F d, Y', strtotime($row['to_date'])); ?></td>
                        <td><?php echo htmlspecialchars($row['remarks']); ?></td>
                        <td class="text-center">
                            <?php if ($row['status'] == 0): ?>
                                <span class="badge badge-primary rounded-pill">Pending</span>
                            <?php elseif ($row['status'] == 2): ?>
                                <span class="badge badge-success rounded-pill">Completed</span>
                            <?php elseif ($row['status'] == 3): ?>
                                <span style="background-color:red;border-radius:20px;padding:5px;">Cancelled</span>
                            <?php else: ?>
                                <span class="badge badge-light text-dark rounded-pill">Unknown</span>
                            <?php endif; ?>
                        </td>
                        <td align="center">
                            <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                Action
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="?page=reschedule/view_details&id=<?php echo $row['id']; ?>"><span class="fa fa-eye text-dark"></span> View</a>
                                <a class="dropdown-item" href="?page=reschedule/edit&id=<?php echo $row['id']; ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.delete_data').click(function(){
            _conf("Are you sure to delete this request permanently?", "delete_reschedule", [$(this).attr('data-id')])
        });
        $('.table td, .table th').addClass('py-1 px-2 align-middle');
        $('.table').dataTable();
    });

    function delete_reschedule($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_reschedule",
            method: "POST",
            data: {id: $id},
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
