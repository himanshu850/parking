
<?php  include('function.php'); ?>
<?php  include('includes/head_section.php'); ?>
  <title>Strath Parking Booking | Sign in </title>
</head>
<body>
<div class="container">
  <!-- Navbar -->
  <?php include( 'includes/navbar.php'); ?>
  <!-- // Navbar -->

  <div style="width: 50%; margin: 30px auto;">
    <form method="post" action="login.php" >
      <h2>Login</h2>
      <?php include('includes/errors.php') ?>
	  <?php include('includes/messages.php') ?>
      <input type="text" name="username" value="<?php if(!empty($_SESSION['username'])){echo $_SESSION['username'];} ?>" placeholder="Username">
      <input type="password" name="password" value="<?php if(!empty($_SESSION['pwd'])){echo $_SESSION['pwd']; }?>" placeholder="Password">
      <button type="submit" class="btn" name="login_btn">Login</button>
      <p>
        Not yet a member? <a href="register.php">Sign up</a>
      </p>
    </form>
  </div>
</div>
<!-- // container -->

<!-- Footer -->
  <?php include( 'includes/footer.php'); ?>
<!-- // Footer -->
