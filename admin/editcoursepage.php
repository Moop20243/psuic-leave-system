<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}

include '../connect.php';



if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
   
    $sql = "SELECT * FROM courses WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
   
    if (!$row) {
        echo "<script>alert('ไม่พบข้อมูลรายวิชา'); window.location='Courselistpage.php';</script>";
        exit;
    }
} else {

    header("Location: Courselistpage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course - PSUIC</title>
    <link rel="stylesheet" href="../css.css/Menubarstyle.css">
    <link rel="stylesheet" href="../css.css/coursedatailstyle.css">
</head>
<body>
    <div class="top-bar">
        <div class="logo">
            <img src="../Photo/PSUIC White Medium  2024 6.png" alt="PSUIC Logo">
        </div>
        
    </div>

    <div class="main-container">  
        <div class="menu-bar">
            <a href="Dashboardpage.php" class="menu-item">
                <img src="../Photo/dashboard.png" alt="">
                <h3>Dashboard</h3>
            </a>
            
            <a href="Courselistpage.php" class="menu-item active">
                <img src="../Photo/courselist.png" alt="">
                <h3>Course List</h3>
            </a>
            
            <a href="Absencetypepage.php" class="menu-item">
                <img src="../Photo/absencetype.png" alt="">
                <h3>Absence Type</h3>
            </a>

            <a href="studentspage.php" class="menu-item">
                <img src="../Photo/student.png" alt="">
                <h3>Students</h3>
            </a>

            <a href="lecturerpage.php" class="menu-item">
                <img src="../Photo/lecturer.png" alt="">
                <h3>Lecturers</h3>
            </a>
            
            <a href="../logout.php" class="menu-item logout">
                <img src="../Photo/logout.png" alt="">
                <h3>Logout</h3>
            </a>
        </div>

        <div class="content-area">
            
            <div class="detail-card">
                <h1 class="page-title">Edit Course Details</h1>

                <form class="course-form" action="update_course.php" method="POST">
                    
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                    <div class="form-group">
                        <label>ID</label>
                        <input type="text" value="<?php echo str_pad($row['id'], 4, '0', STR_PAD_LEFT); ?>" class="form-input" readonly style="background-color: #f0f0f0;">
                    </div>

                    <div class="form-group">
                        <label>Course Code</label>
                        <input type="text" name="course_code" value="<?php echo $row['course_code']; ?>" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label>Course Name</label>
                        <input type="text" name="course_name" value="<?php echo $row['course_name']; ?>" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label>Lecturer Name</label>
                        <input type="text" name="lecturer_name" value="<?php echo $row['lecturer_name']; ?>" class="form-input" required>
                    </div>

                    <div class="form-actions">
                        <a href="Courselistpage.php" class="btn-back" style="margin-right: 10px;">&lt; Back</a>
                        
                        <button type="submit" class="btn-back" style="background-color: #28a745; border: none; cursor: pointer;">Save Changes</button>
                    </div>

                </form>
            </div>
        </div>
    </div> 
</body>
</html>