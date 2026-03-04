<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}

include '../connect.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_code = mysqli_real_escape_string($conn, $_POST['course_code']);
    $course_name = mysqli_real_escape_string($conn, $_POST['course_name']);
    $lecturer_name = mysqli_real_escape_string($conn, $_POST['lecturer_name']);

    $sql = "INSERT INTO courses (course_code, course_name, lecturer_name) 
            VALUES ('$course_code', '$course_name', '$lecturer_name')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('เพิ่มรายวิชาเรียบร้อย!');
                window.location.href = 'Courselistpage.php'; // เด้งไปหน้ารายการ (เดี๋ยวเราจะไปแก้หน้านี้กันต่อ)
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>