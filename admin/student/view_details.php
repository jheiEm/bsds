<?php
// Fetch the student details
$qry = $conn->query("SELECT *, CONCAT(lastname, ', ', firstname, ' ', middlename) AS name 
                     FROM student_list WHERE id = '{$_GET['id']}'");

if ($qry->num_rows > 0) {
    $student = $qry->fetch_assoc();
}

// Fetch the disbursement history from the disbursement_history table
$disbursement_qry = $conn->query("SELECT * FROM `disbursement_history` WHERE individual_id = '{$student['id']}' ORDER BY disbursed_date ASC");
?>
<div class="card card-outline card-primary">
    <div class="card-header d-flex">
        <h5 class="card-title col-auto flex-grow-1">Student Record</h5>
        <div class="col-auto">
            <button class="btn btn-sm btn-success btn-flat mr-2" type="button" id="print">
                <i class="fa fa-print"></i> Print
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid" id="print_out">
            <div class="row">
                <div class="col-6">
                    <dl>
                        <dt class="text-muted">Student's Name:</dt>
                        <dd class="pl-4"><?php echo isset($student['name']) ? $student['name'] : '' ?></dd>
                        <dt class="text-muted">Gender:</dt>
                        <dd class="pl-4"><?php echo isset($student['gender']) ? $student['gender'] : '' ?></dd>
                        <dt class="text-muted">Age:</dt>
                        <dd class="pl-4"><?php echo isset($student['age']) ? $student['age'] : '' ?></dd>
                        <dt class="text-muted">Philhealth No:</dt>
                        <dd class="pl-4"><?php echo isset($student['philhealth_no']) ? $student['philhealth_no'] : '' ?></dd>
                    </dl>
                </div>
                <div class="col-6">
                    <dl>
                        <dt class="text-muted">Date of Birth:</dt>
                        <dd class="pl-4"><?php echo isset($student['dob']) ? date("M d, Y", strtotime($student['dob'])) : '' ?></dd>
                        <dt class="text-muted">Contact:</dt>
                        <dd class="pl-4"><?php echo isset($student['contact']) ? $student['contact'] : '' ?></dd>
                        <dt class="text-muted">Address:</dt>
                        <dd class="pl-4"><?php echo isset($student['address']) ? $student['address'] : '' ?></dd>
                    </dl>
                </div>
            </div>

            <h4><b>Disbursement History</b></h4>
            <table class="table table-striped table-bordered">
                <colgroup>
                    <col width="15%">
                    <col width="25%">
                    <col width="20%">
                    <col width="25%">
                    <col width="15%">
                </colgroup>
                <thead>
                <tr>
                    <th>DateTime</th>
                    <th>Transaction ID</th>
                    <th>Scheme ID</th>
                    <th>Disbursed Amount</th>
                    <th>Disbursed By</th>
                    <th>Remarks</th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($row = $disbursement_qry->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo date("M d, Y H:i", strtotime($row['disbursed_date'])) ?></td>
                        <td><?php echo $row['transaction_id'] ?></td>
                        <td><?php echo $row['scheme_id'] ?></td>
                        <td><?php echo $row['disbursed_amount'] ?></td>
                        <td><?php echo $row['disbursed_by'] ?></td>
                        <td><?php echo $row['remarks'] ?></td>
                    </tr>
                <?php endwhile; ?>
                <?php if ($disbursement_qry->num_rows <= 0): ?>
                    <tr>
                        <th colspan="6" class="text-center">No data listed yet</th>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('.table td, .table th').addClass('py-1 px-2 align-middle');
        $('#print').click(function(){
            start_loader();
            var _el = $('<div>');
            var _head = $('head').clone();
            _head.find('title').text("Student Record Details - Print View");
            var p = $('#print_out').clone();
            p.find('.btn').remove();
            _el.append(_head);
            _el.append('<div class="d-flex justify-content-center">'+
                '<div class="col-1 text-right">'+
                '<img src="<?php echo validate_image($_settings->info('logo')) ?>" width="65px" height="65px" />'+
                '</div>'+
                '<div class="col-10">'+
                '<h5 class="text-center">Republic of the Philippines</h5>'+
                '<h5 class="text-center">Province of Batangas</h5>'+
                '<h5 class="text-center">Student Details and Disbursement History</h5>'+
                '</div>'+
                '<div class="col-1 text-right">'+
                '</div>'+
                '</div><hr/>');
            _el.append(p.html());
            var nw = window.open("", "", "width=1200,height=900,left=250,location=no,titlebar=yes");
            nw.document.write(_el.html());
            nw.document.close();
            setTimeout(() => {
                nw.print();
                setTimeout(() => {
                    nw.close();
                    end_loader();
                }, 200);
            }, 300);
        });
    });
</script>
