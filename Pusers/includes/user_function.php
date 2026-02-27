<?php

	// variable declaration
	$userNo = "";
  $vehicleNo = "";
  $vehicleColor = "";
  $vehicleModel= "";
	$errors   = array();

	 // SAVE DATA
  if (isset($_POST['create_btn'])) {
    // receive all input values from the form
    $study = $_POST['sMode'];

    $userNo = $_POST['userNo'];

    $name = $_POST['name'];

    $Address= $_POST['Address'];

    $vNo = $_POST['vehicleNo'];

    $vColor = $_POST['vehicleColor'];

    $Model = $_POST['vehicleModel'];

    $dept= $_POST['Department'];

    $valid= $_POST['Validity'];

    $state= $_POST['Disabled'];


    // form validation: ensure that the form is correctly filled
    if (empty($study)) {  array_push($errors, "Input your study Mode"); }
    if (empty($userNo)) { array_push($errors, "Oops.. UserNo missing"); }
    if (empty($name)) { array_push($errors, "uh-oh you forgot to input your name"); }
    if (empty($Address)) { array_push($errors, "uh-oh you forgot to input your Telephone"); }
    if (empty($vNo)) { array_push($errors, "input Vehicle Number"); }
    if (empty($vColor)) { array_push($errors, "Input vehicle Number"); }
    if (empty($Model)) { array_push($errors, "input vehicle Model"); }
    if (empty($valid)) { array_push($errors, "Input the validity of the sticker"); }
    if (empty($state)) { array_push($errors, "Select one of the status"); }
    // Ensure that no user is registered twice.
    // the email and usernames should be unique
    $user_check_query = "SELECT * FROM sticker WHERE userNo='$userNo' LIMIT 1";
			$conn = mysqli_connect("localhost", "root", "", "parking");
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);

 // if user exists
      if ($user['userNo'] === $userNo) {
        array_push($errors, "You already booked  a  sticker");
      }

    // register user if there are no errors in the form
    if (count($errors) == 0) {
      $query = "INSERT INTO sticker (userID, sMode,userNo, name, Address, vehicleNo,vehicleColor,vehicleModel,Department,Validity,Disabled)
                              VALUES( '$userNo','$study','$userNo','$name','$Address','$vNo','$vColor','$Model','$valid','$state')";
      if ($conn->query($query)) {
      	echo "DONE WOOOOOOOOHO";
      }else {
      	echo $conn->error;
      }

      // get id of created user
      $userNo = mysqli_insert_id($db);
      	// Get user info from user id
  function getUserById($id)
  {
    global $db;
    $sql = "SELECT * FROM sticker WHERE id=$id LIMIT 1";

    $result = mysqli_query($db, $sql);
    $user = mysqli_fetch_assoc($result);

    // returns user in an array format:
    // ['id'=>1 'username' => 'Ken', 'email'=>'Kenwaita@gmail.com', 'password'=> 'mypass']
    return $user;
  }

      // put logged in user into session array
      $_SESSION['user'] = getUserById($reg_user_id);

 $_SESSION['message'] = "You are now Registered Successfully";

        header('location: user.php');
        exit(0);
      }
    }
    // escape string
  function e($val){
    global $db;
    return mysqli_real_escape_string($db, trim($val));
  }
  function isLoggedIn()
  {
    if (isset($_SESSION['user'])) {
      return true;
    }else{
      return false;
    }
  }
  ?>
