<?php
// Database connection
$servername = "localhost";
$username = "root"; // default
$password = "";     // default
$dbname = "registrationDB";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Delete User ---
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: dashboard.php");
    exit;
}

// --- Filters ---
$search = $_GET['search'] ?? '';
$program = $_GET['program'] ?? '';
$college = $_GET['college'] ?? '';
$gender = $_GET['gender'] ?? '';

$query = "SELECT * FROM users WHERE 1";

// Apply filters
if ($search != '') {
    $query .= " AND (username LIKE '%$search%' OR email LIKE '%$search%')";
}
if ($program != '') {
    $query .= " AND programs='$program'";
}
if ($college != '') {
    $query .= " AND college='$college'";
}
if ($gender != '') {
    $query .= " AND gender='$gender'";
}

$query .= " ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Registered Users</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f7f7f7; padding: 30px; }
    h2 { text-align: center; margin-bottom: 20px; color: #333; }
    form.filters { margin-bottom: 20px; display: flex; gap: 15px; justify-content: center; }
    input, select { padding: 6px; border: 1px solid #ccc; border-radius: 4px; }
    table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0px 2px 8px rgba(0,0,0,0.1); }
    th, td { padding: 10px; text-align: center; border-bottom: 1px solid #ddd; }
    th { background: #530ddee4; color: white; }
    tr:hover { background: #f1f1f1; }
    img { max-width: 50px; border-radius: 6px; }
    .actions a { padding: 5px 10px; text-decoration: none; border-radius: 4px; margin: 2px; }
    .edit { background: #28a745; color: white; }
    .delete { background: #dc3545; color: white; }
  </style>
</head>
<body>

  <h2>📋 Registered Users</h2>

  <!-- Filters -->
  <form method="GET" class="filters">
    <input type="text" name="search" placeholder="Search by name/email" value="<?= htmlspecialchars($search) ?>">
    <select name="program">
      <option value="">All Programs</option>
      <option value="BCom" <?= $program=='BCom'?'selected':'' ?>>B.Com</option>
      <option value="BBA" <?= $program=='BBA'?'selected':'' ?>>BBA</option>
      <option value="BCA" <?= $program=='BCA'?'selected':'' ?>>BCA</option>
      <option value="MCA" <?= $program=='MCA'?'selected':'' ?>>MCA</option>
    </select>
    <select name="college">
      <option value="">All Colleges</option>
      <option value="Oxford" <?= $college=='Oxford'?'selected':'' ?>>Oxford</option>
      <option value="Christ" <?= $college=='Christ'?'selected':'' ?>>Christ</option>
      <option value="PES" <?= $college=='PES'?'selected':'' ?>>PES</option>
    </select>
    <select name="gender">
      <option value="">All Genders</option>
      <option value="Male" <?= $gender=='Male'?'selected':'' ?>>Male</option>
      <option value="Female" <?= $gender=='Female'?'selected':'' ?>>Female</option>
    </select>
    <button type="submit">Filter</button>
  </form>

  <!-- Users Table -->
  <table>
    <tr>
      <th>ID</th><th>Username</th><th>Email</th><th>DOB</th><th>College</th>
      <th>Gender</th><th>Programs</th><th>Start</th><th>End</th><th>Profile</th><th>Actions</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['dob']}</td>
                    <td>{$row['college']}</td>
                    <td>{$row['gender']}</td>
                    <td>{$row['programs']}</td>
                    <td>{$row['startTime']}</td>
                    <td>{$row['endTime']}</td>
                    <td><img src='uploads/{$row['fileName']}' alt=''></td>
                    <td class='actions'>
                      <a href='edit.php?id={$row['id']}' class='edit'>Edit</a>
                      <a href='dashboard.php?delete={$row['id']}' class='delete' onclick=\"return confirm('Delete this user?')\">Delete</a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='11'>No users found.</td></tr>";
    }
    ?>
  </table>

</body>
</html>

<?php $conn->close(); ?>
