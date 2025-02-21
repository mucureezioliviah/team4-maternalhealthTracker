<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../db.php';

$meta = [];
if (isset($_GET['id'])) {
    $patient = $conn->query("SELECT * FROM patients WHERE patient_id =" . $_GET['id']);
    foreach ($patient->fetch_array() as $k => $v) {
        $meta[$k] = $v;
    }
}
?>

<div class="container-fluid">
    <div id="msg"></div>
    <form action="" id="manage-patient">
        <input type="hidden" name="id" value="<?php echo isset($meta['patient_id']) ? $meta['patient_id'] : ''; ?>">

        <div class="row">
            <div class="form-group col-md-6">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo isset($meta['first_name']) ? $meta['first_name'] : ''; ?>" required>
            </div>
            <div class="form-group col-md-6">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo isset($meta['last_name']) ? $meta['last_name'] : ''; ?>" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="age">Age</label>
                <input type="number" name="age" id="age" class="form-control" value="<?php echo isset($meta['age']) ? $meta['age'] : ''; ?>">
            </div>
            <div class="form-group col-md-4">
                <label for="patient_contact">Contact</label>
                <input type="text" name="patient_contact" id="patient_contact" class="form-control" value="<?php echo isset($meta['patient_contact']) ? $meta['patient_contact'] : ''; ?>">
            </div>
            <div class="form-group col-md-4">
                <label for="patient_email">Email</label>
                <input type="email" name="patient_email" id="patient_email" class="form-control" value="<?php echo isset($meta['patient_email']) ? $meta['patient_email'] : ''; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" class="form-control" value="<?php echo isset($meta['address']) ? $meta['address'] : ''; ?>">
        </div>

        <div class="form-group">
            <label for="emergency_contact">Emergency Contact</label>
            <input type="text" name="emergency_contact" id="emergency_contact" class="form-control" value="<?php echo isset($meta['emergency_contact']) ? $meta['emergency_contact'] : ''; ?>">
        </div>

        <div class="form-group">
            <label for="medical_history">Medical History</label>
            <textarea name="medical_history" id="medical_history" class="form-control" rows="4"><?php echo isset($meta['medical_history']) ? $meta['medical_history'] : ''; ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Patient</button>
    </form>
</div>

<script>
    $('#manage-patient').submit(function(e) {
        e.preventDefault();
        showLoading();
        $.ajax({
            url: '../ajax/ajax.php?action=save_patient',
            method: 'POST',
            data: $(this).serialize(),
            success: function(resp) {
                hideLoading();
                if (resp == 1) {
                    alert_toast("Patient data successfully saved", 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    $('#msg').html('<div class="alert alert-danger">Error saving Patient</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                hideLoading();
                alert_toast("Server Error: Could not save patient", 'danger');
            }
        });
    });



</script>
