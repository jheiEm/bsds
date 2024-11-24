<h1 class="text-light">Welcome to <?php echo $_settings->info('name') ?></h1>
<hr class="border-light">
<div class="row">
          

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-syringe"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Fully Disbursed</span>
                <span class="info-box-number">
                <?php 
                    $individual = $conn->query("SELECT * FROM individual_list where `status` = 2 ")->num_rows;
                    echo number_format($individual);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
	 <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
           <span class="info-box-icon " style="background-color:#454D55"><i class="fas fa-head-side-cough"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total 1st Disbursement</span>
                <span class="info-box-number">
                <?php 
                    $individual = $conn->query("SELECT * FROM student_list where `disease` = 'Cough' ")->num_rows;
                    echo number_format($individual);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

	 <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
             <span class="info-box-icon " style="background-color:#454D55"><i class="fas fa-lungs-virus"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total 2nd Disbursement</span>
                <span class="info-box-number">
                <?php 
                    $individual = $conn->query("SELECT * FROM student_list where `disease` = 'Pneumonia' ")->num_rows;
                    echo number_format($individual);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

     <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
             <span class="info-box-icon " style="background-color:#454D55"><i class="fas fa-head-side-virus"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total 3rd Disbursement</span>
                <span class="info-box-number">
                <?php 
                    $individual = $conn->query("SELECT * FROM student_list where `disease` = 'Fever' ")->num_rows;
                    echo number_format($individual);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

<div class="col-12 col-sm-6 col-md-3" >
            <div class="info-box mb-3">
              <span class="info-box-icon " style="background-color:#454D55"><i class="fas fa-virus"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Fully Disbursement</span>
                <span class="info-box-number">
                <?php 
                    $individual = $conn->query("SELECT * FROM student_list where `disease` = 'Rashes' ")->num_rows;
                    echo number_format($individual);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

    

    
        </div>
	
	

	
	   
<div class="container">
  
</div>
