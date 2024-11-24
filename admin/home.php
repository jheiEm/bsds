<h1 class="text-light">Welcome to <?php echo $_settings->info('name') ?></h1>
<hr class="border-light">
<div class="row">
          

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon" style="background-color:#454D55"><i class="fas fa-solid fa-coins"></i></span>

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
           <span class="info-box-icon " style="background-color:#454D55"><i class="fas fa-solid fa-coins"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total 1st District Disbursement</span>
                <span class="info-box-number">
                <?php 
                    $individual = $conn->query("SELECT * FROM individual_list where `district_name` = 'District 1' ")->num_rows;
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
             <span class="info-box-icon " style="background-color:#454D55"><i class="fas fa-solid fa-coins"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total 2nd District Disbursement</span>
                <span class="info-box-number">
                <?php 
                    $individual = $conn->query("SELECT * FROM individual_list where `district_name` = 'District 2' ")->num_rows;
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
             <span class="info-box-icon " style="background-color:#454D55"><i class="fas fa-solid fa-coins"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total 3rd District Disbusement</span>
                <span class="info-box-number">
                <?php 
                    $individual = $conn->query("SELECT * FROM individual_list where `district_name` = 'District 3' ")->num_rows;
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
              <span class="info-box-icon " style="background-color:#454D55"><i class="fas fa-solid fa-hourglass-half"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total 4th District Disbursement</span>
                <span class="info-box-number">
                <?php 
                    $individual = $conn->query("SELECT * FROM individual_list where `district_name` = 'District 4' ")->num_rows;
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
              <span class="info-box-icon " style="background-color:#454D55"><i class="fas fa-solid fa-hourglass-half"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total 5th District Disbursement</span>
                <span class="info-box-number">
                <?php 
                    $individual = $conn->query("SELECT * FROM individual_list where `district_name` = 'District 5 - Batangas City' ")->num_rows;
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
              <span class="info-box-icon " style="background-color:#454D55"><i class="fas fa-solid fa-hourglass-half"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total 6th District Disbursement</span>
                <span class="info-box-number">
                <?php 
                    $individual = $conn->query("SELECT * FROM individual_list where `district_name` = 'District 6 - Lipa City' ")->num_rows;
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
              <span class="info-box-icon " style="background-color:#454D55"><i class="fas fa-solid fa-hourglass-half"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Pending Disbursement</span>
                <span class="info-box-number">
                <?php 
                    $individual = $conn->query("SELECT * FROM individual_list where `status` = 0 ")->num_rows;
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
            <span class="info-box-icon " style="background-color:#454D55"><i class="fas fa-solid fa-coins"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total Amount for Disbursement</span>
                <span class="info-box-number">
                <?php            // Execute the query and fetch the result
                $result = $conn->query("SELECT SUM(amount) AS total_amount FROM budget where status = 1");
                $row = $result->fetch_assoc();

                // Format and display the total amount
                echo number_format($row['total_amount']);
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
            <span class="info-box-icon" style="background-color:#454D55"><i class="fas fa-solid fa-coins"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total Remaining Amount</span>
                <span class="info-box-number">
            <?php
            // Execute the query and fetch the result
            $result = $conn->query("SELECT remaining_amount AS total_amount_disbursed FROM budget");
            $row = $result->fetch_assoc();

            // Format and display the total amount disbursed
            echo number_format($row['total_amount_disbursed']);
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
            <span class="info-box-icon" style="background-color:#454D55"><i class="fas fa-solid fa-coins"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total Amount Disbursed</span>
                <span class="info-box-number">
            <?php
            // Execute the query and fetch the result
            $result = $conn->query("SELECT amount-remaining_amount AS total_remaining_amount FROM budget");
            $row = $result->fetch_assoc();

            // Format and display the total remaining amount
            echo number_format($row['total_remaining_amount']);
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
            <span class="info-box-icon" style="background-color:#454D55"><i class="fas fa-solid fa-coins"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total Number of Individual for Disbursement</span>
                <span class="info-box-number">
                <?php
                // Execute the query to count individuals with status = 1
                $result = $conn->query("SELECT count(*) as total_count FROM individual_list WHERE status = 1");
                $row = $result->fetch_assoc();

                // Display the count of records where status = 1
                echo number_format($row['total_count']);
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <?php
    // Loop through Districts 1 to 6
    for ($district = 1; $district <= 4; $district++) {
        // Query for the count of individuals with status = 1 and district_name corresponding to the current district
        $result = $conn->query("SELECT count(*) as total_count FROM individual_list WHERE status = 1 AND district_name = 'District $district'");
        $row = $result->fetch_assoc();
        $total_count = $row['total_count']; // Store the total count for this district
        ?>

        <!-- Info box for the current district -->
        <div class="col-12 col-sm-6 col-md-3">
<!--            <a href="--><?php //echo base_url ?><!--admin/?page=approval&district=--><?php //echo $district; ?><!--" style="text-decoration: none;">-->
            <a href="<?php echo base_url ?>/admin?page=approval&districtId=<?php echo $district; ?>" style="text-decoration: none;">
                <div class="info-box mb-3">
                <span class="info-box-icon" style="background-color:#454D55"><i class="fas fa-solid fa-coins"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Number of Individuals for Disbursement for District <?php echo $district; ?></span>
                    <span class="info-box-number">
                    <?php echo number_format($total_count); ?>
                </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            </a>
            <!-- /.info-box -->
        </div>

        <?php
    }
    ?>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon" style="background-color:#454D55"><i class="fas fa-solid fa-coins"></i></span>
                <a href="<?php echo base_url ?>admin/?page=approval&district=5" style="text-decoration: none;">
                <div class="info-box-content">
                    <span class="info-box-text">Total Number of Individual for Disbursement for District 5</span>
                    <span class="info-box-number">
                    <?php
                    // Execute the query to count individuals with status = 1
                    $result = $conn->query("SELECT count(*) as total_count FROM individual_list WHERE status = 1 and district_name = 'District 5 - Batangas City'");
                    $row = $result->fetch_assoc();

                    // Display the count of records where status = 1
                    echo number_format($row['total_count']);
                    ?>
                </span>
                </div>
                </a>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon" style="background-color:#454D55"><i class="fas fa-solid fa-coins"></i></span>
            <a href="<?php echo base_url ?>admin/?page=approval&district=6" style="text-decoration: none;">
            <div class="info-box-content">
                <span class="info-box-text">Total Number of Individual for Disbursement for District 6</span>
                <span class="info-box-number">
                    <?php
                    // Execute the query to count individuals with status = 1
                    $result = $conn->query("SELECT count(*) as total_count FROM individual_list WHERE status = 1 and district_name = 'District 6 - Lipa City'");
                    $row = $result->fetch_assoc();

                    // Display the count of records where status = 1
                    echo number_format($row['total_count']);
                    ?>
                </span>
            </div>
            </a>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <!-- /.col -->


  </div>
<div class="container">
  
</div>
