<?php
session_start();

// 1. เช็คการล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}

// 2. 🔴 ป้องกันอาจารย์เข้าหน้าแบบฟอร์ม
if ($_SESSION['role'] !== 'student') {
    header("Location: ../logout.php");
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
    <link rel="stylesheet" href="../css.css/absencerequeststyle.css">
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
            <a href="Homepage.php" class="menu-item">
                <img src="../Photo/homepage.png" alt="">
                <h3>Home Page</h3>
            </a>
            
            <a href="Absencepage.php" class="menu-item active"> 
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
            
            <a href="Advisorpage.html" class="menu-item">
                <img src="../Photo/advisor.png" alt="">
                <h3>Advisor</h3>
            </a>
            
            <a href="index.php" class="menu-item logout">
                <img src="../Photo/logout.png" alt="">
                <h3>Logout</h3>
            </a>
        </div>

        <div class="content-area">
            <div class="absence-container">
                <h1 class="page-title">Absence Request</h1>

                <form action="process_absence.php" method="POST" enctype="multipart/form-data" class="absence-form">
                    
                    <div class="form-group">
                        <label for="absence_type">Absence Type</label>
                        <select name="absence_type" id="absence_type" required>
                            <option value="" disabled selected>Select a Absence type</option>
                            <?php
                            $sql_type = "SELECT * FROM absence_types ORDER BY id ASC";
                            $result_type = mysqli_query($conn, $sql_type);
                            while($row_type = mysqli_fetch_assoc($result_type)) {
                                echo '<option value="' . $row_type['type_name'] . '">' . $row_type['type_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="course">Course</label>
                        <select name="course" id="course" required>
                            <option value="" disabled selected>Select the course</option>
                            <?php
                            $sql_course = "SELECT * FROM courses ORDER BY course_code ASC";
                            $result_course = mysqli_query($conn, $sql_course);
                            while($row_course = mysqli_fetch_assoc($result_course)) {
                                echo '<option value="' . $row_course['course_code'] . '">' . $row_course['course_code'] . ' - ' . $row_course['course_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="reason">Reason</label>
                        <input type="text" name="reason" id="reason" placeholder="Reason for Absence request" required>
                    </div>

                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="text" name="contact_number" id="contact_number" placeholder="0xx-xxx-xxxx" pattern="[0-9]{10}" title="กรุณากรอกเบอร์โทรศัพท์ 10 หลัก (เฉพาะตัวเลข)" required>
                    </div>

                    <div class="form-group">
                        <label>Medical certificate <span class="optional">(if any)</span></label>
                        <div class="file-upload-wrapper" style="position: relative;">
                            
                            <input type="file" name="medical_cert" id="medical_cert" accept="image/*,.pdf" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer; z-index: 2;">
                            
                            <div class="file-upload-design" id="upload_design" style="transition: 0.3s; z-index: 1; position: relative;">
                                <img src="../Photo/upload.png" alt="" id="upload_icon" style="width: 40px; opacity: 0.5;">
                                <p id="file_name_display">Select file</p>
                            </div>

                            <button type="button" id="remove_btn" style="display: none; position: absolute; top: 15px; right: 15px; z-index: 3; background: #ff4d4f; color: white; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer; font-weight: bold; font-size: 16px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">✕</button>
                            
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 25px; padding: 15px; background-color: #fff5f5; border: 1px solid #fed7d7; border-radius: 10px;">
                        <div style="display: flex; align-items: flex-start; gap: 12px;">
                            <input type="checkbox" id="confirm_submit" name="confirm_submit" required style="width: 24px; height: 24px; margin-top: 2px; cursor: pointer;">
                            <label for="confirm_submit" style="font-size: 15px; color: #c53030; font-weight: 500; cursor: pointer; line-height: 1.5;">
                                I confirm that the information provided is correct.
                               <br> (ข้าพเจ้ายืนยันว่าข้อมูลถูกต้อง และรับทราบว่าไม่สามารถแก้ไขได้ภายหลัง)
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Submit</button>
                </form>
            </div>
        </div>
    </div> 

    <script>
        const fileInput = document.getElementById('medical_cert');
        const uploadDesign = document.getElementById('upload_design');
        const fileNameDisplay = document.getElementById('file_name_display');
        const uploadIcon = document.getElementById('upload_icon');
        const removeBtn = document.getElementById('remove_btn');

        // เมื่อมีการเลือกไฟล์
        fileInput.addEventListener('change', function(e) {
            if(this.files && this.files.length > 0) {
                const fileName = this.files[0].name;
                
                // เปลี่ยนข้อความเป็นชื่อไฟล์ และเปลี่ยนกล่องเป็นสีเขียว
                fileNameDisplay.innerHTML = `<span style="color: #28a745; font-weight: bold; font-size: 16px;">✅ อัปโหลดสำเร็จ</span><br><span style="color: #555; font-size: 14px; word-break: break-all;">${fileName}</span>`;
                uploadDesign.style.borderColor = '#28a745';
                uploadDesign.style.backgroundColor = '#f0fff4';
                
                // ซ่อนไอคอนอัปโหลดเดิม และโชว์ปุ่มกากบาท
                uploadIcon.style.display = 'none';
                removeBtn.style.display = 'block';
            }
        });

        // เมื่อกดปุ่มกากบาท (X)
        removeBtn.addEventListener('click', function(e) {
            e.preventDefault(); 
            
            // ล้างค่าไฟล์
            fileInput.value = ''; 
            
            // คืนค่าหน้าตากลับเป็นเหมือนเดิม
            fileNameDisplay.innerHTML = 'Select file';
            uploadDesign.style.borderColor = ''; 
            uploadDesign.style.backgroundColor = ''; 
            
            // โชว์ไอคอนอัปโหลดกลับมา และซ่อนปุ่มกากบาท
            uploadIcon.style.display = 'inline-block';
            removeBtn.style.display = 'none';
        });
    </script>
</body>
</html>

