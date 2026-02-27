<?php
$conn = mysqli_connect("localhost", "root", "", "parking");

// Validate incoming POST data
if (!isset($_POST['id'], $_POST['unm'], $_POST['slot'])) {
    header('Location: booking.php?error=invalid_input');
    exit();
}

$uid = intval($_POST['id']);
$unm = mysqli_real_escape_string($conn, $_POST['unm']);
$slot = intval($_POST['slot']);

// check whether the slot already has a booking (bookings.slot has UNIQUE constraint)
$check = $conn->prepare("SELECT ID FROM bookings WHERE slot = ? LIMIT 1");
$check->bind_param('i', $slot);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    // slot already booked
    header('Location: booking.php?error=slot_taken');
    exit();
}
$check->close();

// check whether the user already has a booking (bookings.useri has UNIQUE constraint)
$checkUser = $conn->prepare("SELECT ID FROM bookings WHERE useri = ? LIMIT 1");
$checkUser->bind_param('i', $uid);
$checkUser->execute();
$checkUser->store_result();
if ($checkUser->num_rows > 0) {
    // user already has a booking
    header('Location: booking.php?error=user_has_booking');
    exit();
}
$checkUser->close();

// insert booking using prepared statement
$stmt = $conn->prepare("INSERT INTO bookings (useri, usern, slot, start) VALUES (?, ?, ?, now())");
if (!$stmt) {
    header('Location: booking.php?error=db_prepare');
    exit();
}
$stmt->bind_param('isi', $uid, $unm, $slot);
if ($stmt->execute()) {
    // mark slot as booked
    $upd = $conn->prepare("UPDATE parking_slot SET Status='Booked' WHERE SlotID = ?");
    if ($upd) {
        $upd->bind_param('i', $slot);
        $upd->execute();
        $upd->close();
    }
    $stmt->close();
    header("Location: booking.php?state=success");
    exit();
} else {
    // insertion failed (race condition or DB error)
    $stmt->close();
    header('Location: booking.php?error=booking_failed');
    exit();
}

?>