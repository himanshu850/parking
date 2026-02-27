<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); 

	if (!isLoggedIn()) {
		$_SESSION['msg'] = "You must log in first";
		header('location:../login.php');
	}?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>View feedback</title>
</head>
<body>
<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>
<div class="container content">
<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>
<center><h1>User Feedback<h1></center>
	<table class="table">
						<thead>
						<th>FeedbackID</th>
						<th>Department Of User</th>
						<th>Feedback Message </th>
						<th>Day Submitted</th>
						<th>Date</th>
</thead>
<tbody>
<?php
 
	$sql3 = "SELECT * FROM feedback ";
	$result3 = $conn->query($sql3);
	if ($result3) {
		 while($rec = $result3->fetch_assoc()) {
			 
				$FeedbackID= $rec['id'];
				 $Department=$rec['Department'];
				 $Message=$rec['Message'];
				 $Day=$rec['Day'];
				 $time=$rec['Submitted_at'];
		echo "
				 <tr>
				 <td>$FeedbackID</td>
				 <td>$Department</td>
				 <td>$Message</td>
				 <td>$Day</td>
				 <td>$time</td>
			 </tr>

				 ";
			}

		}
		else{
			echo $conn->error;
		}

		?>
		
	</tbody>	
</table>
</div>

</body>
</html>