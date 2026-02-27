<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php');

	if (!isLoggedIn()) {
		$_SESSION['msg'] = "You must log in first";
		header('location:../login.php');
	} ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>

<!-- Get all admin posts from DB -->
<?php function getAllSlots()
{
	global $conn;

	// Admin can view all slots
	//Guard can view all added
	if ($_SESSION['user']['role'] == "Admin") {
		$sql = "SELECT * FROM parking_slot  GROUP BY LocationID";
	} else  {
		$user_id = ($_SESSION['user']['id']);
		$sql = "SELECT * FROM parking_slot  GROUP BY LocationID";
	}
	$result = $conn->query($sql);
	$post=true;
	return $post;
}?>
	<title>Admin | Manage Parkings</title>
	<style media="screen">
		.ed{
			width: 30px;
			float: left;
		}
		.fl{
			width: 80px;
		}
	</style>
</head>
<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>

	<div class="container content">
		<!-- Left side menu -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

		<!-- Display records from DB-->
		<div class="table-div"  style="width: 80%;">
			<!-- Display notification message -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>

			<?php
			if (!empty($_GET['edit-pos'])) {
				$rr = $_GET['edit-pos'];
			$sql3 = "UPDATE `parking_slot` SET `Status`='Reserved' WHERE SlotID ='$rr' ";

			$conn->query($sql3);
			}
			if (!empty($_GET['free-pos'])) {
				$rr = $_GET['free-pos'];
			$sql3 = "UPDATE `parking_slot` SET `Status`='Free' WHERE SlotID ='$rr' ";

			$conn->query($sql3);
			}


				if (!empty($_GET['delete-pos'])) {
					$rr = $_GET['delete-pos'];
				$sql3 = "DELETE FROM `parking_slot` WHERE SlotID='$rr' ";

				$conn->query($sql3);
				}


				$sql2 = "SELECT * FROM parking_slot ORDER BY LocationID";

				$result = $conn->query($sql2);
				if ($result) {
					$rec = $result->fetch_assoc();
					$l=0;
				  while($rec = $result->fetch_assoc()) {
       			 $slotid[$l]= $rec['SlotID'];
       			 $LocationID[$l]= $rec['LocationID'];
       			 $Status[$l]= $rec['Status'];
       			 $l= $l+1;
    	 			}
    	 			$results = mysqli_query($conn, $sql2);
    	 		$posts = mysqli_fetch_all($results, MYSQLI_ASSOC);
function getPostAuthorById($user_id)
{
	global $conn;
	if (empty($user_id)) return null;
	// detect users primary key column
	$cols_res = mysqli_query($conn, "SHOW COLUMNS FROM users");
	$pk = null;
	if ($cols_res) {
		while ($c = mysqli_fetch_assoc($cols_res)) {
			if ($c['Field'] === 'userID') { $pk = 'userID'; break; }
			if ($c['Field'] === 'id') { $pk = 'id'; break; }
		}
	}
	if (!$pk) return null;
	$user_id_int = intval($user_id);
	$sql = "SELECT username FROM users WHERE `$pk` = $user_id_int LIMIT 1";
	$result = mysqli_query($conn, $sql);
	if ($result && mysqli_num_rows($result) > 0) {
		return mysqli_fetch_assoc($result)['username'];
	}
	return null;
}
	$final_posts = array();
	foreach ($posts as $post) {
		// try to find a user id field in the post row; parking_slot doesn't include a user id by default
		$possible_keys = ['userID','userId','useri','user','GuardID','guard_id'];
		$uid = null;
		foreach ($possible_keys as $k) {
			if (isset($post[$k]) && !empty($post[$k])) { $uid = $post[$k]; break; }
		}
		$post['Guard'] = $uid ? getPostAuthorById($uid) : null;
		array_push($final_posts, $post);
	}
}
else{
	echo $conn->error;
}

			 if ($posts!=true): ?>
				<h1 style="text-align: center; margin-top: 20px;">No slots in the database.</h1>
			<?php else: ?>
				<table class="table">
						<thead>
						<th>id</th>
						<th>Location</th>
						<th>Status</th>

						<th><small>Edit</small></th>
						<th><small>Delete</small></th>
					</thead>
					<tbody>
					<?php foreach ($final_posts as $key => $post): ?>
						<tr>
							<!-- $key=$key-1; -->
							<td><?php $key=$key-1;
								if ($key<0) {
									$key=0;
								}
							echo $slotid[$key]; ?></td>
							<td><?php
									$sql3 = "SELECT * FROM location WHERE LocationID ='$LocationID[$key]'";
									$result3 = $conn->query($sql3);
									if ($result3) {
										 while($rec = $result3->fetch_assoc()) {
					       			 $Location = $rec['LocationName'];

					    	 			}

					    	 		}
					    	 		else{
					    	 			echo $conn->error;
					    	 		}

							echo $Location; ?></td>
							<td>
								<?php
								// Safely build a link if a slug exists for this post; otherwise show status as plain text
								$slug = isset($post['slug']) && !empty($post['slug']) ? urlencode($post['slug']) : '';
								$status_label = htmlspecialchars($Status[$key] ?? '', ENT_QUOTES, 'UTF-8');
								if ($slug !== ''):
									$href = htmlspecialchars(BASE_URL . 'single_post.php?post-slug=' . $slug, ENT_QUOTES, 'UTF-8');
									echo "<a target=\"_blank\" href=\"{$href}\">{$status_label}</a>";
								else:
									echo $status_label;
								endif;
								?>
							</td>


								<td class="fl">
								<a class=" ed fa fa-pencil btn edit"
									href="slots.php?free-pos=<?php echo $slotid[$key]; ?>">F
								</a>
								<a class=" ed fa fa-pencil btn edit"
									href="slots.php?edit-pos=<?php echo $slotid[$key]; ?>">R
								</a>
							</td>


							<td>
								<a  class="fa fa-trash btn delete"
									href="slots.php?delete-pos=<?php echo $slotid[$key];?>">

								</a>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			<?php endif  ?>
		</div>
		<!-- // Display records from DB -->
	</div>
</body>
</html>
