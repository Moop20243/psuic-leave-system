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

$logged_in_user = $_SESSION['user_id'];


$sql = "SELECT lr.* FROM leave_requests lr
        INNER JOIN users u ON lr.student_id = u.username
        WHERE (lr.status = 'Pending Advisor' AND u.advisor_id = '$logged_in_user')
        OR (lr.status = 'Pending Lecturer' AND lr.course IN (
            SELECT course_code FROM courses WHERE lecturer_name = (SELECT fullname FROM users WHERE username = '$logged_in_user')
        ))
        ORDER BY lr.id DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSUIC Leave of absence</title>
    <link rel="stylesheet" href="../css.css/Menubarstyle.css">
    <link rel="stylesheet" href="../css.css/lecturerrequestliststyle.css">
</head>
<body>
    <div class="top-bar">
        <div class="logo"><img src="../Photo/PSUIC White Medium  2024 6.png" alt="PSUIC Logo"></div>
    </div>

    <div class="main-container"> 
        <div class="menu-bar">
            <a href="Lecturerhomepage.php" class="menu-item"><img src="../Photo/homepage.png"><h3>Home Page</h3></a>
            <a href="AbsenceRequestlistpage.php" class="menu-item active"><img src="../Photo/absencerequest.png"><h3>Absence Request list</h3></a>
            <a href="Lecturerhistorypage.php" class="menu-item"><img src="../Photo/history.png"><h3>History</h3></a>
            <a href="../logout.php" class="menu-item logout"><img src="../Photo/logout.png"><h3>Logout</h3></a>
        </div>

        <div class="content-area">
            <div class="history-container">
                <h1 class="main-title">Student Leave of absence Requests</h1>
                
                <div class="table-wrapper">
                    <table class="history-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid #ddd; text-align: left;">
                                <th style="padding: 15px;">Student ID</th> 
                                <th>Course</th>
                                <th>Absence Type</th>
                                <th>Date (Start - End)</th>
                                <th>Details</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($result)): ?>
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <td style="padding: 15px; font-weight: bold;"><?php echo $row['student_id']; ?></td>
                                        <td><?php echo $row['course']; ?></td>
                                        <td><?php echo $row['leave_type']; ?></td>
                                        <td>
                                            <?php echo date("d/m/Y", strtotime($row['start_date'])); ?> - <?php echo date("d/m/Y", strtotime($row['end_date'])); ?>
                                        </td>
                                        <td>
                                            <a href="lecturercheckstatus.php?id=<?php echo $row['id']; ?>" style="color: #0056b3; font-weight: bold; text-decoration: underline;">
                                                Check Detail
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="5" style="text-align: center; padding: 20px;">No pending requests.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> 
</body>
</html>