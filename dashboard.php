<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_email']) && !isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['delete']) && isset($_SESSION['admin_logged_in'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: dashboard.php");
    exit();
}


if (isset($_POST['update']) && isset($_SESSION['admin_logged_in'])) {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $age = trim($_POST['age']);
    $password = trim($_POST['password']);
    $gender = $_POST['gender'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, phone = ?, age = ?, password = ?, gender = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $name, $email, $phone, $age, $password, $gender, $id);
    $stmt->execute();
    header("Location: dashboard.php");
    exit();
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$stmt = $conn->prepare("SELECT * FROM users WHERE name LIKE ? ORDER BY id DESC");
$search_param = "%$search%";
$stmt->bind_param("s", $search_param);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"> <
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="./css/dashboard.css">
</head>
<body>

  <div class="topbar">
    <h2>Admin Dashboard</h2>
    <div class="topbar-right">
      <span>Welcome, <?php echo isset($_SESSION['admin_logged_in']) ? 'Admin' : $_SESSION['user_email']; ?></span>
      <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
    </div>
  </div>

  <div class="sidebar">
    
<div class="sidebar">
  <h3>Admin Panel</h3>
  <ul class="list">
    <li> <i class="bi bi-laptop"></i> Dashboard</li>
    <li> <i class="bi bi-person-circle"></i> Users</li>
    <li> <i class="bi bi-bookmark-check"></i> Reports</li>
    <li> <i class="bi bi-gear"></i> Settings</li>
    <li> <i class="bi bi-bell-slash"></i> Notify</li>
    <li> <i class="bi bi-person-check"></i>  Profile</li>
  </ul>

</div>
  </div>

  <div class="content">
    <div class="cards">
      <div class="card">Total Users: <?php echo $result->num_rows; ?></div>
      <div class="card"> Pass Manage</div>
      <div class="card">Mail Manage</div>
      <div class="card">Super Admin</div>
    </div>

    <form class="search-container" method="GET" action="">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M21.53 20.47l-5.388-5.388a7.5 7.5 0 1 0-1.06 1.06l5.388 5.388a.75.75 0 0 0 1.06-1.06ZM10.5 17a6.5 6.5 0 1 1 0-13 6.5 6.5 0 0 1 0 13Z"/>
      </svg>
      <input type="text" name="search" placeholder="Search by name..." value="<?php ($search); ?>" />
    </form>

    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Password</th>
          <th>Age</th>
          <th>Phone</th>
          <th>Gender</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
       <?php
  $result = $conn->query("SELECT * FROM users");

if ($result->num_rows > 0):
    while ($row = $result->fetch_assoc()):
?>
<tr>
  <form method="POST">
    <td>
      <span class="text"><?php echo ($row['name']); ?></span>
      <input class="edit-input" type="text" name="name" value="<?php echo ($row['name']); ?>" style="display:none;" />
    </td>
    <td>
      <span class="text"><?php echo ($row['email']); ?></span>
      <input class="edit-input" type="email" name="email" value="<?php echo ($row['email']); ?>" style="display:none;" />
    </td>
    <td>
      <span class="text"><?php echo ($row['password']); ?></span>
      <input class="edit-input" type="password" name="password" value="<?php echo ($row['password']); ?>" style="display:none;" />
    </td>
    <td>
      <span class="text"><?php echo ($row['age']); ?></span>
      <input class="edit-input" type="text" name="age" value="<?php echo ($row['age']); ?>" style="display:none;" />
    </td>
    <td>
      <span class="text"><?php echo ($row['phone']); ?></span>
      <input class="edit-input" type="text" name="phone" value="<?php echo ($row['phone']); ?>" style="display:none;" />
    </td>
    <td>
      <span class="text"><?php echo ($row['gender']); ?></span>
      <select class="edit-input" name="gender" style="display:none;">
        <option value="Male" <?php echo $row['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
        <option value="Female" <?php echo $row['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
      </select>
    </td>
    <td>
      <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
      <?php if (isset($_SESSION['admin_logged_in'])): ?>
        <button type="button" class="btn edit" onclick="enableEdit(this)">Edit</button>
        <button type="submit" name="update" class="btn update" style="display:none;">Update</button>
        <a href="?delete=<?php echo $row['id']; ?>" class="btn delete" onclick="return confirm('Delete this user?')">Delete</a>
      <?php endif; ?>
    </td>
  </form>
</tr>
<?php
    endwhile;
else:
?>
<tr>
  <td colspan="7" class="mute">No actions available</td>
</tr>
<?php endif; ?>

      </tbody>
    </table>
  </div>

  <script src="./script/dashboard.js"> </script>
</body>
</html>
