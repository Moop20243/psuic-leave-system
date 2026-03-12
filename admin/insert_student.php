<?php
include '../connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $advisor_id = mysqli_real_escape_string($conn, $_POST['advisor_id']);
    
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = 'student';

    
    $sql = "INSERT INTO users (username, password, fullname, role, advisor_id, email) 
            VALUES ('$username', '$password', '$fullname', '$role', '$advisor_id', '$email')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('เพิ่มข้อมูลนักศึกษาเรียบร้อยแล้ว!');
                window.location.href = 'studentspage.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>