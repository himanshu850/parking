<?php 
/* * * * * * * * * * * * * * *
* Returns all available locations
* * * * * * * * * * * * * * */
function getAvailableLocation() {
	// use global $conn object in function
	global $conn;
	$sql = "SELECT * FROM location WHERE status=Free";
	$result = mysqli_query($conn, $sql);

	// fetch all location as an associative array called $location
	$location = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $location;
}

// more functions to come here ...
?>