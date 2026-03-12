<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}


if ($_SESSION['role'] !== 'admin') {
    header("Location: ../logout.php"); 
    exit();
}

include '../connect.php';


$sql_total = "SELECT COUNT(*) as total FROM leave_requests";
$result_total = mysqli_query($conn, $sql_total);
$total_req = ($result_total) ? mysqli_fetch_assoc($result_total)['total'] : 0;


$sql_app = "SELECT COUNT(*) as total FROM leave_requests WHERE status='Approved'";
$result_app = mysqli_query($conn, $sql_app);
$app_req = ($result_app) ? mysqli_fetch_assoc($result_app)['total'] : 0;


$percent_app = ($total_req > 0) ? round(($app_req / $total_req) * 100) : 0;
$percent_rej = ($total_req > 0) ? (100 - $percent_app) : 0; 


$sql_top_students = "SELECT student_id, COUNT(*) as count 
                     FROM leave_requests 
                     GROUP BY student_id 
                     ORDER BY count DESC 
                     LIMIT 4";
$top_students_result = mysqli_query($conn, $sql_top_students);


$sql_max_s = "SELECT COUNT(*) as max_c FROM leave_requests GROUP BY student_id ORDER BY max_c DESC LIMIT 1";
$result_max_s = mysqli_query($conn, $sql_max_s);
$max_student_leave = ($result_max_s && mysqli_num_rows($result_max_s) > 0) ? mysqli_fetch_assoc($result_max_s)['max_c'] : 1;



$sql_top_courses = "SELECT course, COUNT(*) as count 
                    FROM leave_requests 
                    GROUP BY course 
                    ORDER BY count DESC 
                    LIMIT 4";
$top_courses_result = mysqli_query($conn, $sql_top_courses);


$sql_max_c = "SELECT COUNT(*) as max_c FROM leave_requests GROUP BY course ORDER BY max_c DESC LIMIT 1";
$result_max_c = mysqli_query($conn, $sql_max_c);
$max_course_leave = ($result_max_c && mysqli_num_rows($result_max_c) > 0) ? mysqli_fetch_assoc($result_max_c)['max_c'] : 1;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSUIC Dashboard</title>
    <link rel="stylesheet" href="../css.css/Menubarstyle.css">
    <link rel="stylesheet" href="../css.css/admindashboardstyle.css">
</head>
<body>
    <div class="top-bar">
        <div class="logo">
            <img src="../Photo/PSUIC White Medium  2024 6.png" alt="PSUIC Logo">
        </div>
        
    </div>

    <div class="main-container">  
        <div class="menu-bar">
            <a href="Dashboardpage.php" class="menu-item active">
                <img src="../Photo/dashboard.png" alt="">
                <h3>Dashboard</h3>
            </a>
            <a href="Courselistpage.php" class="menu-item">
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
            
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Absence Requests</h3>
                        <h1 class="big-number"><?php echo $total_req; ?></h1>
                        <p class="trend">Total Submission</p>
                    </div>
                    <div class="stat-chart">
                        <img src="../Photo/Group 1.png" alt="Bar Chart">
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Absence Status</h3>
                        <div class="legend">
                            <div class="legend-item">
                                <span class="dot approved"></span>
                                <span>Approved (<?php echo $percent_app; ?>%)</span>
                            </div>
                            <div class="legend-item">
                                <span class="dot rejected"></span>
                                <span>Not Approved (<?php echo $percent_rej; ?>%)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="list-section">
                <h2>Students with Most Leave of absence Requests</h2>
                <?php if ($top_students_result && mysqli_num_rows($top_students_result) > 0): ?>
                    <?php while($s_row = mysqli_fetch_assoc($top_students_result)): 
                        $width = ($s_row['count'] / $max_student_leave) * 100;
                    ?>
                        <div class="list-row">
                            <div class="label"><?php echo $s_row['student_id']; ?></div>
                            <div class="progress-container">
                                <div class="progress-bar" style="width: <?php echo $width; ?>%;"></div>
                            </div>
                            <div class="count"><?php echo $s_row['count']; ?> times</div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No data available</p>
                <?php endif; ?>
            </div>

            <div class="list-section">
                <h2>Courses with Most Leave of absence Requests</h2>
                <?php if ($top_courses_result && mysqli_num_rows($top_courses_result) > 0): ?>
                    <?php while($c_row = mysqli_fetch_assoc($top_courses_result)): 
                        $width = ($c_row['count'] / $max_course_leave) * 100;
                    ?>
                        <div class="list-row">
                            <div class="label"><?php echo $c_row['course']; ?></div>
                            <div class="progress-container">
                                <div class="progress-bar" style="width: <?php echo $width; ?>%;"></div>
                            </div>
                            <div class="count"><?php echo $c_row['count']; ?> times</div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No data available</p>
                <?php endif; ?>
            </div>

        </div> 
    </div>
</body>
</html>