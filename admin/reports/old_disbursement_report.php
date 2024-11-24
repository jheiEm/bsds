

<style>
    .img-thumb-path{
        width:100px;
        height:80px;
        object-fit:scale-down;
        object-position:center center;
    }
</style>
<?php
$from = isset($_GET['from']) ? $_GET['from'] : date("Y-m-d",strtotime(date("Y-m-d")." -1 week"));
$to = isset($_GET['to']) ? $_GET['to'] : date("Y-m-d",strtotime(date("Y-m-d")));
function duration($dur = 0){
    if($dur == 0){
        return "00:00";
    }
    $hours = floor($dur / (60 * 60));
    $min = floor($dur / (60)) - ($hours*60);
    $dur = sprintf("%'.02d",$hours).":".sprintf("%'.02d",$min);
    return $dur;
}
?>
<div class="card card-outline card-blue rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">Disbursement Student Record Report</h3>
        <div class="card-tools">
        </div>
    </div>
    <div class="card-body">
        <div class="callout border-primary">
            <fieldset>
                <legend>Filter</legend>
                <form action="" id="filter">
                    <div class="row align-items-end">
                        <div class="form-group col-md-3">
                            <label for="from" class="control-label">Date From</label>
                            <input type="date" name="from" id="from" value="<?= $from ?>" class="form-control form-control-sm rounded-0">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="to" class="control-label">Date To</label>
                            <input type="date" name="to" id="to" value="<?= $to ?>" class="form-control form-control-sm rounded-0">
                        </div>
                        <div class="form-group col-md-4">
                            <button class="btn btn-primary btn-flat btn-sm"><i class="fa fa-filter"></i> Filter</button>
                            <button class="btn btn-sm btn-flat btn-success" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                        </div>
                    </div>
                </form>
            </fieldset>
        </div>
        <div id="outprint">
            <style>
                #sys_logo{
                    object-fit:cover;
                    object-position:center center;
                    width: 6.5em;
                    height: 6.5em;
                }
            </style>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-2 d-flex justify-content-center align-items-center">
                        <img src="<?= validate_image($_settings->info('logo')) ?>" class="img-circle" id="sys_logo" alt="System Logo">
                    </div>
                    <div class="col-8">
                        <h4 class="text-center"><b>Republic of the Philippines</b></h4>
                        <h4 class="text-center"><b>Province of Batangas</b></h4>
                        <h3 class="text-center"><b>Scholarship Grant Record Report</b></h3>
                        <h5 class="text-center"><b>as of</b></h5>
                        <h5 class="text-center"><b><?= date("F d, Y", strtotime($from)). " - ".date("F d, Y", strtotime($to)) ?></b></h5>
                    </div>
                    <div class="col-2"></div>
                </div>
                <table class="table table-bordered table-hover table-striped">
                    <colgroup>
                        <col width="5%">
                        <col width="20%">
                        <col width="20%">
                        <col width="25%">
                        <col width="15%">
                        <col width="15%">
                    </colgroup>
                    <thead>
                    <tr class="bg-gradient-green text-light">
                        <th>#</th>
                        <th>Date/Time</th>
                        <th>Student's Name</th>
                        <th>Parent Details</th>
                        <th>Disbursement Info</th>
                        <th>Disbursement Status</th>
                        <th>Birthday</th>
                        <th>Contact</th>
                        <th>Age</th>
                        <th>Address</th>



                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    $where = "";
                    if($_settings->userdata('type') != 1){
                        $where = " where h.location_id = '{$_settings->userdata('location_id')}'";
                    }
                    $users = $conn->query("SELECT * FROM users");
                    $result = $users->fetch_all(MYSQLI_ASSOC);
                    $user_arr = array_column($result,'username','id');
                    $vaccine = $conn->query("SELECT * FROM scheme_list");
                    $vresult = $vaccine->fetch_all(MYSQLI_ASSOC);
                    $vax_arr = array_column($vresult,'name','id');
                    $individual = $conn->query("SELECT * FROM individual_list");
                    $iresult = $individual->fetch_all(MYSQLI_ASSOC);
                    $indiv_arr = array_column($iresult,'dob','id');
                    $contact = $conn->query("SELECT * FROM individual_list");
                    $cresult = $contact->fetch_all(MYSQLI_ASSOC);
                    $contact_arr = array_column($cresult,'contact','id');
                    $age = $conn->query("SELECT * FROM individual_list");
                    $aresult = $age->fetch_all(MYSQLI_ASSOC);
                    $age_arr = array_column($aresult,'age','id');
                    $mother = $conn->query("SELECT * FROM individual_list");
                    $mresult = $mother->fetch_all(MYSQLI_ASSOC);
                    $mother_arr = array_column($mresult,'mother_fullname','id');
                    $father = $conn->query("SELECT * FROM individual_list");
                    $fresult = $father->fetch_all(MYSQLI_ASSOC);
                    $father_arr = array_column($fresult,'father_fullname','id');
                    $location = $conn->query("SELECT * FROM scholar_location_list");
                    $lresult = $location->fetch_all(MYSQLI_ASSOC);
                    $location_arr = array_column($lresult,'location','id');
                    $address = $conn->query("SELECT * FROM individual_list");
                    $addresult = $address->fetch_all(MYSQLI_ASSOC);
                    $address_arr = array_column($addresult,'address','id');
                    // $status = $conn->query("SELECT * FROM scholar_history_list");
                    // $statusresult = $status->fetch_all(MYSQLI_ASSOC);
                    // $status_arr = array_column($statusresult,'status','id');
                    $qry = $conn->query("SELECT h.*,concat(i.lastname,', ',i.firstname,' ', i.middlename) as iname,i.tracking_code FROM `scholar_history_list` h inner join individual_list i on h.individual_id = i.id WHERE DATE(h.date_created) BETWEEN '{$from}' AND '{$to}'
						ORDER BY UNIX_TIMESTAMP(h.date_created) DESC");
                    while($row = $qry->fetch_assoc()):
                        ?>



                        <tr>
                            <td class="text-center py-1 px-2"><?php echo $i++; ?></td>
                            <td class="py-1 px-1"><?php echo date("M d,Y",strtotime($row['date_created'])) ; ?></td>
                            <td class="py-1 px-2">
                                <small><span class="text-muted">Code:</span> <b><?php echo $row['tracking_code'] ?></b></small> <br>
                                <small><span class="text-muted">Name:</span> <b><?php echo $row['iname'] ?></b></small>

                            </td>
                            <td class="py-1 px-2">
                                <small><span class="text-muted">Mother's Name:</span><b> <?php echo isset($mother_arr[$row['individual_id']]) ? $mother_arr[$row['individual_id']] : '' ; ?></b></small> <br>
                                <small><span class="text-muted">Father's Name:</span><b> <?php echo isset($father_arr[$row['individual_id']]) ? $father_arr[$row['individual_id']] : '' ; ?></b></small> <br>
                            </td>
                            <td class="py-1 px-2">
                                <small><span class="text-muted">Scholarship Type:</span> <b><?php echo isset($vax_arr[$row['scheme_id']]) ? $vax_arr[$row['vaccine_id']] : 'Vaccine was Deleted' ; ?></b></small> <br>

                                <small><span class="text-muted">Reviewed by:</span> <br/> <b><?php echo $row['reviewed_by'] ?></b></small>

                                <small><span class="text-muted"><br/>Location to be disbursed at: </span> <br/>  <b><?php echo isset($location_arr[$row['location_id']]) ? $location_arr[$row['location_id']] : '' ; ?></b></small> <br/>
                            </td>

                            <td class="py-1 px-2">


                                <small><span class="text-muted">status:</span> <b><?php echo $row['vaccination_type'] ?></b></small>






                            </td>



                            <td class="py-1 px-2">
                                <small><span class="text-muted"><b><?php echo isset($indiv_arr[$row['individual_id']]) ? $indiv_arr[$row['individual_id']] : '' ; ?></b></small> <br>
                            </td>
                            <td class="py-1 px-2">
                                <small><span class="text-muted"><b><?php echo isset($contact_arr[$row['individual_id']]) ? $contact_arr[$row['individual_id']] : '' ; ?></b></small> <br>
                            </td>
                            <td class="py-1 px-2">
                                <small><span class="text-muted"><b><?php echo isset($age_arr[$row['individual_id']]) ? $age_arr[$row['individual_id']] : '' ; ?></b></small> <br>
                            </td>
                            <td class="py-1 px-2">
                                <small><span class="text-muted"><b><?php echo isset($address_arr[$row['individual_id']]) ? $address_arr[$row['individual_id']] : '' ; ?></b></small> <br>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                    <?php if($qry->num_rows <= 0): ?>
                        <tr>
                            <th class="py-1 text-center" colspan="6">No Disbursement Record Found.</th>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.select2').select2({
            width:'100%'
        })
        $('#filter').submit(function(e){
            e.preventDefault();
            location.href= './?page=reports/disbursement_report&'+$(this).serialize();
        })
        $('#print').click(function(){
            start_loader()
            var _p = $('#outprint').clone()
            var _h = $('head').clone()
            var _el = $('<div>')
            _h.find("title").text("Student Record Report - Print View")
            _p.find('tr.text-light').removeClass('text-light bg-gradient-purple bg-lightblue')
            _el.append(_h)
            _el.append(_p)
            var nw = window.open("","_blank","width=1000,height=900,left=300,top=50")
            nw.document.write(_el.html())
            nw.document.close()
            setTimeout(() => {
                nw.print()
                setTimeout(() => {
                    nw.close()
                    end_loader()
                }, 300);
            }, 750);
        })
    })
</script>