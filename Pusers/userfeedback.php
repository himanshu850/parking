<?php  include('../config.php'); ?>
<?php if (!isLoggedIn()) {
		$_SESSION['msg'] = "You must log in first";
		header('location:../login.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Averia+Serif+Libre|Noto+Serif|Tangerine" rel="stylesheet">
<!-- Font awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<!-- ckeditor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.8.0/ckeditor.js"></script>
<!-- Styling for public area -->
<link rel="stylesheet" href="../static/css/user_styling.css">
	<title>User Feedback</title>
</head>
<body>
	<?php include(ROOT_PATH . '/Pusers/includes/navbar.php') ?>
<div class="container content">
		<!-- Left side menu -->
		<?php include(ROOT_PATH . '/Pusers/includes/menu.php') ?>
<form method="POST">
<?php include(ROOT_PATH . '../includes/messages.php') ?>
	<select id="country" name="Day">
		<option value="" selected disabled>Day Of the Week</option>
      <option value="Monday">Monday</option>
      <option value="Tuesday">Tuesday</option>
      <option value="Wednesday">Wednesday</option>
      <option value="Thursday">Thursday</option>
      <option value="Friday">Friday</option>
      <option value="sarturday">sarturday</option>
    </select>
    <select id="country" name="Department">
		<option value="" selected disabled>Department</option>
      <option value="Lecturer">Lecturer</option>
      <option value="student">Student</option>
      <option value="Staff">Staff</option>
    </select>

    <label for="subject">Feedback</label>
    <textarea id="subject" name="subject" placeholder="Write Your Feedback.." style="height:200px"></textarea>

    <input type="submit" value="Submit" name="submit">

  </form>
</div>
<?php
error_reporting( error_reporting() & ~E_NOTICE );
$submit = $_POST['submit'];
if (isset($submit)) {
	$msg = $_POST['subject'];
	$dept=$_POST['Department'];
	$day=$_POST['Day'];
	$conn = mysqli_connect("localhost", "root", "", "parking");

	if (!$conn) {
		die("Error connecting to database: " . mysqli_connect_error());
	}

	$sql = "INSERT INTO feedback(Day,Department,Message,Submitted_at) VALUES('$day','$dept','$msg',now())";
	if ($conn->query($sql)) {
		$_SESSION['message'] = "Your Feedback has Successfully been Submitted";
		
	}
	else{
		echo $conn->error;
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

 ?>




</body>
</html>
