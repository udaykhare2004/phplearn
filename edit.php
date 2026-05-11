<?php

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) { header("Location: students.php"); exit; }

$conn = mysqli_connect("localhost", "root", "", "phplearn");
if (!$conn) die("Connection failed: " . mysqli_connect_error());


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name']  ?? '');
    $email      = trim($_POST['email']      ?? '');
    $phone      = trim($_POST['phone']      ?? '');
    $dob        = trim($_POST['dob']        ?? '');

    $errors = [];
    if (empty($first_name)) $errors[] = "First name is required.";
    if (empty($last_name))  $errors[] = "Last name is required.";
    if (empty($email))      $errors[] = "Email is required.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email is not valid.";

    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, "UPDATE students SET first_name=?, last_name=?, email=?, phone=?, dob=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "sssssi", $first_name, $last_name, $email, $phone, $dob, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: students.php");
            exit;
        } else {
            echo "<p style='color:red'>Error: " . mysqli_error($conn) . "</p>";
        }
    } else {
        foreach ($errors as $e) echo "<p style='color:red;font-family:Arial;'>❌ $e</p>";
    }
}


$stmt = mysqli_prepare($conn, "SELECT * FROM students WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result  = mysqli_stmt_get_result($stmt);
$student = mysqli_fetch_assoc($result);

if (!$student) { echo "Student not found."; exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>Edit Student</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 500px; margin: 40px auto; padding: 0 16px; }
    h2 { margin-bottom: 20px; }
    label { display: block; margin-top: 14px; font-size: 14px; font-weight: bold; }
    input[type="text"], input[type="email"], input[type="tel"], input[type="date"] {
      width: 100%; padding: 8px; margin-top: 4px;
      border: 1px solid #ccc; border-radius: 4px;
      font-size: 14px; box-sizing: border-box;
    }
    button { margin-top: 20px; padding: 10px 24px; background: #007bff; color: #fff; border: none; border-radius: 4px; font-size: 15px; cursor: pointer; }
    button:hover { background: #0056b3; }
    a { display: inline-block; margin-top: 12px; color: #007bff; font-size: 14px; }
  </style>
</head>
<body>

  <h2>Edit Student</h2>

  <form action="edit.php?id=<?= $id ?>" method="POST">

    <label>First Name</label>
    <input type="text" name="first_name" value="<?= htmlspecialchars($student['first_name']) ?>" required />

    <label>Last Name</label>
    <input type="text" name="last_name" value="<?= htmlspecialchars($student['last_name']) ?>" required />

    <label>Email</label>
    <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required />

    <label>Phone</label>
    <input type="tel" name="phone" value="<?= htmlspecialchars($student['phone']) ?>" />

    <label>Date of Birth</label>
    <input type="date" name="dob" value="<?= $student['dob'] ?>" />

    <button type="submit">Update Student</button>

  </form>

  <a href="students.php">← Back to List</a>

</body>
</html>
<?php mysqli_close($conn); ?>