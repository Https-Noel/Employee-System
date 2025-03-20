<?php
    include 'connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $department = $_POST['department'];
        $salary = $_POST['salary'];

        $check = $conn->query("SELECT * FROM employee WHERE first_name='$first_name' AND last_name='$last_name' AND department='$department'");
        if ($check->num_rows > 0) {
            echo "<p style='color: red;'>Employee already exists!</p>";
        } else {
            $conn->query("INSERT INTO employee (first_name, last_name, department, salary) VALUES ('$first_name', '$last_name', '$department', '$salary')");
            header("Location: index.php");
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Record</title>
    <link rel="stylesheet" href="add.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Add Employee</h2>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="department">Department</label>
                        <input type="text" name="department" id="department" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="salary">Salary</label>
                        <input type="number" name="salary" id="salary" required>
                    </div>
                    
                    <div class="buttons">
                        <input type="submit" name="submit" value="Submit">
                        <button type="button" onclick="window.location.href='index.php'">Back</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>