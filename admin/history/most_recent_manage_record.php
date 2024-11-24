<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `scholar_history_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
    $individual_qry = $conn->query("SELECT *,concat(lastname,', ', firstname, ' ', middlename ) as name FROM individual_list where id ='{$individual_id}'");
    $result_indi = $individual_qry->fetch_array();
}
?>
<style>
    span.select2-selection.select2-selection--single {
        border-radius: 0;
        padding: 0.25rem 0.5rem;
        padding-top: 0.25rem;
        padding-right: 0.5rem;
        padding-bottom: 0.25rem;
        padding-left: 0.5rem;
        height: auto;
    }

</style>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($id) ? "Update ": "  Create New " ?> Record</h3>
    </div>
    <div class="card-body">
        <form action="" id="history-form">
            <input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="form-group <?php echo isset($id) ? 'd-none':'' ?>">
                <div class="custom-control custom-radio" style="display:none;">
                    <input  class="custom-control-input" type="radio" id="indo_prev" value='1' name="indiRadio" checked>
                    <label for="indo_prev" class="custom-control-label" >Already Registered</label>
                </div>

            </div>
            <hr class="border-light">
            <fieldset id="prev_form" class="d-none">
                <input type="hidden" name="individual_id" required value="<?php echo isset($individual_id) ? $individual_id : '' ?>">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="tracking_code" class="control-label">Tracking Code</label>
                        <input type="text" class="form-control form-control-sm rounded-0" id="tracking_code" value="<?php echo isset($result_indi['tracking_code']) ? $result_indi['tracking_code'] :'' ?>">
                    </div>
                </div>
                <div id="indiviual_info" class="row">
                    <div class="col-md-6">
                        <dl>
                            <dt class="text-muted">Individual Name:</dt>
                            <dd class="pl-4 indi_name"><?php echo isset($result_indi['name']) ? $result_indi['name'] : '' ?></dd>



                            <dt class="text-muted">Mother's Name:</dt>
                            <dd class="pl-4 indi_mothername"><?php echo isset($result_indi['mother_fullname']) ? $result_indi['mother_fullname'] : '' ?></dd>
                            <dt class="text-muted">Father's Name:</dt>
                            <dd class="pl-4 indi_fathername"><?php echo isset($result_indi['father_fullname']) ? $result_indi['father_fullname'] : '' ?></dd>


                            <dt class="text-muted">Gender:</dt>
                            <dd class="pl-4 indi_gender"><?php echo isset($result_indi['gender']) ? $result_indi['gender'] : '' ?></dd>
                            <dt class="text-muted">Date of Birth:</dt>
                            <dd class="pl-4 indi_dob"><?php echo isset($result_indi['dob']) ? date("M d, Y",strtotime($result_indi['dob'])) : '' ?></dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl>

                            <dt class="text-muted">Contact:</dt>
                            <dd class="pl-4 indi_contact"><?php echo isset($result_indi['contact']) ? $result_indi['contact'] : '' ?></dd>
                            <dt class="text-muted">Address:</dt>
                            <dd class="pl-4 indi_address"><?php echo isset($result_indi['address']) ? $result_indi['address'] : '' ?></dd>


                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl>


                            <dt class="text-muted">Requested Scholarship Location:</dt>
                            <dd class="pl-4 indi_districtname"><?php echo isset($result_indi['district_name']) ? $result_indi['district_name'] : '' ?></dd>

                            <dt class="text-muted">Disbursement Status:</dt>
                            <dd class="pl-4 ">
                            <dd class="pl-4 indi_status"><?php echo isset($result_indi['status']) ? $result_indi['status'] : '' ?></dd>



                        </dl>




                    </div>
            </fieldset>

            <fieldset id="new_form" class="d-none">
                <h6>Parent Details<h6>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mother_name" class="control-label">Mother's Fullname</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" id="mother_fullname" name="mother_fullname">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="father_name" class="control-label">Father's Fullname</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" id="father_fullname" name="father_fullname">
                                </div>
                            </div>
                        </div>

                        <h6>Student Details<h6>
                                <div class="form-group row">

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label for="lastname" class="control-label">Last Name</label>
                                            <input type="text" class="form-control form-control-sm rounded-0" id="lastname" name="lastname">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstname" class="control-label">First Name</label>
                                            <input type="text" class="form-control form-control-sm rounded-0" id="firstname" name="firstname">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="middlename" class="control-label">Middle Name</label>
                                            <input type="text" class="form-control form-control-sm rounded-0" id="middlename" name="middlename">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="age" class="control-label">Age</label>
                                            <input type="text" class="form-control form-control-sm rounded-0" id="age" name="age">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gender" class="control-label">Gender</label>
                                            <select class="form-control form-control-sm rounded-0" id="gender" name="gender">
                                                <option>Male</option>
                                                <option>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dob" class="control-label">Date of Birth</label>
                                            <input type="date" class="form-control form-control-sm rounded-0" id="dob" name="dob">
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact" class="control-label">Contact #</label>
                                            <input type="text" pattern="[0-9\s\/+]+" class="form-control form-control-sm rounded-0" id="contact" name="contact">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address" class="control-label">Address</label>
                                            <textarea rows="2" class="form-control form-control-sm rounded-0" id="address" name="address" style="resize:none"></textarea>
                                        </div>
                                    </div>
                                </div>
            </fieldset>
            <hr class="border-light">
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="scheme_id">Scholarship Grant</label>
                    <select name="scheme_id" id="scheme_id" class="custom-select custom-select-sm select2" required>
                        <option value="" disabled <?php echo !isset($scheme_id) ? "selected" :'' ?>></option>
                        <?php
                        $vaccine_qry = $conn->query("SELECT * FROM scheme_list where `status` = 1 order by `name` asc ");
                        while($row = $vaccine_qry->fetch_assoc()):
                            ?>
                            <option value="<?php echo $row['id'] ?>" <?php echo isset($scheme_id) && $scheme_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>


            <div class="form-group row">
                <div class="col-md-6">
                    <div class="mb-2">
                        <label for="disbursement_status" class="control-label">Scholarship Disbursement Status</label>
                        <select name="disbursement_status" id="disbursement_status" class="custom-select select" required>
                            <option <?php echo isset($disbursement_status) && $disbursement_status == 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option <?php echo isset($disbursement_status) && $disbursement_status == 'Schedule of Disbursement Completed (Partially Disbursed)' ? 'selected' : '' ?>>Schedule of Disbursement Completed (Partially Disbursed)</option>
                        </select>
                    </div>
                    <div class="">
                        <label for="reviewed_by">Disbursed By</label>
                        <textarea rows="2" class="form-control form-control-sm rounded-0" id="reviewed_by" name="reviewed_by" style="resize:none" required><?php echo isset($reviewed_by) ? $reviewed_by : '' ?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="remarks">Remarks</label>
                    <textarea rows="6" class="form-control form-control-sm rounded-0" id="remarks" name="remarks" style="resize:none" required><?php echo isset($remarks) ? $remarks : '' ?></textarea>
                </div>
            </div>

            <?php if($_settings->userdata('type') == 1): ?>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="location_id" class="control-label">Disbursement Location</label>
                    <select name="location_id" id="location_id" class="custom-select custom-select-sm select2" required>
                        <option value="" disabled <?php echo !isset($location_id) ? "selected" :'' ?>></option>
                        <?php
                        $location_qry = $conn->query("SELECT * FROM scholar_location_list where `status` = 1 order by `location` asc ");
                        while($row = $location_qry->fetch_assoc()):
                            ?>
                            <option value="<?php echo $row['id'] ?>" <?php echo isset($location_id) && $location_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['location'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
    </div>
    <?php else: ?>
        <input type="hidden" name="location_id" value="<?php echo $_settings->userdata('location_id') ?>">
    <?php endif; ?>

    </form>
</div>
<div class="card-footer">
    <button class="btn btn-flat btn-primary" form="history-form">Save</button>
    <a class="btn btn-flat btn-default" href="?page=history">Cancel</a>
</div>
</div>
<script>
    function check_individual_type(){
        var radio = $('[name="indiRadio"]:checked').val()
        if(radio == 1){
            $('#prev_form').removeClass('d-none')
            $('#prev_form').find('input, textarea, select').each(function(){
                $(this).attr('required',true)
            })
            $('#new_form').find('input, textarea, select').each(function(){
                $(this).removeAttr('required')
            })
        }else{
            $('#new_form').removeClass('d-none')
            $('#new_form').find('input, textarea, select').each(function(){
                $(this).attr('required',true)
            })
            $('#prev_form').find('input, textarea, select').each(function(){
                $(this).removeAttr('required')
            })
        }
    }
    $(document).ready(function(){
        check_individual_type()
        $('[name="indiRadio"]').change(function(){
            $('#prev_form,#new_form').addClass('d-none')
            check_individual_type()
        })
        $('.select2').select2({placeholder:"Please Select here",width:"relative"})
        $('#history-form').submit(function(e){
            e.preventDefault();
            if($('#prev_form').hasClass('d-none') == false && $('[name="individual_id"]').val() <= 0 && $('[name="id"]').val() > 0){
                alert_toast("Unknown Individual.",'warning')
                return false;
            }
            var _this = $(this)
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_history",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error:err=>{
                    console.log(err)
                    alert_toast("An error occurred",'error');
                    end_loader();
                },
                success:function(resp){
                    if(typeof resp =='object' && resp.status == 'success'){
                        location.href = "./?page=history/view_details&id="+resp.id;
                    }else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                        el.addClass("alert alert-danger err-msg").text(resp.msg)
                        _this.prepend(el)
                        el.show('slow')
                        $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                        end_loader()
                    }else{
                        alert_toast("An error occurred",'error');
                        end_loader();
                        console.log(resp)
                    }
                }
            })
        })

        $('#tracking_code').on('input',function(){
            var code = $(this).val()
            $('#indiviual_info dd').text('')
            $('[name="individual_id"]').val('')
            if(code == ''){
                return false;
            }
            $.ajax({
                url:_base_url_+'classes/Master.php?f=get_individual',
                method:'post',
                data:{code:code},
                dataType:'json',
                error:err=>{
                    console.log(err)
                    alert_toast("An error occurred while fetching individual details",'error')
                },
                success:function(resp){
                    if(!!resp.id){
                        $('[name="individual_id"]').val(resp.id)
                        $('dd.indi_name').text(resp.name)
                        $('dd.indi_gender').text(resp.gender)
                        $('dd.indi_dob').text(resp.dob)

                        $('dd.indi_contact').text(resp.contact)
                        $('dd.indi_address').text(resp.address)
                        $('dd.indi_schemeid').text(resp.scheme_id)
                        $('dd.indi_districtname').text(resp.district_name)
                        $('dd.indi_mothername').text(resp.mother_fullname)
                        $('dd.indi_fathername').text(resp.father_fullname)

                        if (resp.status == 0) {
                            $('dd.indi_status').text('Pending');
                        } else if (resp.status == 1) {
                            $('dd.indi_status').text('Schedule of Disbursement Completed (Partially Disbursed)');
                        } else if (resp.status == 3) {
                            $('dd.indi_status').text('Cancelled');
                        } else {
                            $('dd.indi_status').text(resp.status);
                        }

                    }
                }
            })

        })
    })
</script>