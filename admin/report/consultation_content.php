<?php
// Include your database configuration file
include_once ('../../config.php');

$sql = "SELECT COUNT(*) AS totalConsultations
        FROM consultations
        LEFT JOIN users ON consultations.doctor_id = users.id
        LEFT JOIN fp_physical_examination ON fp_physical_examination.consultation_id = consultations.id
        LEFT JOIN fp_medical_history ON fp_medical_history.consultation_id = consultations.id
        WHERE consultations.id = ?";


$sqls = "SELECT COUNT(*) AS Consults
        FROM consultations
        JOIN fp_medical_history ON fp_medical_history.consultation_id = consultations.id";


$result = $conn->query($sqls);

if ($result === false) {
    die("Query failed: " . $conn->error);
}



?>
<style>
    .tago {
        display: none;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card-body table-responsive p-0" style="z-index: -99999">
            <table id="tablebod" class="table table-head-fixed text-nowrap table-striped">
                <thead class="thead-light">
                    <tr>
                        <th class="tago">No.</th>
                        <th>Severe Headaches</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>

                                <td class="align-middle">
                                    <?php echo $row['Consults']; ?>
                                </td>

                                <td class="align-middle">
                                    <button type="button" class="btn btn-info editbtn"
                                        data-row-id="<?php echo $row['Consults']; ?>">
                                        <i class="fas fa-edit"></i> View History Consultation
                                    </button>
                                </td>

                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td class="align-middle"></td>
                            <td class="align-middle">No Consultation Found</td>
                            <td class="align-middle">
                            <td>


                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    .tago {
        display: none;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card-body table-responsive p-0" style="z-index: -99999">
            <table id="patientTableBody" class="table table-head-fixed text-nowrap table-striped">
                <thead class="thead-light">
                    <tr>
                        <th class="tago">ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td class="align-middle tago">
                                    <?php echo $row['id']; ?>
                                </td>
                                <td class="align-middle">
                                    <?php echo $row['title']; ?>
                                </td>
                                <td class="align-middle">
                                    <?php echo $row['description']; ?>
                                </td>
                                <td class="align-middle">
                                    <?php echo $row['date']; ?>
                                </td>
                                <td class="align-middle">
                                    <?php echo $row['time']; ?>
                                </td>
                                <td class="align-middle">
                                    <button type="button" class="btn btn-success editbtn"
                                        data-patient-id="<?php echo $row['id']; ?>">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i
                                            class="fas fa-trash"></i> Delete</button>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td class="align-middle"></td>
                            <td class="align-middle">No Announcement Found</td>
                            <td class="align-middle"></td>
                            <td class="align-middle"></td>
                            <td class="align-middle"></td>
                            <td class="align-middle"></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $(document).ready(function () {




        <?php if ($result->num_rows > 0): ?>
            var table = $('#tablebod').DataTable({
                columnDefs: [
                    { targets: 0, data: 'id', visible: false },
                    { targets: 1, data: 'Consults' },
                    {
                        targets: 2,
                        searchable: false,
                        data: null,
                        render: function (data, type, row) {
                            var editButton = '<button type="button" class="btn btn-info editbtn" data-row-id="' + row.id + '"><i class="fas fa-edit"></i>View History Consultation</button>';
                            var deleteButton = ' <button type="button" class="btn btn-primary deletebtn" data-id="' + row.id + '"><i class="fas fa-check"></i> Set as Active</button>';
                            return editButton;
                        }
                    } // Action column
                ],
                // Set the default ordering to 'id' column in descending order
                order: [[0, 'desc']]
            });
        <?php else: ?>
            // Initialize DataTable without the "Action" column when no rows are found
            var table = $('#tablebod').DataTable({
                columnDefs: [
                    { targets: 0, data: 'id', visible: false },
                    { targets: 1, data: 'Consults' },
                ],
                // Set the default ordering to 'id' column in descending order
                order: [[0, 'desc']]
            });
        <?php endif; ?>

        $('#addButton').click(function () {

            console.log(patient_id);
            table.destroy(); // Destroy the existing DataTable
            table = $('#tablebod').DataTable({
                columnDefs: [
                    { targets: 0, data: 'id', visible: false },
                    { targets: 1, data: 'Consults' },
                    {
                        targets: 2,
                        searchable: false,
                        data: null,
                        render: function (data, type, row) {
                            var editButton = '<button type="button" class="btn btn-info editbtn" data-row-id="' + row.id + '"><i class="fas fa-edit"></i>View History Consultation</button>';
                            var deleteButton = ' <button type="button" class="btn btn-primary deletebtn" data-id="' + row.id + '"><i class="fas fa-check"></i> Set as Active</button>';
                            return editButton;
                        }
                    } // Action column
                ],
                // Set the default ordering to 'id' column in descending order
                order: [[0, 'desc']]
            });

            // Get data from the form

            var patient_id = $('#serial_no2').val();
            var description = $('#description').val();
            var checkup_date = $('#checkup_date').val();
            var doctor_id = $('#doctor_id').val();

            console.log(patient_id);

            // AJAX request to send data to the server
            $.ajax({
                url: 'action/add_consultation.php',
                method: 'POST',
                data: {
                    patient_id: patient_id,
                    description: description,
                    doctor_id: doctor_id,
                    checkup_date: checkup_date,
                },
                success: function (response) {

                    if (response.trim() === 'Success') {


                        // Clear the form fields
                        $('#patient_id').val('');
                        $('#description').val('');
                        $('#doctor_id').val('');
                        $('#checkup_date').val('');

                        updateData();
                        $('#addModal').modal('hide');

                        // Remove the modal backdrop manually
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        // Show a success SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Consultation added successfully',
                        });

                    } else {
                        // Show an error SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error adding data: ' + response,
                        });
                    }
                },
                error: function (error) {
                    // Handle errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error adding data: ' + error,
                    });
                },

            });
        });


        function updateData() {
            $.ajax({
                url: 'action/get_active.php',
                method: 'GET',
                success: function (data) {
                    // Assuming the server returns JSON data, parse it
                    var get_data = JSON.parse(data);

                    // Clear the DataTable and redraw with new data
                    table.clear().rows.add(get_data).draw();
                },
                error: function (error) {
                    // Handle errors
                    console.error('Error retrieving data: ' + error);
                }
            });
        }

        // Delete button click event
        $('#tablebod').on('click', '.deletebtn', function () {
            var deletedataId = $(this).data('id');

            // Confirm the deletion with a SweetAlert dialog
            Swal.fire({
                title: 'Confirm Activation',
                text: 'Are you sure you want to active this data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, set it as active'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'action/active.php',
                        method: 'POST',
                        data: { primary_id: deletedataId },
                        success: function (response) {
                            if (response === 'Success') {

                                updateData();
                                Swal.fire('Activated', 'The Consultation has been activated.', 'success');
                            } else {
                                Swal.fire('Error', 'Error deleting data: ' + response, 'error');
                            }
                        },
                        error: function (error) {
                            Swal.fire('Error', 'Error deleting data: ' + error, 'error');
                        }
                    });
                }
            });
        });

        // Edit button click event
        $('#tablebod').on('click', '.editbtn', function () {
            var editId = $(this).data('row-id');
            console.log(editId);
            $.ajax({
                url: 'action/get_consultation_by_id.php', // 
                method: 'POST',
                data: { primary_id: editId },
                success: function (data) {

                    var editGetData = data;


                    $('#editModal #editdataId').val(editGetData.id);
                    $('#editModal #editPatient_id').val(editGetData.patient_id);
                    $('#editModal #editDiagnosis').val(editGetData.diagnosis);
                    $('#editModal #editMedicine').val(editGetData.medicine);

                    $('#editModal').modal('show');
                },
                error: function (error) {
                    console.error('Error fetching  data: ' + error);
                },
            });
        });


        // Edit button click event
        $('#tablebod').on('click', '.editbtn', function () {
            var editId = $(this).data('row-id');
            console.log(editId);
            $.ajax({
                url: 'action/get_consultation_by_id.php', // 
                method: 'POST',
                data: { primary_id: editId },
                success: function (data) {

                    var editGetData = data;


                    $('#editModal #editdataId').val(editGetData.id);
                    $('#editModal #editSubjective').val(editGetData.subjective);
                    $('#editModal #editDiagnosis').val(editGetData.diagnosis);
                    $('#editModal #').val(editGetData.medicine);
                    $('#editModal #editDoctor').val(editGetData.doctor_id);

                    $('#editModal').modal('show');
                },
                error: function (error) {
                    console.error('Error fetching  data: ' + error);
                },
            });
        });

        $('#updateButton').click(function () {


            var editId = $('#editdataId').val();
            var subjective = $('#editSubjective').val();
            var diagnosis = $('#editDiagnosis').val();
            var medicine = $('#editPrescription').val();
            var doctor_id = $('#editDoctor').val();

            $.ajax({
                url: 'action/update_consultation.php',
                method: 'POST',
                data: {
                    primary_id: editId,
                    subjective: subjective,
                    diagnosis: diagnosis,
                    medicine: medicine,
                    doctor_id: doctor_id,

                },
                success: function (response) {
                    // Handle the response
                    if (response === 'Success') {
                        updateData();
                        $('#editModal').modal('hide');
                        // Remove the modal backdrop manually
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        // Show a success Swal notification
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Consultation updated successfully',
                        });
                    } else {
                        // Show an error Swal notification
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error updating data: ' + response,
                        });
                    }
                },
                error: function (error) {
                    // Show an error Swal notification for AJAX errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error updating data: ' + error,
                    });
                }
            });
        });



    });


</script>
<script>
    // Set the timeout duration (in milliseconds)
    var inactivityTimeout = 360000; // 10 seconds

    // Track user activity
    var activityTimer;

    function resetTimer() {
        clearTimeout(activityTimer);
        activityTimer = setTimeout(logout, inactivityTimeout);
    }

    function logout() {
        // Redirect to logout PHP script
        window.location.href = '../action/logout.php';
    }

    // Add event listeners to reset the timer on user activity
    document.addEventListener('mousemove', resetTimer);
    document.addEventListener('keypress', resetTimer);

    // Initialize the timer on page load
    resetTimer();
</script>