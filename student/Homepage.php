<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}


if ($_SESSION['role'] !== 'student') {
    header("Location: ../logout.php"); 
    exit();
}

include '../connect.php';

$student_id = $_SESSION['user_id'];


$sql_prof = "SELECT profile_picture FROM users WHERE username = '$student_id'";
$res_prof = mysqli_query($conn, $sql_prof);
$row_prof = mysqli_fetch_assoc($res_prof);

$profile_pic = (!empty($row_prof['profile_picture'])) ? "../Photo/" . $row_prof['profile_picture'] : "../Photo/advisor.png";


$sql_stats = "SELECT course, COUNT(*) as leave_count 
              FROM leave_requests 
              WHERE student_id = '$student_id' 
              GROUP BY course";
$res_stats = mysqli_query($conn, $sql_stats);


$leave_data = [];
if ($res_stats) {
    while($row = mysqli_fetch_assoc($res_stats)) {
        $leave_data[] = $row;
    }
}


$max_leave = 3; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSUIC Leave of absence</title>
    <link rel="stylesheet" href="../css.css/Menubarstyle.css">
    <link rel="stylesheet" href="../css.css/Studenthomepagestyle.css">
</head>
<body>
    <div class="top-bar">
        <div class="logo">
            <img src="../Photo/PSUIC White Medium  2024 6.png" alt="PSUIC Logo">
        </div>
    </div>

    <div class="main-container"> 
        <div class="menu-bar">
            <a href="Homepage.php" class="menu-item active">
                <img src="../Photo/homepage.png" alt="">
                <h3>Home Page</h3>
            </a>
            <a href="Absencepage.php" class="menu-item">
                <img src="../Photo/absencerequest.png" alt="">
                <h3>Absence Request</h3>
            </a>
            <a href="Checkstatuspage.php" class="menu-item">
                <img src="../Photo/checkstatus.png" alt="">
                <h3>Check Status</h3>
            </a>
            <a href="Historypsge.php" class="menu-item">
                <img src="../Photo/history.png" alt="">
                <h3>History</h3>
            </a>
            <a href="Advisorpage.php" class="menu-item">
                <img src="../Photo/advisor.png" alt="">
                <h3>Advisor</h3>
            </a>
            <a href="../logout.php" class="menu-item logout">
                <img src="../Photo/logout.png" alt="">
                <h3>Logout</h3>
            </a>
        </div>

        <div class="content-area">
    
            <div class="card">
                <h3>Virtual Student Card</h3>
                <div class="card-content">
                    <img src="<?php echo $profile_pic; ?>" alt="Student Photo" style="object-fit: cover; width: 80px; height: 80px; border-radius: 10px;">
                    <div class="info">
                        <h2><?php echo $_SESSION['fullname']; ?></h2>
                        <h3><?php echo $_SESSION['user_id']; ?></h3>
                        <h3>PSUIC Student</h3>
                    </div>
                </div>
            </div>
            
            <div class="number">
                <h2>Number of times of leave taken</h2>
                
                <?php if(count($leave_data) > 0): ?>
                    <?php foreach($leave_data as $data): 
                        $taken = $data['leave_count'];
                        
                        $percent_taken = ($taken / $max_leave) * 100;
                        if($percent_taken > 100) $percent_taken = 100; 
                    ?>
                    <div class="stat-row">
                        <label><?php echo $data['course']; ?></label>
                        <div class="progress-bar"><div class="progress-fill" style="width: <?php echo $percent_taken; ?>%;"></div></div>
                        <span class="times"><?php echo $taken; ?> <?php echo ($taken > 1) ? 'times' : 'time'; ?></span>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #888; margin-top: 15px;">No leave requests yet.</p>
                <?php endif; ?>

            </div>

            <div class="number">
                <h2>Number of times leave can be taken</h2>
                
                <?php if(count($leave_data) > 0): ?>
                    <?php foreach($leave_data as $data): 
                        $taken = $data['leave_count'];
                        $remaining = $max_leave - $taken; 
                        if($remaining < 0) $remaining = 0; 
                        $percent_remain = ($remaining / $max_leave) * 100;
                    ?>
                    <div class="stat-row">
                        <label><?php echo $data['course']; ?></label>
                        <div class="progress-bar"><div class="progress-fill" style="width: <?php echo $percent_remain; ?>%;"></div></div>
                        <span class="times"><?php echo $remaining; ?> <?php echo ($remaining > 1 || $remaining == 0) ? 'times' : 'time'; ?></span>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #888; margin-top: 15px;">You have full quota for all courses.</p>
                <?php endif; ?>
            </div>

        </div>
    </div> 
</body>
</html>