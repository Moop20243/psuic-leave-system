<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}

include '../connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSUIC Leave of absence</title>
    <link rel="stylesheet" href="../css.css/Menubarstyle.css">
    <link rel="stylesheet" href="../css.css/adminabsencetypestyle.css">
</head>
<body>
    <div class="top-bar">
        <div class="logo">
            <img src="../Photo/PSUIC White Medium  2024 6.png" alt="PSUIC Logo">
        </div>
        <div class="change">
            <img src="../Photo/solar_global-outline.png" alt="Change Language">
        </div>
    </div>

    <div class="main-container">  
        <div class="menu-bar">
            <a href="Dashboardpage.php" class="menu-item">
                <img src="../Photo/dashboard.png" alt="">
                <h3>Dashboard</h3>
            </a>
            <a href="Courselistpage.php" class="menu-item">
                <img src="../Photo/courselist.png" alt="">
                <h3>Course List</h3>
            </a>
            <a href="Absencetypepage.php" class="menu-item active">
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
            <div class="course-list-card">
                <div class="card-header">
                    <h1>Absence Type</h1>
                </div>

                <div style="background: #f9f9f9; padding: 20px; border-radius: 10px; margin-bottom: 25px; border: 1px solid #eee;">
                    <form action="insert_absence_type.php" method="POST" style="display: flex; gap: 15px; align-items: flex-end;">
                        <div style="flex: 2;">
                            <label style="display:block; font-size: 13px; margin-bottom: 5px;">New Absence Type</label>
                            <input type="text" name="type_name" placeholder="e.g. ลาป่วย (Sick Leave)" required style="width:100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                        </div>
                        <button type="submit" style="background: #003366; color: white; border: none; padding: 11px 25px; border-radius: 5px; cursor: pointer; font-weight: bold;">+ Add Type</button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="course-table">
                        <thead>
                            <tr>
                                <th width="20%">ID</th>
                                <th width="60%">Absence Type</th>
                                <th width="20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM absence_types ORDER BY id ASC";
                            $result = mysqli_query($conn, $sql);

                            if ($result && mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo '<td>';
                                    echo '<a href="editabsencetypepage.php?id=' . $row['id'] . '" class="id-link">';
                                    echo str_pad($row['id'], 4, '0', STR_PAD_LEFT);
                                    echo '</a>';
                                    echo '</td>';
                                    echo '<td>' . $row['type_name'] . '</td>';
                                    echo '<td>';
                                    echo '<a href="delete_absence_type.php?id=' . $row['id'] . '" onclick="return confirm(\'ยืนยันการลบประเภทการลานี้?\')" style="color: red; text-decoration: none; font-weight:bold;">Delete</a>';
                                    echo '</td>';
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3' style='text-align:center; padding: 20px;'>No absence types found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    <a href="#" class="btn-next">Next ></a>
                </div>
            </div>
        </div>
    </div> 
</body>
</html>