<?php
session_start();
session_unset();    // ลบตัวแปรทั้งหมดใน session
session_destroy();  // ทำลาย session
header("Location: student/index.php"); // เด้งกลับหน้า login
exit();
?>