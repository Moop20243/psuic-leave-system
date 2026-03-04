<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}

include '../connect.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM absence_types WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Absence Type</title>
    <link rel="stylesheet" href="../css.css/Menubarstyle.css">
    <link rel="stylesheet" href="../css.css/addabsencetypestyle.css"> 
</head>
<body>
    <div class="top-bar">
        <div class="logo"><img src="../Photo/PSUIC White Medium  2024 6.png"></div>
    </div>

    <div class="main-container">  
        <div class="menu-bar">
             <a href="Dashboardpage.php" class="menu-item"><img src="../Photo/dashboard.png"><h3>Dashboard</h3></a>
             <a href="Courselistpage.php" class="menu-item"><img src="../Photo/courselist.png"><h3>Course List</h3></a>
             <a href="Absencetypepage.php" class="menu-item active"><img src="../Photo/absencetype.png"><h3>Absence Type</h3></a>
             </div>

        <div class="content-area">
            <div class="add-card">
                <h1 class="page-title">Edit Absence Type</h1>
                
                <form class="add-form" action="update_absence_type.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    
                    <div class="form-group">
                        <label>ID</label>
                        <input type="text" value="<?php echo str_pad($row['id'], 4, '0', STR_PAD_LEFT); ?>" class="form-input" readonly style="background-color: #eee;">
                    </div>

                    <div class="form-group">
                        <label>Absence Type Name</label>
                        <input type="text" name="type_name" value="<?php echo $row['type_name']; ?>" class="form-input" required>
                    </div>

                    <div class="form-submit-container">
                        <button type="submit" class="btn-submit">Save Update</button>
                    </div>
                </form>
                
                 <div class="back-container">
                    <a href="Absencetypepage.php" class="btn-back">&lt; Back</a>
                </div>

            </div>
        </div>
    </div> 
</body>
</html>