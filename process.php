<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: form.html");
    exit;
}

$first_name    = htmlspecialchars($_POST['first_name'] ?? '');
$last_name     = htmlspecialchars($_POST['last_name'] ?? '');
$email         = htmlspecialchars($_POST['email']      ?? '');
$phone         = htmlspecialchars($_POST['phone']      ?? '');
$dob           = htmlspecialchars($_POST['dob']        ?? '');
$age           = htmlspecialchars($_POST['age']        ?? '');
$course        = htmlspecialchars($_POST['course']     ?? '');
$gender        = htmlspecialchars($_POST['gender']     ?? '');
$about         = htmlspecialchars($_POST['about']      ?? '');
$interests     = array_map('htmlspecialchars', $_POST['interests'] ?? []);
$interests_str = !empty($interests) ? implode(', ', $interests) : 'None';


$errors = [];
 
if (empty($first_name))
    $errors[] = "First name is required.";
 
if (empty($last_name))
    $errors[] = "Last name is required.";
 
if (empty($email))
    $errors[] = "Email is required.";
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
    $errors[] = "Email is not valid.";
 
if (!empty($phone) && strlen($phone) < 7)
    $errors[] = "Phone number is too short.";
 
if (empty($course))
    $errors[] = "Please select a course.";
 
if (empty($gender))
    $errors[] = "Please select a gender.";
 
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color:red;font-family:Arial;'> $error</p>";
    }
    echo "<a href='form.html' style='font-family:Arial;'>← Go back and fix</a>";
    exit;
}
 

$host = "localhost";
$user = "root";
$pass = "";
$db   = "phplearn";
 
$conn = mysqli_connect($host, $user, $pass, $db);
 
if (!$conn) {
    die("<p style='color:red;font-family:Arial;'>Connection failed: " . mysqli_connect_error() . "</p>");
}
 

 
$sql = "INSERT INTO students (first_name, last_name, email, phone, dob)
        VALUES (?, ?, ?, ?, ?)";
 
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssss", $first_name, $last_name, $email, $phone, $dob);
 
if (mysqli_stmt_execute($stmt)) {
    echo "<p style='font-family:Arial;'>Student <strong>$first_name $last_name</strong> registered successfully!</p>";
    echo "<a href='form.html' style='font-family:Arial;'>← Register another</a>";
} else {
    echo "<p style='color:red;font-family:Arial;'> Error: " . mysqli_error($conn) . "</p>";
}
 
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>Form Received</title>
  <style>
    body  { font-family: Arial, sans-serif; max-width: 500px; margin: 40px auto; padding: 0 16px; }
    h2    { margin-bottom: 16px; }
    p     { font-size: 14px; margin: 8px 0; }
    span  { font-weight: bold; }
    hr    { margin: 20px 0; border: none; border-top: 1px solid #ddd; }
    a     { color: #007bff; font-size: 14px; }
  </style>
</head>
<body>

  <h2>Form Received</h2>

  <p>First Name: <span><?= $first_name ?></span></p>
  <p> Last Name: <span><?= $last_name ?></span></p>
  <p>Email: <span><?= $email ?></span></p>
  <p>Phone: <span><?= $phone ?: '—' ?></span></p>
  <p>Date of Birth: <span><?= $dob ?: '—' ?></span></p>
  <p>Age: <span><?= $age ?: '—' ?></span></p>
  <p>Course: <span><?= $course ?></span></p>
  <p>Gender: <span><?= $gender ?></span></p>
  <p>Interests: <span><?= $interests_str ?></span></p>
  <p>About: <span><?= $about ?: '—' ?></span></p>

  <hr>

  <a href="form.html">← Back to Form</a>

</body>
</html>
 -->

 