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
    <title>Employee Record</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Employee List</h1>
            <button class="add-btn" onclick="window.location.href='add_employee.php'">Add Employee</button>
        </div>
        
        <div class="card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Department</th>
                            <th>Salary</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['first_name']; ?></td>
                        <td><?= $row['last_name']; ?></td>
                        <td><?= $row['department']; ?></td>
                        <td><?= $row['salary']; ?></td>
                        <td class="action">
                            <a href="edit_employee.php?id=<?= $row['id']; ?>" class="edit-btn" onclick="return confirm('Are you sure?')">Edit</a>
                            <!-- <a href="delete_employee.php?id=//</?= $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a> -->
                            <form class="porm" method="POST" action="delete_employee.php" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                <button class="delt" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>