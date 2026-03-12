<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}

include '../connect.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $course_code = mysqli_real_escape_string($conn, $_POST['course_code']);
    $course_name = mysqli_real_escape_string($conn, $_POST['course_name']);
    $lecturer_name = mysqli_real_escape_string($conn, $_POST['lecturer_name']);

    
    $sql = "UPDATE courses SET 
            course_code = '$course_code', 
            course_name = '$course_name', 
            lecturer_name = '$lecturer_name' 
            WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('อัปเดตข้อมูลเรียบร้อย! (Updated Successfully)');
                window.location.href = 'Courselistpage.php'; // กลับไปหน้ารายการ
              </script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>