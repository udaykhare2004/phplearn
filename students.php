<?php
$conn = mysqli_connect("localhost", "root", "", "phplearn");
if (!$conn) die("Connection failed: " . mysqli_connect_error());


$result = mysqli_query($conn, "SELECT * FROM students");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>All Students</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 40px auto; padding: 0 16px; }
    h2 { margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 10px; border: 1px solid #ddd; font-size: 14px; text-align: left; }
    th { background: #f5f5f5; }
    a { color: #007bff; text-decoration: none; margin-right: 8px; }
    a:hover { text-decoration: underline; }
    .actions { white-space: nowrap; }
  </style>
</head>
<body>

  <h2>All Students</h2>
  <a href="form.html">+ Add New Student</a>
  <br><br>

  <table>
    <tr>
      <th>ID</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Actions</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['first_name']) ?></td>
      <td><?= htmlspecialchars($row['last_name']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= htmlspecialchars($row['phone']) ?: '—' ?></td>
      <td class="actions">
        <a href="view.php?id=<?= $row['id'] ?>">View</a>
        <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
      </td>
    </tr>
    <?php endwhile; ?>

  </table>

</body>
</html>
<?php mysqli_close($conn); ?>