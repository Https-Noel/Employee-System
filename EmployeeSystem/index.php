<?php

    include "connection.php";

    $sql = "SELECT * FROM employee";
    $result = mysqli_query($conn, $sql);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .btn {
            padding: 8px 16px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }
        
        .btn:hover {
            background: #45a049;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        .action-btn {
            padding: 5px 10px;
            margin-right: 5px;
            border-radius: 3px;
            text-decoration: none;
            font-size: 13px;
        }
        
        .edit-btn {
            background: #2196F3;
            color: white;
        }
        
        .delete-btn {
            background: #f44336;
            color: white;
        }
        
        .no-employees {
            text-align: center;
            padding: 40px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Employee List</h1>
            <a href="add_employee.php" class="btn">Add New Employee</a>
        </div>
        
        <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Salary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['department']); ?></td>
                    <td>$<?php echo number_format($row['salary'], 2); ?></td>
                    <td>
                        <a href="edit_employee.php?id=<?php echo $row['id']; ?>" class="action-btn edit-btn">Edit</a>
                        <a href="delete_employee.php?id=<?php echo $row['id']; ?>" 
                           class="action-btn delete-btn" 
                           onclick="return confirm('Are you sure you want to delete this employee?')">
                            Delete
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="no-employees">
            <p>No employees found. Would you like to <a href="add_employee.php">add one</a>?</p>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Close connection
mysqli_close($conn);
?>