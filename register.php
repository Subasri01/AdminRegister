<?php
$message = isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Account</title>
 
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/register.css">
  
</head>
<body>
  <div class="register-box">
    <h2><i class="bi bi-person-plus-fill"></i>  Create Account</h2>

    <?php if ($message): ?>
      <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <form action="process_register.php" method="POST" onsubmit="return validateForm();">
      <div class="input-wrapper">
        <i class="bi bi-person-fill icon-left"></i>
        <input  type="text"  name="name" id="name" placeholder="Name" required>
        
      </div>

      <div class="input-wrapper">
        <i class="bi bi-envelope-fill icon-left"></i>
        <input type="email" name="email" id="email" placeholder="Email Address" required>
      </div>

      <div class="input-wrapper">
        <i class="bi bi-telephone-fill icon-left"></i>
        <input type="text" name="phone" id="phone" placeholder="Phone Number" required>
      </div>

      <div class="input-wrapper">
        <i class="bi bi-calendar-fill icon-left"></i>
        <input type="number" name="age" id="age" placeholder="Age" required>
      </div>

      <div class="input-wrapper">
        <i class="bi bi-gender-ambiguous icon-left"></i>
        <select name="gender" id="gender" required>
          <option value="" disabled selected>Select Gender</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
      </div>

      <div class="input-wrapper">
        <i class="bi bi-lock-fill icon-left"></i>
        <input type="password" name="password" id="password" placeholder="Password" required>
      </div>

      <button  onClick="validateForm()" type="submit"><i class="bi bi-box-arrow-in-right"></i> Register</button>
    </form>
  </div>

  <script src="./script/register.js"></script>
    
</body>
</html>
