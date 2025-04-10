// student_search.php
<?php
session_start();
// check if the user is logged in as a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: index.php");
    exit();
}
// connect to db
require_once 'db_connect.php';
// gets teachers class id
$teacher_id = $_SESSION['user_id'];
$teacher_query = $conn->prepare("SELECT class_id FROM teacher WHERE teacher_id = ?");
$teacher_query->bind_param("i", $teacher_id);
$teacher_query->execute();
$result = $teacher_query->get_result();
$teacher_data = $result->fetch_assoc();
$class_id = $teacher_data['class_id'];
// retrives all the students in the teachers class
$students_query = $conn->prepare("
    SELECT pupil_id, first_name, last_name 
    FROM pupil 
    WHERE class_id = ?
    ORDER BY last_name, first_name
");
$students_query->bind_param("i", $class_id);
$students_query->execute();
$students_result = $students_query->get_result();
// handle student deletion if requested, deletes all db files
if (isset($_POST['delete_student']) && isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];
    
    $conn->begin_transaction();
    
    try {
        $delete_pupil_parent = $conn->prepare("DELETE FROM pupil_parent WHERE pupil_id = ?");
        $delete_pupil_parent->bind_param("i", $student_id);
        $delete_pupil_parent->execute();

        $delete_attendance = $conn->prepare("DELETE FROM attendance WHERE pupil_id = ?");
        $delete_attendance->bind_param("i", $student_id);
        $delete_attendance->execute();

        $delete_loans = $conn->prepare("DELETE FROM library_loan WHERE pupil_id = ?");
        $delete_loans->bind_param("i", $student_id);
        $delete_loans->execute();
 
        $delete_dinner = $conn->prepare("DELETE FROM dinner_account WHERE pupil_id = ?");
        $delete_dinner->bind_param("i", $student_id);
        $delete_dinner->execute();

        $delete_pupil = $conn->prepare("DELETE FROM pupil WHERE pupil_id = ?");
        $delete_pupil->bind_param("i", $student_id);
        $delete_pupil->execute();
        // commit the change
        $conn->commit();
        // refreshes page
        header("Location: student_search.php?deleted=1");
        exit();
    } catch (Exception $e) {
        // rolls back in case of an erroor
        $conn->rollback();
        $error_message = "Error deleting student: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Search</title>
    <link rel="stylesheet" href="styles/dashboard.css">
</head>
<body>
    <div class="container">
        <h1>Student Management</h1>
        
        <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
            <div class="success-message">Student was successfully deleted.</div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <div class="dashboard">
            <h2>Students in Your Class</h2>
            
            <div class="student-list">
                <?php if ($students_result->num_rows > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($student = $students_result->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <a href="student_details.php?id=<?php echo $student['pupil_id']; ?>">
                                            <?php echo htmlspecialchars($student['last_name'] . ', ' . $student['first_name']); ?>
                                        </a>
                                    </td>
                                    <td class="action-buttons">
                                        <a href="student_details.php?id=<?php echo $student['pupil_id']; ?>" class="btn btn-small">View</a>
                                        <a href="mark_attendance.php?id=<?php echo $student['pupil_id']; ?>" class="btn btn-small">Attendance</a>
                                        <form method="post" onsubmit="return confirm('Are you sure you want to delete this student?');" style="display:inline;">
                                            <input type="hidden" name="student_id" value="<?php echo $student['pupil_id']; ?>">
                                            <button type="submit" name="delete_student" class="btn btn-small btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No students found in your class.</p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="dashboard">
            <h2>Add New Student</h2>
            <a href="add_student.php" class="btn">Add New Student</a>
        </div>
        
        <a href="teacher_dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>

<?php
$teacher_query->close();
$students_query->close();
$conn->close();
?>