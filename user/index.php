<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('../inc/header.php') ?>
<body class="bg-light">
<script>
    start_loader()
</script>
<style>
    html, body {
        width: 100%;
        height: 100%;
        font-size: 16px;
    }
    body {
        background: linear-gradient(to right, #ece9e6, #ffffff);
    }
    #logo-img {
        width: 15em;
        height: 15em;
        object-fit: scale-down;
        object-position: center center;
    }
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .pass_type {
        cursor: pointer;
    }
</style>

<div class="d-flex align-items-center justify-content-center h-100">
    <div class="col-lg-7">
        <div class="card bg-white">
            <div class="card-header text-center">
                <h4 class="font-weight-bold">Create an Account</h4>
            </div>
            <div class="card-body">
                <form id="register-frm" action="" method="post">
                    <input type="hidden" name="id">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="firstname">First Name</label>
                            <input type="text" name="firstname" id="firstname" placeholder="Enter First Name" autofocus class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="middlename">Middle Name (optional)</label>
                            <input type="text" name="middlename" id="middlename" placeholder="Enter Middle Name" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Last Name</label>
                            <input type="text" name="lastname" id="lastname" placeholder="Enter Last Name" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender" class="custom-select" required>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="contact">Contact #</label>
                            <input type="text" name="contact" id="contact" placeholder="Enter Contact #" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="address">Address</label>
                            <textarea name="address" id="address" rows="3" class="form-control" placeholder="Your Address"></textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" placeholder="jsmith@sample.com" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control" required>
                                <div class="input-group-append">
                                    <span class="input-group-text pass_type" data-type="password"><i class="fa fa-eye-slash text-muted"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cpassword">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" id="cpassword" class="form-control" required>
                                <div class="input-group-append">
                                    <span class="input-group-text pass_type" data-type="password"><i class="fa fa-eye-slash text-muted"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-8">
                            <a href="<?php echo base_url ?>">Back to Site</a>
                        </div>
                        <div class="col-4 text-right">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function(){
        end_loader();
        $('.pass_type').click(function(){
            var type = $(this).attr('data-type');
            if (type == 'password') {
                $(this).attr('data-type', 'text');
                $(this).closest('.input-group').find('input').attr('type', "text");
                $(this).find('i').removeClass("fa-eye-slash").addClass("fa-eye");
            } else {
                $(this).attr('data-type', 'password');
                $(this).closest('.input-group').find('input').attr('type', "password");
                $(this).find('i').removeClass("fa-eye").addClass("fa-eye-slash");
            }
        });

        $('#register-frm').submit(function(e){
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            var el = $('<div>').hide();

            if ($('#password').val() != $('#cpassword').val()) {
                el.addClass('alert alert-danger err-msg').text('Passwords do not match.');
                _this.prepend(el);
                el.show('slow');
                return false;
            }

            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Clients.php?f=save_client",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                dataType: 'json',
                error: function(err) {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.href = "./login.php";
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        el.addClass("alert alert-danger err-msg").text(resp.msg);
                        _this.prepend(el);
                        el.show('slow');
                    } else {
                        alert_toast("An error occurred", 'error');
                        end_loader();
                        console.log(resp);
                    }
                    $('html, body').scrollTop(0);
                }
            });
        });
    });
</script>
</body>
</html>
