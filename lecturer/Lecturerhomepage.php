<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}


if ($_SESSION['role'] !== 'lecturer') {
    header("Location: ../logout.php");
    exit();
}

include '../connect.php';


$lecturer_id = $_SESSION['user_id'];
$fullname = $_SESSION['fullname'];


$sql_prof = "SELECT profile_picture FROM users WHERE username = '$lecturer_id'";
$res_prof = mysqli_query($conn, $sql_prof);
$row_prof = mysqli_fetch_assoc($res_prof);
$profile_pic = (!empty($row_prof['profile_picture'])) ? "../Photo/" . $row_prof['profile_picture'] : "../Photo/advisor.png";


$sql_total = "SELECT COUNT(l.id) as total 
              FROM leave_requests l 
              JOIN users s ON l.student_id = s.username 
              WHERE s.advisor_id = '$lecturer_id'"; 
$total_result = mysqli_query($conn, $sql_total);
$total_req = ($total_result) ? mysqli_fetch_assoc($total_result)['total'] : 0;

$sql_app = "SELECT COUNT(l.id) as total 
            FROM leave_requests l 
            JOIN users s ON l.student_id = s.username 
            WHERE s.advisor_id = '$lecturer_id' AND l.status='Approved'";
$app_result = mysqli_query($conn, $sql_app);
$app_req = ($app_result) ? mysqli_fetch_assoc($app_result)['total'] : 0;

$percent_app = ($total_req > 0) ? round(($app_req / $total_req) * 100) : 0;
$percent_rej = ($total_req > 0) ? (100 - $percent_app) : 0;


$sql_top_students = "SELECT student_id, COUNT(*) as count 
                     FROM leave_requests l
                     JOIN users s ON l.student_id = s.username
                     WHERE s.advisor_id = '$lecturer_id'
                     GROUP BY student_id ORDER BY count DESC LIMIT 3";
$res_students = mysqli_query($conn, $sql_top_students);


$sql_top_courses = "SELECT course, COUNT(*) as count 
                    FROM leave_requests l
                    JOIN users s ON l.student_id = s.username
                    WHERE s.advisor_id = '$lecturer_id'
                    GROUP BY course ORDER BY count DESC LIMIT 3";
$res_courses = mysqli_query($conn, $sql_top_courses);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSUIC Leave of absence</title>
    <link rel="stylesheet" href="../css.css/Menubarstyle.css">
    <link rel="stylesheet" href="../css.css/lecturerhomepage.css">
</head>
<body>
    <div class="top-bar">
        <div class="logo">
            <img src="../Photo/PSUIC White Medium  2024 6.png" alt="PSUIC Logo">
        </div>
        
    </div>

    <div class="main-container"> 
        <div class="menu-bar">
            <a href="Lecturerhomepage.php" class="menu-item active">
                <img src="../Photo/homepage.png" alt="">
                <h3>Home Page</h3>
            </a>
            <a href="AbsenceRequestlistpage.php" class="menu-item">
                <img src="../Photo/absencerequest.png" alt="">
                <h3>Absence Request list</h3>
            </a>
            <a href="Lecturerhistorypage.php" class="menu-item">
                <img src="../Photo/history.png" alt="">
                <h3>History</h3>
            </a>
            <a href="../logout.php" class="menu-item logout">
                <img src="../Photo/logout.png" alt="">
                <h3>Logout</h3>
            </a>
        </div>

        <div class="content-area">
        
            <div class="top-section">
                <div class="card">
                    <h3>Virtual Lecturer Card</h3>
                    <div class="card-content">
                        <img src="<?php echo $profile_pic; ?>" alt="Lecturer Photo" style="object-fit: cover; width: 80px; height: 80px; border-radius: 10px;">
                        <div class="info">
                            <h2><?php echo $_SESSION['fullname']; ?></h2>
                            <h3>ID: <?php echo $_SESSION['user_id']; ?></h3>
                            <h3>PSUIC Lecturer</h3>
                        </div>
                    </div>
                </div>

                <div class="lecturer-dashboard">
                    <div class="summary-row">
                        <div class="stat-card leave-request">
                            <div class="stat-content">
                                <h3>Leave Requests</h3>
                                <h2 class="big-number"><?php echo $total_req; ?></h2>
                                <p class="trend">Updated live</p>
                            </div>
                            <div class="stat-graph">
                                <img src="../Photo/Group 1.png" alt="Bar Graph">
                            </div>
                        </div>

                        <div class="stat-card leave-status">
                            <div class="stat-content">
                                <h3>Leave Status</h3>
                                <div class="legend">
                                    <div class="legend-item">
                                        <span class="dot approved"></span>
                                        <p>Approved</p>
                                    </div>
                                    <div class="legend-item">
                                        <span class="dot rejected"></span>
                                        <p>Not Approved</p>
                                    </div>
                                </div>
                            </div>
                            <div class="stat-graph">
                                <div class="pie-container">
                                    <img src="../Photo/Group 2.png" alt="Pie Chart">
                                    <span class="percent-90"><?php echo $percent_app; ?>%</span>
                                    <span class="percent-10"><?php echo $percent_rej; ?>%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="number">
                <h2>Students with Most Leave Requests</h2>
                <?php while($s = mysqli_fetch_assoc($res_students)) { 
                    $p_width = ($total_req > 0) ? ($s['count'] / $total_req * 100) : 0;
                ?>
                <div class="stat-row">
                    <label><?php echo $s['student_id']; ?></label> 
                    <div class="progress-bar">
                        <div class="progress-fill" style="--target-width: <?php echo $p_width; ?>%;"></div>
                    </div>
                    <span class="times"><?php echo $s['count']; ?> times</span>
                </div>
                <?php } if(mysqli_num_rows($res_students) == 0) echo "<p>No data found</p>"; ?>
            </div>

            <div class="number" style="margin-top: 20px;">
                <h2>Courses with Most Leave Requests</h2>
                <?php while($c = mysqli_fetch_assoc($res_courses)) { 
                    $c_width = ($total_req > 0) ? ($c['count'] / $total_req * 100) : 0;
                ?>
                <div class="stat-row">
                    <label><?php echo $c['course']; ?></label> 
                    <div class="progress-bar">
                        <div class="progress-fill" style="--target-width: <?php echo $c_width; ?>%;"></div>
                    </div>
                    <span class="times"><?php echo $c['count']; ?> times</span>
                </div>
                <?php } if(mysqli_num_rows($res_courses) == 0) echo "<p>No data found</p>"; ?>
            </div>

        </div> 
    </div> 
</body>
</html>