<?php
/**
 * Require Database Connection File
 */
require "../database/config.php";

/**
 * Require Middleware File
 */
require "../database/middleware.php";

/**
 * Require Header File
 */
require "../layouts/header/header.php"; 

/**
 * Require Navigation bar File
 */
require "../layouts/navbar/navbar.php"; 

?>
<body>
<div class="container" style="margin-top: 50px;">
  <h2>Registration form</h2>
  <form class="form-horizontal" method="post" action="register.php">
  <div class="error"> 
    <strong>Please Create an account <?php echo display_error(); ?></strong>
 </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="reg">Registration:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="reg" placeholder="Enter Car Registration" name="reg" value="<?php echo $reg; ?>">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="make">Make:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="make" placeholder="Enter Make" name="make" value="<?php echo $make; ?>" >
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="model">Model:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="model" placeholder="Enter Model" name="model" value="<?php echo $model; ?>">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="year">Year:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="year" placeholder="Enter Year" name="year" value="<?php echo $year; ?>">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="username">Username:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" value="<?php echo $username; ?>">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Email:</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo $email; ?>">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">Password:</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" id="pwd" placeholder="Enter password_1" name="password_1">
      </div>
	</div>
	<div class="form-group">
      <label class="control-label col-sm-2" for="pwd">Confirm Password:</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" id="pwd" placeholder="Enter password_2" name="password_2">
      </div>
    </div>
    <!--<div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <div class="checkbox">
          <label><input type="checkbox" name="remember"> Remember me</label>
        </div>
      </div>
    </div>-->
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default" name="register_btn">Submit</button>
      </div>
    </div>
    <p>
        Already a member? <a href="login.php">Sign in</a>
    </p>
  </form>
</div>
<?php

/**
 * Require Footer File
 */
require "../layouts/footer/footer.php";

?>