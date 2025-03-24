<?php
    include 'connection.php';

    $first_name = $last_name = $department = $salary = "";
    $error_message = "";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $department = trim($_POST['department']);
        $salary = trim($_POST['salary']);
    
        // Validate inputs
        if (empty($first_name) || empty($last_name) || empty($department) || empty($salary)) {
            $error_message = "All fields are required!";
        } elseif (!is_numeric($salary) || $salary < 0) {
            $error_message = "Salary must be a positive number!";
        } else {
            $stmt = $conn->prepare("SELECT id FROM employee WHERE first_name = ? AND last_name = ?");
            $stmt->bind_param("ss", $first_name, $last_name);
            $stmt->execute();
            $stmt->store_result();
        
            if ($stmt->num_rows > 0) {
                $error_message = "Employee already exists!";
            } else {
                // Get the next available ID
                $id_result = $conn->query("SELECT (t1.id + 1) AS next_id FROM employee t1 WHERE NOT EXISTS (SELECT * FROM employee t2 WHERE t2.id = t1.id + 1) ORDER BY t1.id ASC LIMIT 1");
                $row = $id_result->fetch_assoc();
                $new_id = $row['next_id'] ?? 1;
            
                $insert_stmt = $conn->prepare("INSERT INTO employee (id, first_name, last_name, department, salary) VALUES (?, ?, ?, ?, ?)");
                $insert_stmt->bind_param("isssd", $new_id, $first_name, $last_name, $department, $salary);
            
                if ($insert_stmt->execute()) {
                    echo "<script>alert('Employee Added Successfully'); window.location.href = 'index.php';</script>";
                    exit();
                } else {
                    $error_message = "Error: " . $conn->error;
                }
                $insert_stmt->close();
            }
        
            $stmt->close();
        }
        $conn->close();
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
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            <form id="employeeForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="name-row">
                    <div class="form-group">
                        <label for="first_name">First Name <span class="required">*</span></label>
                        <input type="text" id="first_name" name="first_name" placeholder="John" value="<?php echo htmlspecialchars($first_name); ?>" required>
                        <div class="input-highlight"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="last_name">Last Name <span class="required">*</span></label>
                        <input type="text" id="last_name" name="last_name" placeholder="Doe" value="<?php echo htmlspecialchars($last_name); ?>" required>
                        <div class="input-highlight"></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="salary">Salary ($ per year) <span class="required">*</span></label>
                    <input type="number" id="salary" name="salary" placeholder="50000" min="0" step="1000" value="<?php echo htmlspecialchars($salary); ?>" required>
                    <div class="input-highlight"></div>
                </div>
                
                <div class="form-group">
                    <label for="department">Department <span class="required">*</span></label>
                    <input type="text" id="department" name="department" placeholder="Department" value="<?php echo htmlspecialchars($department); ?>" required>
                    <div class="input-highlight"></div>
                </div>
                
                <button type="submit">Submit Information</button>
            </form>
            </div>
        </div>
    </div>
</body>
</html>