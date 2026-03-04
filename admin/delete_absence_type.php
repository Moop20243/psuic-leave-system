<?php
session_start();
include '../connect.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // คำสั่งลบ
    $sql = "DELETE FROM absence_types WHERE id = '$id'";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: Absencetypepage.php"); // ลบเสร็จกลับหน้าเดิม
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>