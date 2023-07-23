<!DOCTYPE html>
<html>
<head>
    <title>Add Person</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <!-- Button to open the modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPersonModal">
        Add Person
    </button>

    <!-- Modal -->
    <div class="modal fade" id="addPersonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Person</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="personForm">
                    	<div class="form-group-inline">
                        <label for="person_name">Name:</label>
                        <input type="text" id="person_name" name="person_name" required>
                        </div>
                        <div class="form-group-inline">
                        <label for="person_fname">Father's Name:</label>
                        <input type="text" id="person_fname" name="person_fname" required>
                        </div>
                        <div class="form-group-inline">
                        <label for="person_fath_name">Grandfather's Name:</label>
                        <input type="text" id="person_fath_name" name="person_fath_name" required>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addPersonBtn">Add Person</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Function to add a person using AJAX
            function addPerson() {
                var formData = $('#personForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: 'add_person.php',
                    data: formData,
                    success: function(response) {
                        alert(response);
                        // Optionally, you can clear the form fields after successful submission.
                        $('#person_name').val('');
                        $('#person_fname').val('');
                        $('#person_fath_name').val('');
                        // Close the modal after successful submission
                        $('#addPersonModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + xhr.status + ' ' + error);
                    }
                });
            }

            // Bind the click event to the "Add Person" button in the modal
            $('#addPersonBtn').click(function() {
                addPerson();
            });
        });
    </script>

    <?php
    // Assuming you have already connected to the database.
    // Replace 'your_database_credentials' with your actual database credentials.

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $person_name = $_POST['person_name'];
        $person_fname = $_POST['person_fname'];
        $person_fath_name = $_POST['person_fath_name'];

        // Insert data into the database.
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=new_solar_tech_solution', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare('INSERT INTO person (person_name, person_fname, person_fath_name) VALUES (:name, :fname, :fath_name)');
            $stmt->bindParam(':name', $person_name);
            $stmt->bindParam(':fname', $person_fname);
            $stmt->bindParam(':fath_name', $person_fath_name);
            $stmt->execute();

            echo 'Person added successfully!';
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    ?>
</body>
</html>
