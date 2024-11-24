<style>
    .img-thumb-path{
        width:100px;
        height:80px;
        object-fit:scale-down;
        object-position:center center;
    }
</style>
<?php 
$date = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d",strtotime(date("Y-m-d"))); 
?>
<div class="card card-outline card-blue rounded-0 shadow">
	<div class="card-header">
		<h3 class="card-title">Daily Students Report</h3>
		<!-- <div class="card-tools">
			<button class="btn btn-sm btn-flat btn-success" id="print"><i class="fa fa-print"></i> Print</button>
		</div> -->
	</div>
	<div class="card-body">
		<div class="callout border-primary">
			<fieldset>
				<legend>Filter</legend>
					<form action="" id="filter">
						<div class="row align-items-end">
                            <div class="form-group col-md-3">
								<label for="date" class="control-label">Date</label>
                                <input type="date" name="date" id="date" value="<?= $date ?>" class="form-control form-control-sm rounded-0">
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
					<h3 class="text-center"><b>Daily Students Report</b></h3>
					<h5 class="text-center"><b><?= date("F d, Y", strtotime($date)) ?></b></h5>
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
						<th>Firstname</th>
						<th>Lastname</th>
						<th>Middle Name</th>
						<th>Age</th>
						<th>Birthday</th>
                        <th>Contact No.</th>
                        <th>Address</th>
                        <th>Remarks</th>
                        <th>Status</th>
                        <th>Assigned District</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT * from `student_list` where date(date_created) = '{$date}' order by unix_timestamp(date_created) asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class=""><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td class=""><p class="m-0"><?php echo $row['firstname'] ?></p></td>
							<td class=""><p class="m-0"><?php echo $row['lastname'] ?></p></td>
							<td class=""><p class="m-0"><?php echo $row['middlename'] ?></p></td>
							
							<td class=""><p class="m-0"><?php echo $row['age'] ?></p></td>
							<td class=""><p class="m-0"><?php echo $row['dob'] ?></p></td>
							<td class=""><p class="m-0"><?php echo $row['contact'] ?></p></td>
							<td class=""><p class="m-0"><?php echo $row['address'] ?></p></td>
							<td class=""><p class="m-0"><?php echo $row['remarks'] ?></p></td>
							<td class=""><p class="m-0"><?php echo $row['status'] ?></p></td>
                            <td class=""><p class="m-0"><?php echo $row['location_id'] ?></p></td>
						</tr>
					<?php endwhile; ?>
					<?php if($qry->num_rows <= 0): ?>
						<tr>
							<th class="py-1 text-center" colspan="6">No Student Report Found.</th>
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
		$('#filter').submit(function(e){
            e.preventDefault();
            location.href= './?page=reports/daily_student_report&'+$(this).serialize();
        })
       $('#print').click(function(){
		   start_loader()
		   var _p = $('#outprint').clone()
		   var _h = $('head').clone()
		   var _el = $('<div>')
		   _h.find("title").text("Daily Transaction Report - Print View")
		   _p.find('tr.text-light').removeClass('text-light bg-gradient-purple')
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