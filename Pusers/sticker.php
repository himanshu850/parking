<?php
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
  $sql = "INSERT INTO sticker (sMode,userNo, name, Address, vehicleNo,vehicleColor,vehicleModel,Department,Validity,Disabled)
                          VALUES( '$study','$userNo','$name','$Address','$vNo','$vColor','$Model', '$dept','$valid','$state')";

    $conn = mysqli_connect("localhost", "root", "", "parking");
    if ($conn->query($sql)) {
      $_SESSION['message'] = "You have Successfully secured a parking Sticker; Book a Parking slot";
      header('location: booking.php');
      // code...
    }
    else {
      echo $conn->error;
    }




 ?>
