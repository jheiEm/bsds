<?php
require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `student_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v; // Dynamically assign values from database to variables
        }
    }
}
?>
<style>
    .control-label{
        color:Black;
    }
</style>
<div class="container-fluid">
    <form action="" id="vaccine-form">
        <div class="row">
            <input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">

            <!-- First Name -->
            <div class="form-group col-md-6">
                <label for="firstname" class="control-label">First Name</label>
                <input type="text" name="firstname" id="firstname" class="form-control form-control-border" placeholder="First Name" value="<?php echo isset($firstname) ? $firstname : ''; ?>" required>
            </div>

            <!-- Middle Name -->
            <div class="form-group col-md-6">
                <label for="middlename" class="control-label">Middle Name</label>
                <input type="text" name="middlename" id="middlename" class="form-control form-control-border" placeholder="Middle Name" value="<?php echo isset($middlename) ? $middlename : ''; ?>" required>
            </div>

            <!-- Last Name -->
            <div class="form-group col-md-6">
                <label for="lastname" class="control-label">Last Name</label>
                <input type="text" name="lastname" id="lastname" class="form-control form-control-border" placeholder="Last Name" value="<?php echo isset($lastname) ? $lastname : ''; ?>" required>
            </div>

            <!-- Suffix -->
            <div class="form-group col-md-6">
                <label for="suffix" class="control-label">Suffix (if any)</label>
                <input type="text" name="suffix" id="suffix" class="form-control form-control-border" placeholder="e.g Jr./Sr." value="<?php echo isset($suffix) ? $suffix : ''; ?>" required>
            </div>

            <!-- Gender -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="gender" class="control-label" style="color:Black;">Gender</label>
                    <select class="form-control form-control-sm rounded-0" id="gender" name="gender">
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                </div>
            </div>

            <!-- Date of Birth -->
            <div class="form-group col-md-6">
                <label for="dob" class="control-label">Date of Birth</label>
                <input type="date" name="dob" id="dob" class="form-control form-control-border" placeholder="Date of Birth" value="<?php echo isset($dob) ? date('Y-m-d', strtotime($dob)) : ''; ?>" required>
            </div>

            <!-- Age -->
            <script>
                // JavaScript to calculate age dynamically
                document.getElementById('dob').addEventListener('change', function() {
                    var dob = new Date(this.value); // Get the DOB date
                    var today = new Date(); // Get today's date
                    var age = today.getFullYear() - dob.getFullYear(); // Basic age calculation

                    // Check if the birthday has already occurred this year
                    var monthDifference = today.getMonth() - dob.getMonth();
                    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dob.getDate())) {
                        age--; // If birthday hasn't occurred yet, subtract 1 year
                    }

                    // Set the calculated age into the input field
                    document.getElementById('age').value = age;
                });
            </script>
            <?php

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Assume $_POST['dob'] is the user's selected Date of Birth from the form
                if (!empty($_POST['dob'])) {
                    $dob = $_POST['dob'];

                    // Calculate age from Date of Birth
                    $dobDate = new DateTime($dob);
                    $today = new DateTime();
                    $age = $today->diff($dobDate)->y; // Calculate the difference in years

                    // Now you can use $age for further processing or saving into the database
                }
            }
            ?>
            <div class="form-group col-md-6">
                <label for="age" class="control-label">Age</label>
                <input type="text" name="age" id="age" class="form-control form-control-border" placeholder="Age" value="<?php echo isset($age) ? $age : ''; ?>" readonly required>
            </div>

            <!-- Contact -->
            <div class="form-group col-md-6">
                <label for="contact" class="control-label">Contact</label>
                <input type="text" name="contact" id="contact" class="form-control form-control-border" placeholder="Contact" value="<?php echo isset($contact) ? $contact : ''; ?>" required>
            </div>

            <!-- Address -->
            <div class="form-group col-md-12">
                <label for="address" class="control-label">Address</label>
                <textarea rows="3" name="address" id="address" class="form-control form-control-sm rounded-0" placeholder="Block 6, Lot 23, Here Subd., There City, 2306" required><?php echo isset($address) ? $address : '' ?></textarea>
            </div>

            <!-- Status -->
            <div class="form-group col-md-6">
                <label for="status" class="control-label" style="color:Black;">Status</label>
                <select name="status" id="status" class="form-control form-control-border" required>
                    <option value="active" <?php echo isset($status) && $status == 'active' ? 'selected' : ''; ?>>Active</option>
                    <option value="inactive" <?php echo isset($status) && $status == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                    <option value="graduated" <?php echo isset($status) && $status == 'graduated' ? 'selected' : ''; ?>>Graduated</option>
                </select>
            </div>

            <!-- Disbursement Location -->
            <div class="form-group col-md-6">
                <label for="location_id" class="control-label" style="color:Black;">Disbursement Location</label>
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

            <!-- Remarks -->
            <div class="form-group col-md-12">
                <label for="remarks" class="control-label">Remarks: </label>
                <textarea rows="3" name="remarks" id="remarks" class="form-control form-control-sm rounded-0" placeholder="Remarks" required><?php echo isset($remarks) ? $remarks : '' ?></textarea>
            </div>

            <!-- Date Created -->
            <div class="form-group col-md-6">
                <label for="date_created" class="control-label">Date Created</label>
                <input type="text" name="date_created" id="date_created" class="form-control form-control-border" value="<?php echo isset($date_created) ? $date_created : ''; ?>" readonly>
            </div>

            <!-- Date Updated -->
            <div class="form-group col-md-6">
                <label for="date_updated" class="control-label">Date Updated</label>
                <input type="text" name="date_updated" id="date_updated" class="form-control form-control-border" value="<?php echo isset($date_updated) ? $date_updated : ''; ?>" readonly>
            </div>

        </div>
    </form>
</div>
<script>
    $(document).ready(function(){
        $('.select2').select2({placeholder:"Please Select here",width:"relative"})
        $('#vaccine-form').submit(function(e){
            e.preventDefault();
            var _this = $(this)
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_student",
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
                        location.reload();
                    }else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                        el.addClass("alert alert-danger err-msg").text(resp.msg)
                        _this.prepend(el)
                        el.show('slow')
                        end_loader()
                    }else{
                        alert_toast("An error occurred",'error');
                        end_loader();
                        console.log(resp)
                    }
                }
            })
        })

        $('.summernote').summernote({
            height: 200,
            toolbar: [
                [ 'style', [ 'style' ] ],
                [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
                [ 'fontname', [ 'fontname' ] ],
                [ 'fontsize', [ 'fontsize' ] ],
                [ 'color', [ 'color' ] ],
                [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
                [ 'table', [ 'table' ] ],
                [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
            ]
        })
    })
</script>
