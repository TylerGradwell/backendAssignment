<?php
// manage students page
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: index.php"); exit();
}
require_once 'db_connect.php';
// get teacher class
$teacher_query = $conn->prepare("SELECT class_id, teacher_id FROM teacher WHERE teacher_id = ?");
$teacher_query->bind_param("i", $_SESSION['user_id']);
$teacher_query->execute();
$teacher_data = $teacher_query->get_result()->fetch_assoc();
$class_id = $teacher_data['class_id'];
// get classes for dropdown menu
$all_classes = $conn->query("SELECT class_id, class_name FROM classes ORDER BY class_name");
// deletes student
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $student_id = $_GET['id'];
    $delete = $conn->query("DELETE FROM pupil WHERE pupil_id = $student_id AND class_id = $class_id");
    if ($delete) {
        $message = "Student deleted";
    } else {
        $error = "Couldn't delete student";
    }
}
// add new student
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $postcode = $_POST['postcode'];
    $medical = $_POST['medical'];
    $class = $_POST['class'];
    
    // parent details
    $parent_fname = $_POST['parent_fname'];
    $parent_lname = $_POST['parent_lname'];
    $parent_relation = $_POST['parent_relation'];
    $parent_address = $_POST['parent_address'];
    $parent_postcode = $_POST['parent_postcode'];
    $parent_email = $_POST['parent_email'];
    $parent_phone = $_POST['parent_phone'];
    
    // add student
    $add = $conn->prepare("INSERT INTO pupil (class_id, first_name, last_name, date_of_birth, gender, address, postcode, medical_info, enrollment_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, CURDATE())");
    $add->bind_param("isssssss", $class, $fname, $lname, $dob, $gender, $address, $postcode, $medical);
    
    if ($add->execute()) {
        $pupil_id = $conn->insert_id;
        
        // add parent
        $parent_add = $conn->prepare("INSERT INTO parent_guardian (first_name, last_name, relationship_to_pupil, address, postcode, email, phone_number, primary_contact) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
        $parent_add->bind_param("sssssss", $parent_fname, $parent_lname, $parent_relation, $parent_address, $parent_postcode, $parent_email, $parent_phone);
        $parent_add->execute();
        $parent_id = $conn->insert_id;
        
        // link them together in the join table
        $conn->query("INSERT INTO pupil_parent (pupil_id, parent_id) VALUES ($pupil_id, $parent_id)");
        $message = "Student added successfully";
    } else {
        $error = "Error adding student";
    }
}
// get students list
$students = $conn->prepare("SELECT pupil_id, first_name, last_name, date_of_birth FROM pupil WHERE class_id = ?");
$students->bind_param("i", $class_id);
$students->execute();
$students_list = $students->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Students</title>
    <link rel="stylesheet" href="styles/dashboard.css">
    <style>
        .form-row {margin-bottom:10px;}
        .form-row label {display:block; margin-bottom:3px;}
        .form-row input, .form-row select, .form-row textarea {width:100%; padding:5px;}
        .delete-btn {background:red; color:white; padding:3px 6px; text-decoration:none;}
        .message {background:#d4edda; padding:10px; margin-bottom:10px;}
        .error {background:#f8d7da; padding:10px; margin-bottom:10px;}
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Students</h1>
        
        <?php if(isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if(isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="dashboard">
            <h2>My Class Students</h2>
            <?php if($students_list->num_rows > 0): ?>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>DOB</th>
                        <th>Actions</th>
                    </tr>
                    <?php while($student = $students_list->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $student['last_name'] . ', ' . $student['first_name']; ?></td>
                            <td><?php echo $student['date_of_birth']; ?></td>
                            <td>
                                <a href="view_students.php?id=<?php echo $student['pupil_id']; ?>" class="btn btn-small">View</a>
                                <a href="manage_students.php?delete=1&id=<?php echo $student['pupil_id']; ?>" class="delete-btn" onclick="return confirm('Delete this student?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>No students in your class.</p>
            <?php endif; ?>
        </div>
        
        <div class="dashboard">
            <h2>Add New Student</h2>
            <form method="post" action="">
                <h3>Student Details</h3>
                <div class="form-row">
                    <label>First Name:</label>
                    <input type="text" name="fname" required>
                </div>
                <div class="form-row">
                    <label>Last Name:</label>
                    <input type="text" name="lname" required>
                </div>
                <div class="form-row">
                    <label>Date of Birth:</label>
                    <input type="date" name="dob" required>
                </div>
                <div class="form-row">
                    <label>Gender:</label>
                    <select name="gender" required>
                        <option value="">Select</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-row">
                    <label>Class:</label>
                    <select name="class" required>
                        <?php while($class = $all_classes->fetch_assoc()): ?>
                            <option value="<?php echo $class['class_id']; ?>" <?php if($class['class_id'] == $class_id) echo "selected"; ?>>
                                <?php echo $class['class_name']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-row">
                    <label>Address:</label>
                    <textarea name="address" required></textarea>
                </div>
                <div class="form-row">
                    <label>Postcode:</label>
                    <input type="text" name="postcode" required>
                </div>
                <div class="form-row">
                    <label>Medical Info:</label>
                    <textarea name="medical"></textarea>
                </div>
                
                <h3>Parent Info</h3>
                <div class="form-row">
                    <label>First Name:</label>
                    <input type="text" name="parent_fname" required>
                </div>
                <div class="form-row">
                    <label>Last Name:</label>
                    <input type="text" name="parent_lname" required>
                </div>
                <div class="form-row">
                    <label>Relationship:</label>
                    <select name="parent_relation" required>
                        <option value="">Select</option>
                        <option value="Mother">Mother</option>
                        <option value="Father">Father</option>
                        <option value="Guardian">Guardian</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-row">
                    <label>Address:</label>
                    <textarea name="parent_address" required></textarea>
                </div>
                <div class="form-row">
                    <label>Postcode:</label>
                    <input type="text" name="parent_postcode" required>
                </div>
                <div class="form-row">
                    <label>Email:</label>
                    <input type="email" name="parent_email" required>
                </div>
                <div class="form-row">
                    <label>Phone:</label>
                    <input type="text" name="parent_phone" required>
                </div>
                
                <div class="form-row">
                    <button type="submit" class="btn">Add Student</button>
                </div>
            </form>
        </div>        
        <a href="teacher_dashboard.php" class="btn" style="margin-top:20px">Back to Dashboard</a>
    </div>
</body>
</html>
<?php
$conn->close();
?>