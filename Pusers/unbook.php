<?php
include('../function.php');

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location:../login.php');
    exit();
}

if (!isset($_GET['slot_id'])) {
    $_SESSION['message'] = 'Invalid request';
    header('Location: viewbookings.php');
    exit();
}

$slot_id = intval($_GET['slot_id']);
// determine user id from session
$uid = null;
if (isset($_SESSION['user']['userID'])) $uid = intval($_SESSION['user']['userID']);
elseif (isset($_SESSION['user']['id'])) $uid = intval($_SESSION['user']['id']);
elseif (isset($_SESSION['user']['UserID'])) $uid = intval($_SESSION['user']['UserID']);

if (empty($uid)) {
    $_SESSION['message'] = 'Not authorized';
    header('Location: viewbookings.php');
    exit();
}

// connect
$conn = mysqli_connect('localhost','root','','parking');
if (!$conn) {
    $_SESSION['message'] = 'Database connection error';
    header('Location: viewbookings.php');
    exit();
}

// verify booking belongs to this user
$stmt = $conn->prepare('SELECT ID FROM bookings WHERE slot = ? AND useri = ? LIMIT 1');
$stmt->bind_param('ii', $slot_id, $uid);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 0) {
    $stmt->close();
    $_SESSION['message'] = 'No booking found for this slot under your account';
    header('Location: viewbookings.php');
    exit();
}
$stmt->bind_result($booking_id);
$stmt->fetch();
$stmt->close();

// delete the booking
$del = $conn->prepare('DELETE FROM bookings WHERE ID = ?');
$del->bind_param('i', $booking_id);
$ok = $del->execute();
$del->close();

if ($ok) {
    // update slot status to Free
    $upd = $conn->prepare("UPDATE parking_slot SET Status='Free' WHERE SlotID = ?");
    if ($upd) {
        $upd->bind_param('i', $slot_id);
        $upd->execute();
        $upd->close();
    }
    $_SESSION['message'] = 'Booking cancelled successfully';
} else {
    $_SESSION['message'] = 'Failed to cancel booking';
}

header('Location: viewbookings.php');
exit();
?>