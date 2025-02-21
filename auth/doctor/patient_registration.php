<style>
    .card {
        text-align: center;
        flex-direction: column;
        border-radius: 5px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.224);
        background: rgba(209, 239, 253, 0.133);
    }

</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Patient Records</h4>
            <button class="btn btn-primary btn-sm" id="new_patient"><i class="fa fa-plus"></i> New Patient</button>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="card col-lg-12">
            <div class="card-body">
                <table class="table table-striped table-bordered" id="patients-table">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">First Name</th>
                            <th class="text-center">Last Name</th>
                            <th class="text-center">Age</th>
                            <th class="text-center">Contact</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Emergency Contact</th>
                            <th class="text-center">Medical History</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'db_connect.php';
                        $patients = $conn->query("SELECT * FROM patients ORDER BY patient_id ASC");
                        $i = 1;
                        while ($row = $patients->fetch_assoc()):
                        ?>
                        <tr>
                            <td class="text-center"> <?php echo $i++; ?> </td>
                            <td> <?php echo ucwords($row['first_name']); ?> </td>
                            <td> <?php echo ucwords($row['last_name']); ?> </td>
                            <td class="text-center"> <?php echo $row['age']; ?> </td>
                            <td> <?php echo $row['contact']; ?> </td>
                            <td> <?php echo $row['email']; ?> </td>
                            <td> <?php echo $row['address']; ?> </td>
                            <td> <?php echo $row['emergency_contact']; ?> </td>
                            <td> <?php echo substr($row['medical_history'], 0, 50) . '...'; ?> </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-sm edit_patient" data-id="<?php echo $row['patient_id']; ?>">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm delete_patient" data-id="<?php echo $row['patient_id']; ?>">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#patients-table').DataTable({
            pageLength: 15, // Number of entries to display by default
            lengthMenu: [5, 10, 15, 25, 50] // Options for the number of entries to display
        });
    });

    $('#new_patient').click(function() {
        uni_modal('New Patient', 'manage_patient.php');
    });

    $('.edit_patient').click(function() {
        uni_modal('Edit Patient', 'manage_patient.php?id=' + $(this).attr('data-id'));
    });

    $('.delete_patient').click(function() {
        const patientId = $(this).attr('data-id');
        _conf("Are you sure you want to delete this patient?", delete_patient, [patientId]);
    });

    function _conf(message, callback, params) {
        if (confirm(message)) {
            if (typeof callback === 'function') {
                callback.apply(this, params);
            }
        }
    }

    function delete_patient(id) {
        showLoading();
        $.ajax({
            url: '../ajax/ajax.php?action=delete_patient',
            method: 'POST',
            data: { id: id },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Patient successfully deleted", 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    alert_toast("Error deleting patient", 'danger');
                    hideLoading();
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert_toast("Server Error: Could not delete patient", 'danger');
                hideLoading();
            }
        });
    }


</script>

