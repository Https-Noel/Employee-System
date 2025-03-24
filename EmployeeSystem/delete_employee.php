<?php
include "connection.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM employee WHERE id = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: index.php?message=Employee+deleted+successfully");
            exit();
        } else {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: index.php?error=Error+deleting+employee");
            exit();
        }
    } else {
        mysqli_close($conn);
        header("Location: index.php?error=Database+error");
        exit();
    }
} else {
    mysqli_close($conn);
    header("Location: index.php?error=Invalid+employee+ID");
    exit();
}
?>