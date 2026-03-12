<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}

include '../connect.php';

$student_id = $_SESSION['user_id'];


$sql = "SELECT a.fullname, a.email, a.profile_picture 
        FROM users s 
        LEFT JOIN users a ON s.advisor_id = a.username 
        WHERE s.username = '$student_id' AND s.role = 'student'";

$result = mysqli_query($conn, $sql);
$advisor = mysqli_fetch_assoc($result);


$adv_name = ($advisor && !empty($advisor['fullname'])) ? $advisor['fullname'] : "Not Assigned";
$adv_email = ($advisor && !empty($advisor['email'])) ? $advisor['email'] : "-";
$adv_department = "International College (PSUIC)"; 
$adv_office = "-"; 


if ($advisor && !empty($advisor['profile_picture'])) {
    
    $adv_photo = "../Photo/" . $advisor['profile_picture']; 
} else {
    $adv_photo = "../Photo/advisor.png"; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSUIC Leave of absence</title>
    <link rel="stylesheet" href="../css.css/Menubarstyle.css">
    <link rel="stylesheet" href="../css.css/advisorstyle.css">
</head>
<body>
    <div class="top-bar">
        <div class="logo">
            <img src="../Photo/PSUIC White Medium  2024 6.png" alt="PSUIC Logo">
        </div>
        
    </div>

    <div class="main-container"> 
        <div class="menu-bar">
            <a href="Homepage.php" class="menu-item ">
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
            
            <a href="Advisorpage.php" class="menu-item active">
                <img src="../Photo/advisor.png" alt="">
                <h3>Advisor</h3>
            </a>
            
            <a href="../logout.php" class="menu-item logout">
                <img src="../Photo/logout.png" alt="">
                <h3>Logout</h3>
            </a>
        </div>

        <div class="content-area">
            <div class="advisor-profile-container">
                <h1 class="main-title">Advisor</h1>

                <div class="advisor-card">
                    <div class="advisor-image">
                        <img src="<?php echo $adv_photo; ?>" alt="Advisor Photo" style="width: 100%; aspect-ratio: 3/4; object-fit: cover; object-position: top center; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                    </div>
                    <div class="advisor-info">
                        <div class="info-group">
                            <label>Advisor Name</label>
                            <p><?php echo $adv_name; ?></p>
                        </div>
                        <div class="info-group">
                            <label>Department</label>
                            <p><?php echo $adv_department; ?></p>
                        </div>
                        <div class="info-group">
                            <label>Email</label>
                            <p><?php echo $adv_email; ?></p>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div> 
    </div> 
</body>
</html>