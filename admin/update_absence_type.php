<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}

include '../connect.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $type_name = mysqli_real_escape_string($conn, $_POST['type_name']);

    $sql = "UPDATE absence_types SET type_name = '$type_name' WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('อัปเดตข้อมูลเรียบร้อย!');
                window.location.href = 'Absencetypepage.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>