<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}

include '../connect.php';

// ตรวจสอบว่ามีการส่ง id คำขอ และ สถานะ มาหรือไม่
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);

    // อัปเดตสถานะในตาราง leave_requests
    $sql = "UPDATE leave_requests SET status = '$status' WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('อัปเดตสถานะเป็น " . $status . " เรียบร้อยแล้ว!');
                window.location.href = 'AbsenceRequestlistpage.php';
              </script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    header("Location: AbsenceRequestlistpage.php");
}

mysqli_close($conn);
?>