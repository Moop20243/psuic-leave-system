<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}

include '../connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $type_name = mysqli_real_escape_string($conn, $_POST['type_name']);

    
    $sql = "INSERT INTO absence_types (type_name) VALUES ('$type_name')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('เพิ่มประเภทการลาเรียบร้อย!');
                /* กลับไปหน้าตารางเพื่อดูผลลัพธ์ */
                window.location.href = 'Absencetypepage.php'; 
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
}
?>