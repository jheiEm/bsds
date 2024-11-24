<style>
  .layout-navbar-fixed .wrapper .main-header
{
  background-color:#8B0000 !important;
}
</style>
<!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-no-expand" style="background-color:#8B0000;">
        <!-- Brand Logo -->
        <a href="<?php echo base_url ?>admin" class="brand-link bg-primary text-sm" style="background-color:#8B0000 !important;">
        <img src="<?php echo validate_image($_settings->info('logo'))?>" alt="Store Logo" class="brand-image img-circle elevation-3" style="opacity: .8;width: 2.5rem;height: 2.5rem;max-height: unset">
        <span class="brand-text font-weight-light"><?php echo $_settings->info('short_name') ?></span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
          <div class="os-resize-observer-host observed">
            <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
          </div>
          <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
            <div class="os-resize-observer"></div>
          </div>
          <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 646px;"></div>
          <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
              <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                <!-- Sidebar user panel (optional) -->
                <div class="clearfix"></div>
                <!-- Sidebar Menu -->
                <nav class="mt-4">
                   <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item dropdown">
                      <a href="./" class="nav-link nav-home">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                          Dashboard
                        </p>
                      </a>
                    </li> 
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=history" class="nav-link nav-history">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>
                        Disbursement History
                        </p>
                      </a>
                    </li>
<!--  			<li class="nav-item dropdown">-->
<!--                      <a href="--><?php //echo base_url ?><!--admin/?page=student/student" class="nav-link nav-patient_patient">-->
<!--                        <i class="nav-icon fas fa-solid fa-user"></i>-->
<!--                        <p>-->
<!--                        Students List-->
<!--                        </p>-->
<!--                      </a>-->
<!--                    </li>-->
                       <li class="nav-item dropdown">
                           <a href="<?php echo base_url ?>admin/?page=approval" class="nav-link nav-student_approval">
                               <i class="nav-icon fas fa-user-check"></i>
                               <p>
                                   Application List
                               </p>
                           </a>
                       </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=individual" class="nav-link nav-individual">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                        Individuals List
                        </p>
                      </a>
                    </li>
                       <li class="nav-item dropdown">
                           <a href="<?php echo base_url ?>admin/?page=disbursement_schedule" class="nav-link nav-res">
                               <i class="nav-icon fas fa-calendar"></i>
                               <p>
                                   Schedule Disbursement
                               </p>
                           </a>
                       </li>
			  <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=schedule" class="nav-link nav-schedule">
                        <i class="nav-icon fas fa-calendar"></i>
                        <p>
                        Disbursement Schedules
                        </p>
                      </a>
                    </li>
                       <li class="nav-item dropdown">
                           <a href="<?php echo base_url ?>admin/?page=reschedule" class="nav-link nav-reschedule">
                               <i class="nav-icon fas fa-table"></i>
                               <p>
                                   Reschedule Requests
                               </p>
                           </a>
                       </li>
                       <li class="nav-item dropdown">
                           <a href="<?php echo base_url ?>admin/?page=archives" class="nav-link nav-archives">
                               <i class="nav-icon fas fa-user-cog"></i>
                               <p>
                                   Archive Applications
                               </p>
                           </a>
                       </li>
		
			
			
		
                    <?php if($_settings->userdata('type') == 1): ?>
			<li class="nav-header">Reports</li>
<!--    			<li class="nav-item dropdown">-->
<!--                      <a href="--><?php //echo base_url ?><!--admin/?page=reports/daily_student_report" class="nav-link nav-reports_daily_student_report">-->
<!--                        <i class="nav-icon fas fa-folder-open"></i>-->
<!--                        <p>-->
<!--                         Daily Students Report-->
<!--                        </p>-->
<!--                      </a>-->
<!--                    </li>-->
<!--                    <li class="nav-item dropdown">-->
<!--                      <a href="--><?php //echo base_url ?><!--admin/?page=reports/student_report" class="nav-link nav-reports_student_report ">-->
<!--                        <i class="nav-icon fas fa-folder-open"></i>-->
<!--                        <p>-->
<!--                          Students List Report -->
<!--                        </p>-->
<!--                      </a>-->
<!--                    </li>-->
			   <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=reports/daily_disbursement_report" class="nav-link  nav-reports_daily_disbursement_report">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>
                          Daily Disbursement Report
                        </p>
                      </a>
                    </li>
		     <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=reports/disbursement_report" class="nav-link nav-reports_disbursement_report ">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>
                          Disbusement Report 
                        </p>
                      </a>
                    </li>
                    <li class="nav-header">Maintenance</li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=maintenance/scheme" class="nav-link nav-maintenance_scheme">
                        <i class="nav-icon fas fa-prescription-bottle-alt"></i>
                        <p>
                          Scholarship Grant List
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=maintenance/location" class="nav-link nav-maintenance_location">
                        <i class="nav-icon fas fa-map-marked-alt"></i>
                        <p>
                          Disbursement Area List
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=user/list" class="nav-link nav-user_list">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                          User List
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=budget/list" class="nav-link nav-budget_list">
                        <i class="nav-icon fas fa-solid fa-coins"></i>
                        <p>
                          Budget
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=system_info" class="nav-link nav-system_info">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                          Settings
                        </p>
                      </a>
                    </li>
                    <?php endif; ?>

                  </ul>
                </nav>
                <!-- /.sidebar-menu -->
              </div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
              <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
              <div class="os-scrollbar-handle" style="height: 55.017%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar-corner"></div>
        </div>
        <!-- /.sidebar -->
      </aside>
      <script>
        var page;
    $(document).ready(function(){
      page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
      page = page.replace(/\//gi,'_');

      if($('.nav-link.nav-'+page).length > 0){
             $('.nav-link.nav-'+page).addClass('active')
        if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
          $('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
        }
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

      }
     
    })
  </script>