<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: ../student/index.php");
    exit();
}

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
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
       
        .select2-container .select2-selection--single {
            height: 45px !important;            
            border: 1px solid #ccc !important;  
            border-radius: 8px !important;     
            background-color: #fff !important;
            
          
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23333' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: right 15px center !important; 
            background-size: 16px !important;  
        }

        
        .select2-container .select2-selection--single .select2-selection__rendered {
            line-height: 43px !important;       
            padding-left: 10px !important;      
            padding-right: 40px !important;     
            color: #333 !important;             
            font-size: 16px !important;         
            font-family: Arial, Helvetica, sans-serif !important;
        }

        
        .select2-container .select2-selection--single .select2-selection__arrow {
            display: none !important;
        }

        
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #193c6c !important;
            box-shadow: 0 0 0 3px rgba(25, 60, 108, 0.1) !important;
            outline: none !important;
        }

      
        .select2-container {
            width: 100% !important;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <div class="logo">
            <img src="../Photo/PSUIC White Medium  2024 6.png" alt="PSUIC Logo">
        </div>
    </div>

    <div class="main-container"> 
        <div class="menu-bar">
            <a href="Homepage.php" class="menu-item"><img src="../Photo/homepage.png" alt=""><h3>Home Page</h3></a>
            <a href="Absencepage.php" class="menu-item active"><img src="../Photo/absencerequest.png" alt=""><h3>Absence Request</h3></a>
            <a href="Checkstatuspage.php" class="menu-item"><img src="../Photo/checkstatus.png" alt=""><h3>Check Status</h3></a>
            <a href="Historypsge.php" class="menu-item"><img src="../Photo/history.png" alt=""><h3>History</h3></a>
            <a href="Advisorpage.php" class="menu-item"><img src="../Photo/advisor.png" alt=""><h3>Advisor</h3></a>
            <a href="index.php" class="menu-item logout"><img src="../Photo/logout.png" alt=""><h3>Logout</h3></a>
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
                            <option value="" disabled selected>Type to search or select course...</option>
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
                                I confirm that the information provided is correct.<br> (ข้าพเจ้ายืนยันว่าข้อมูลถูกต้อง และรับทราบว่าไม่สามารถแก้ไขได้ภายหลัง)
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Submit</button>
                </form>
            </div>
        </div>
    </div> 

    <script>
        $(document).ready(function() {
            $('#course').select2({
                placeholder: "Type to search or select course...",
                allowClear: true,
                width: '100%'
            });
        });

        const fileInput = document.getElementById('medical_cert');
        const uploadDesign = document.getElementById('upload_design');
        const fileNameDisplay = document.getElementById('file_name_display');
        const uploadIcon = document.getElementById('upload_icon');
        const removeBtn = document.getElementById('remove_btn');

        fileInput.addEventListener('change', function(e) {
            if(this.files && this.files.length > 0) {
                const fileName = this.files[0].name;
                fileNameDisplay.innerHTML = `<span style="color: #28a745; font-weight: bold; font-size: 16px;">✅ อัปโหลดสำเร็จ</span><br><span style="color: #555; font-size: 14px; word-break: break-all;">${fileName}</span>`;
                uploadDesign.style.borderColor = '#28a745';
                uploadDesign.style.backgroundColor = '#f0fff4';
                uploadIcon.style.display = 'none';
                removeBtn.style.display = 'block';
            }
        });

        removeBtn.addEventListener('click', function(e) {
            e.preventDefault(); 
            fileInput.value = ''; 
            fileNameDisplay.innerHTML = 'Select file';
            uploadDesign.style.borderColor = ''; 
            uploadDesign.style.backgroundColor = ''; 
            uploadIcon.style.display = 'inline-block';
            removeBtn.style.display = 'none';
        });
    </script>
</body>
</html>