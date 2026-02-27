<?php

session_start();

	// connect to database
	$db = mysqli_connect('localhost', 'root', '', 'parking');
	// variable declaration
	$username = "";
	$email    = "";
	$errors   = array();


	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header("location: ../login.php");
	}

	 // REGISTER USER
  if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $username = e($_POST['username']);
    $email = e($_POST['email']);
    $password_1 = e($_POST['password_1']);
    $password_2 = e($_POST['password_2']);

    // form validation: ensure that the form is correctly filled
    if (empty($username)) {  array_push($errors, "Uhmm...We gonna need your username"); }
    if (empty($email)) { array_push($errors, "Oops.. Email is missing"); }
    if (empty($password_1)) { array_push($errors, "uh-oh you forgot the password"); }
    if ($password_1 != $password_2) { array_push($errors, "The two passwords do not match");}

    // Ensure that no user is registered twice.
    // the email and usernames should be unique
    $user_check_query = "SELECT * FROM users WHERE username='$username'
                OR email='$email' LIMIT 1";

    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
      if ($user['username'] === $username) {
        array_push($errors, "Username already exists");
      }
      if ($user['email'] === $email) {
        array_push($errors, "Email already exists");
      }
    }
    // register user if there are no errors in the form
    if (count($errors) == 0) {
			$_SESSION['pwd']=$password_1;
      $password = md5($password_1);//encrypt the password before saving in the database
      $query = "INSERT INTO users (username, email,role, password, created_at, updated_at)
            VALUES('$username', '$email','parkinguser','$password', now(), now())";
      mysqli_query($db, $query);

      // get id of created user
      $reg_user_id = mysqli_insert_id($db);
$_SESSION['ID'] =$reg_user_id ;
$_SESSION['username']= $username;
      	// Get user info from user id
  function getUserById($id)
  {
    global $db;
    $sql = "SELECT * FROM users WHERE id=$id LIMIT 1";

    $result = mysqli_query($db, $sql);
    $user = mysqli_fetch_assoc($result);

    // returns user in an array format:
    // ['id'=>1 'username' => 'Ken', 'email'=>'Kenwaita@gmail.com', 'password'=> 'mypass']

    return $user;

  }

      // put logged in user into session array
      $_SESSION['user'] = getUserById($reg_user_id);

      // if user is admin, redirect to admin area
      if ( in_array($_SESSION['user']['role'], ["Admin"])) {
        $_SESSION['message'] = "You are now Registered Successfully";
        // redirect to admin area
        header('location: ' . BASE_URL . 'admin/dashboard.php');
        exit(0);
      }else if ( in_array($_SESSION['user']['role'], ["Guard"])) {
        $_SESSION['message'] = "You are now Registered Successfully";
        // redirect to admin area
        header('location: ' . BASE_URL . 'admin/dashboard.php');
        exit(0);

     } else {
        $_SESSION['message'] = "You are now Registered Successfully";
        // redirect to public area

        header('location: login.php');
        exit(0);
      }
    }
  }
// call the login() function if register_btn is clicked
	if (isset($_POST['login_btn'])) {
		login();
	}
	// LOGIN USER
	function login(){
		global $db, $username, $errors;

		// grap form values
		$username = e($_POST['username']);
		$password = e($_POST['password']);

		// make sure form is filled properly
		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		// attempt login if no errors on form
		// attempt login if no errors on form
		if (count($errors) == 0) {
			$password = md5($password);

			$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) { // user found
				// check if user is admin or user
				$logged_in_user = mysqli_fetch_assoc($results);
				if ($logged_in_user['role'] == 'Admin') {

					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "You are successfully logged in as Admin";
					header('location: admin/dashboard.php');		  
				}
				else if ($logged_in_user['role'] == 'parkinguser') {

					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "You are Successfully logged in";
					header('location: Pusers/user.php');
				}else{
					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "You are now Successfully logged in";

					header('location: Guard/index.php');
				}
			}else {
				array_push($errors, "Wrong username/password combination");
			}
		}
	}

	function isLoggedIn()
	{
		if (isset($_SESSION['user'])) {
			return true;
		}else{
			return false;
		}
	}

	function isAdmin()
	{
		if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'Admin' ) {
			return true;
		}else{
			return false;
		}
	}

	// escape string
	function e($val){
		global $db;
		return mysqli_real_escape_string($db, trim($val));
	}

	function display_error() {
		global $errors;

		if (count($errors) > 0){
			echo '<div class="error">';
				foreach ($errors as $error){
					echo $error .'<br>';
				}
			echo '</div>';
		}

	}

?>
