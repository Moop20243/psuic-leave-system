<?php
// ไฟล์: admin/insert_course.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}

include '../connect.php';

// 2. ตรวจสอบว่ามีการส่งข้อมูลมาหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // รับค่าจากฟอร์ม (ชื่อต้องตรงกับ name ใน input ของหน้า Courselistpage.php)
    $course_code = mysqli_real_escape_string($conn, $_POST['course_code']);
    $course_name = mysqli_real_escape_string($conn, $_POST['course_name']);
    $lecturer_name = mysqli_real_escape_string($conn, $_POST['lecturer_name']);

    // 3. คำสั่ง SQL สำหรับเพิ่มข้อมูล
    $sql = "INSERT INTO courses (course_code, course_name, lecturer_name) 
            VALUES ('$course_code', '$course_name', '$lecturer_name')";

    // 4. สั่งรันคำสั่ง SQL
    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('เพิ่มรายวิชาเรียบร้อย!');
                /* แก้ไขจุดนี้: ให้เด้งกลับไปที่หน้าตารางรายการวิชา */
                window.location.href = 'Courselistpage.php'; 
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // ปิดการเชื่อมต่อ
    mysqli_close($conn);
}
?>