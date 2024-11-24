<?php
//include('db.php');

// Fetch all individuals (Initially, no filter)
$sql = "SELECT * FROM individual_list";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Application</h3>
        <div class="card-tools">
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <!-- Search Form -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" id="search" class="form-control" placeholder="Search by name, contact or tracking code">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary" id="filterBtn">Apply Filters</button>
                    </div>
                </div>

                <!-- Filters -->
                <div class="row mb-3" id="filters">
                    <!-- Scheme Filter -->
                    <div class="col-md-3">
                        <select id="schemeFilter" class="form-select">
                            <option value="">Select Scheme</option>
                            <?php
                            $schemeResult = $conn->query("SELECT * FROM scheme_list WHERE status = 1");
                            while ($scheme = $schemeResult->fetch_assoc()) {
                                echo "<option value='{$scheme['id']}'>{$scheme['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- District Filter -->
                    <div class="col-md-3">
                        <select id="districtFilter" class="form-select">
                            <option value="">Select District</option>
                            <?php
                            $districtResult = $conn->query("SELECT * FROM scholar_location_list WHERE status = 1");
                            while ($district = $districtResult->fetch_assoc()) {
                                echo "<option value='{$district['id']}'>{$district['location']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- School Level Filter -->
                    <div class="col-md-3">
                        <select id="schoolLevelFilter" class="form-select">
                            <option value="">Select School Level</option>
                            <option value="Junior High School">Junior High School</option>
                            <option value="Senior High School">Senior High School</option>
                            <option value="Tertiary">Tertiary</option>
                            <option value="Graduate School">Graduate School</option>
                            <option value="Vocational">Vocational</option>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="col-md-3">
                        <select id="statusFilter" class="form-select">
                            <option value="">Select Status</option>
                            <option value="0">Pending</option>
                            <option value="1">Partially Disbursed</option>
                            <option value="2">Fully Disbursed</option>
                        </select>
                    </div>
                </div>

                <!-- Table of Individuals -->
                <table class="table table-bordered" id="individualTable">
                    <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>ID</th>
                        <th>Tracking Code</th>
                        <th>Name</th>
                        <th>District</th>
                        <th>School Level</th>
                        <th>Status</th>
                        <th>Date Created</th>
                        <th>Enrollment Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><input type="checkbox" class="individualCheck" data-id="<?= $row['id'] ?>"></td>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['tracking_code'] ?></td>
                            <td><?= $row['firstname'] ?> <?= $row['lastname'] ?></td>
                            <td><?= $row['district_name'] ?></td>
                            <td><?= $row['school_level'] ?></td>
                            <td><?= $row['status'] == 1 ? 'Partially Disbursed' : ($row['status'] == 2 ? 'Fully Disbursed' : 'Pending') ?></td>
                            <td><?= date("Y-m-d H:i:s", strtotime($row['date_created'])) ?></td> <!-- Display date_created -->
                            <td><?= $row['enrollment_date'] ? date("Y-m-d", strtotime($row['enrollment_date'])) : 'Not Available' ?></td> <!-- Display enrollment_date -->
                            <td>
                                <button class="btn btn-warning btn-sm editBtn" data-id="<?= $row['id'] ?>">Edit</button>
                                <button class="btn btn-danger btn-sm deleteBtn" data-id="<?= $row['id'] ?>">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
                <!-- Edit Modal -->
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Individual</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm">
                                    <input type="hidden" id="editId" name="id">
                                    <div class="mb-3">
                                        <label for="editName" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="editName" name="name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editTrackingCode" class="form-label">Tracking Code</label>
                                        <input type="text" class="form-control" id="editTrackingCode" name="tracking_code">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editStatus" class="form-label">Status</label>
                                        <select class="form-select" id="editStatus" name="status">
                                            <option value="0">Pending</option>
                                            <option value="1">Partially Disbursed</option>
                                            <option value="2">Fully Disbursed</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mass Update Button -->
        <button id="massUpdateBtn" class="btn btn-success">Mass Update</button>


    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Select All Checkboxes
    $('#selectAll').on('click', function() {
        $('.individualCheck').prop('checked', this.checked);
    });

    // Handle Filter Button Click
    $('#filterBtn').on('click', function() {
        var schemeId = $('#schemeFilter').val();
        var districtId = $('#districtFilter').val();
        var schoolLevel = $('#schoolLevelFilter').val();
        var status = $('#statusFilter').val();

        $.ajax({
            //url: 'filter.php', // We'll create this file next
            url: _base_url_+"classes/approval/filter"
            type: 'GET',
            data: {
                schemeId: schemeId,
                districtId: districtId,
                schoolLevel: schoolLevel,
                status: status
            },
            success: function(data) {
                $('#individualTable tbody').html(data);
            }
        });
    });

    // Handle Search by Name, Contact, or Tracking Code
    $('#search').on('keyup', function() {
        var searchTerm = $(this).val();

        $.ajax({
            //url: 'search.php', // We'll create this file next
            url: _base_url_+"classes/approval/search"
            type: 'GET',
            data: { search: searchTerm },
            success: function(data) {
                $('#individualTable tbody').html(data);
            }
        });
    });
    // Open Edit Modal and populate form
    $('.editBtn').on('click', function() {
        var individualId = $(this).data('id');

        // Fetch individual data via AJAX
        $.ajax({
            //url: 'fetch_individual.php', // This file will fetch the individual data
            url: _base_url_+"classes/approval/fetch_individual"
            type: 'GET',
            data: { id: individualId },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    $('#editId').val(data.individual.id);
                    $('#editName').val(data.individual.firstname + ' ' + data.individual.lastname);
                    $('#editTrackingCode').val(data.individual.tracking_code);
                    $('#editStatus').val(data.individual.status);
                    $('#editModal').modal('show');
                } else {
                    alert('Error fetching individual data');
                }
            }
        });
    });

    // Handle form submission (Edit Individual)
    $('#editForm').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            //url: 'edit_individual.php', // This file will update the individual
            url: _base_url_+"classes/approval/edit_individual"
            type: 'POST',
            data: formData,
            success: function(response) {
                alert(response);
                $('#editModal').modal('hide');
                location.reload(); // Reload page to reflect changes
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Error updating individual');
            }
        });
    });
    $('.deleteBtn').on('click', function() {
        var individualId = $(this).data('id');

        // Confirm before delete
        if (confirm('Are you sure you want to delete this individual?')) {
            $.ajax({
                //url: 'delete_individual.php', // File for deleting individual
                url: _base_url_+"classes/approval/delete_individual"
                type: 'POST',
                data: { id: individualId },
                success: function(response) {
                    alert(response);
                    location.reload(); // Reload page after deletion
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Error deleting individual');
                }
            });
        }
    });
    $('#massUpdateBtn').on('click', function() {
        // Collect selected individual IDs
        var selectedIds = [];
        $('.individualCheck:checked').each(function() {
            selectedIds.push($(this).data('id'));
        });

        // Ensure at least one record is selected
        if (selectedIds.length === 0) {
            alert('Please select at least one individual');
            return;
        }

        // Prompt for new status
        var newStatus = prompt("Enter new status (0: Pending, 1: Partially Disbursed, 2: Fully Disbursed):");

        // Validate input
        if (newStatus !== '0' && newStatus !== '1' && newStatus !== '2') {
            alert('Invalid status value');
            return;
        }

        // Send AJAX request to update the selected records
        $.ajax({
            //url: 'mass_update.php', // We'll create this file next
            url: _base_url_+"classes/approval/mass_update"
            type: 'POST',
            data: { ids: selectedIds, status: newStatus },
            success: function(response) {
                alert(response);
                location.reload(); // Reload page to reflect the changes
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('An error occurred during the mass update');
            }
        });
    });

</script>

</html>
