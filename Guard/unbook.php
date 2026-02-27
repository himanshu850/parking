<?php
include "../config.php";
$Slot_id = $_GET['slot_id'];
$sql="UPDATE parking_slot SET Status='Free' WHERE SlotID=$Slot_id";



if(mysqli_query($conn,$sql)){
	header('location: index.php');
}

?>