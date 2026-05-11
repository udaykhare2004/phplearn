<?php
// ── Get ID from URL ───────────────────────────────────────────
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) { header("Location: students.php"); exit; }

// ── Connect & fetch that student ──────────────────────────────
$conn = mysqli_connect("localhost", "root", "", "phplearn");
if (!$conn) die("Connection failed: " . mysqli_connect_error());

$stmt = mysqli_prepare($conn, "SELECT * FROM students WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$student = mysqli_fetch_assoc($result);

if (!$student) { echo "Student not found."; exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>View Student</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 500px; margin: 40px auto; padding: 0 16px; }
    h2 { margin-bottom: 20px; }
    p { font-size: 14px; margin: 8px 0; }
    span { font-weight: bold; }
    hr { margin: 20px 0; border: none; border-top: 1px solid #ddd; }
    a { color: #007bff; font-size: 14px; margin-right: 12px; }
  </style>
</head>
<body>

  <h2>Student Details</h2>

  <p>ID: <span><?= $student['id'] ?></span></p>
  <p>First Name: <span><?= htmlspecialchars($student['first_name']) ?></span></p>
  <p>Last Name: <span><?= htmlspecialchars($student['last_name']) ?></span></p>
  <p>Email: <span><?= htmlspecialchars($student['email']) ?></span></p>
  <p>Phone: <span><?= htmlspecialchars($student['phone']) ?: '—' ?></span></p>
  <p>Date of Birth: <span><?= $student['dob'] ?: '—' ?></span></p>
  <p>Registered: <span><?= $student['created_at'] ?></span></p>

  <hr>
  <a href="edit.php?id=<?= $student['id'] ?>">Edit</a>
  <a href="students.php">← Back to List</a>

</body>
</html>
<?php mysqli_stmt_close($stmt); mysqli_close($conn); ?>