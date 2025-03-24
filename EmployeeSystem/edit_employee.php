<?php
    include 'connection.php';

    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM employee WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee = $result->fetch_assoc();
    $stmt->close();

    $error_message = "";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = trim($_POST['firstName']);
        $last_name = trim($_POST['lastName']);
        $department = $_POST['department'];
        $salary = $_POST['salary'];

        $stmt = $conn->prepare("SELECT id FROM employee WHERE first_name = ? AND last_name = ? AND id != ?");
        $stmt->bind_param("ssi", $first_name, $last_name, $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_message = "The combination of First name and Last name is already in use. Please select a different one!";
        } else {
            $stmt->close();

            $stmt = $conn->prepare("UPDATE employee SET first_name = ?, last_name = ?, department = ?, salary = ? WHERE id = ?");
            $stmt->bind_param("sssdi", $first_name, $last_name, $department, $salary, $id);
            if ($stmt->execute()) {
                echo "<script>alert('Employee updated successfully!'); window.location.href = 'index.php';</script>";
                exit;
            } else {
                $error_message = "Error updating employee: " . $conn->error;
            }
        }
        $stmt->close();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Employee</title>
    <link rel="stylesheet" href="./index.css">
   
</head>
<body onload="showError('<?php echo $error_message; ?>')">
    <div class="main-container">
        <div class="form-container">
            <h2>Edit Employee Information</h2>
            <form id="employeeForm" method="POST">
                <div class="name-row">
                    <div class="form-group">
                        <label for="firstName">First Name <span class="required">*</span></label>
                        <input type="text" id="firstName" name="firstName" value="<?= htmlspecialchars($first_name ?? $employee['first_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name <span class="required">*</span></label>
                        <input type="text" id="lastName" name="lastName" value="<?= htmlspecialchars($last_name ?? $employee['last_name']); ?>" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="salary">Salary ($ per year) <span class="required">*</span></label>
                    <input type="number" id="salary" name="salary" value="<?= htmlspecialchars($salary ?? $employee['salary']); ?>" min="0" step="1000" required>
                </div>
                
                <div class="form-group">
                    <label for="department">Department <span class="required">*</span></label>
                    <input type="text" id="department" name="department" value="<?= htmlspecialchars($department ?? $employee['department']); ?>" min="0" step="1000" required>
                </div>
                
                <div class="button-group">
                    <a href="index.php" class="back-button">Cancel</a>
                    <button type="submit">Update Employee</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showError(message) {
            if (message) {
                alert(message);
            }
        }
    </script>

</body>
</html>