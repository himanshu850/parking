<?php 
	$conn = mysqli_connect("localhost", "root", "", "parking");

	if (!$conn) {
		die("Error connecting to database: " . mysqli_connect_error());
	}

$locationName = $_POST['LocationID'];
$number = $_POST['number'];



$sql2 = "SELECT * FROM location WHERE LocationName='$locationName' LIMIT 1";
$result = $conn->query($sql2);
if ($result) {
	 while($row = $result->fetch_assoc()) {
        $locatinid= $row['LocationID'];
    }
}
else{
	echo $conn->error;
}
 
for ($i=0; $i < (int)$number; $i++) { 
	$sql = "INSERT INTO parking_slot (LocationID, Status) VALUES('$locatinid', 'Free')";
	if ($conn->query($sql)) {
		# code...
		echo "Done";
	}
	else{
		echo $conn->error;
	}
}
header("Location:slots.php");


 ?>