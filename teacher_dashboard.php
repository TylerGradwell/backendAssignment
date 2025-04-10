<?php
//start of my code, once again all mine. i used help from the uni slides but i dont think i need to ref this
session_start();
// check if its actually a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: index.php");
    exit();
}
// connecting to db
require_once 'db_connect.php';
//sql statemrnt to retrive information
$teacher_query = $conn->prepare("
   SELECT 
       t.*,
       c.class_name
   FROM teacher t
   LEFT JOIN classes c ON t.class_id = c.class_id
   WHERE t.teacher_id = ?
");
$teacher_query->bind_param("i", $_SESSION['user_id']);
$teacher_query->execute();
$teacher_info = $teacher_query->get_result()->fetch_assoc();

// gets the number of students in their class
$student_count_query = $conn->prepare("
    SELECT COUNT(*) as total_students 
    FROM pupil 
    WHERE class_id = ?
");
$student_count_query->bind_param("i", $teacher_info['class_id']);
$student_count_query->execute();
$student_count = $student_count_query->get_result()->fetch_assoc()['total_students'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="styles/dashboard.css">
</head>
<body>
    <div class="container">
        <h1>My Teacher Dashboard</h1>
        
        <div class="dashboard">
            <h2>My Details</h2>
            <div class="information">
                <!--shows teacher info-->
                <p><strong>Name:</strong> <?php echo htmlspecialchars($teacher_info['first_name'] . ' ' . $teacher_info['last_name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($teacher_info['email']); ?></p>
                <p><strong>Specialization:</strong> <?php echo htmlspecialchars($teacher_info['specialization']); ?></p>
                
                <!-- class info -->
                <p><strong>My Class:</strong> <?php echo htmlspecialchars($teacher_info['class_name']); ?></p>
                <p><strong>Total Students:</strong> <?php echo $student_count; ?></p>
                
                <!-- salary info - use field directly from teacher table -->
                <p><strong>Annual Salary:</strong> £<?php echo number_format($teacher_info['annual_salary'], 2); ?></p>
                <p><strong>Pay Scale:</strong> <?php echo "Main Pay Scale"; ?></p>
            </div>
        </div>

        <div class="dashboard">
            <h2>Quick Actions</h2>
            <div class="action-buttons">
                <a href="view_students.php" class="btn">View Students</a>
                <a href="manage_students.php" class="btn">Manage Students</a>
                <a href="mark_attendance.php" class="btn">Mark Attendance</a>
            </div>
        </div>

        <div class="dashboard">
            <h2>Upcoming Events</h2>
            <ul>
                <li>Parents evening: Next Thursday</li>
                <li>School trip to Shanghai: In 3 weeks</li>
                <li>Sports Day: Next month</li>
            </ul>
        </div>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>

<?php
$teacher_query->close();
$student_count_query->close();
$conn->close();
?>