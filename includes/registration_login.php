<?php 
  // variable declaration
  $username = "";
  $email    = "";
  $errors = array(); 

  // REGISTER USER
  if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $username = esc($_POST['username']);
    $email = esc($_POST['email']);
    $role = esc($_POST['role']);
    $password_1 = esc($_POST['password_1']);
    $password_2 = esc($_POST['password_2']);

    // form validation: ensure that the form is correctly filled
    if (empty($username)) {  array_push($errors, "Uhmm...We gonna need your username"); }
    if (empty($email)) { array_push($errors, "Oops.. Email is missing"); }
    if (empty($password_1)) { array_push($errors, "uh-oh you forgot the password"); }
    if ($password_1 != $password_2) { array_push($errors, "The two passwords do not match");}

    // Ensure that no user is registered twice. 
    // the email and usernames should be unique
    $user_check_query = "SELECT * FROM users WHERE username='$username' 
                OR email='$email' LIMIT 1";

    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
      if ($user['username'] === $username) {
        array_push($errors, "Username already exists");
      }
      if ($user['email'] === $email) {
        array_push($errors, "Email already exists");
      }
    }
    // register user if there are no errors in the form
    if (count($errors) == 0) {
      $password = md5($password_1);//encrypt the password before saving in the database
      $query = "INSERT INTO users (username, email,role, password, created_at, updated_at) 
            VALUES('$username', '$email','$role','$password', now(), now())";
      mysqli_query($conn, $query);

      // get id of created user
      $reg_user_id = mysqli_insert_id($conn); 

      // put logged in user into session array
      $_SESSION['user'] = getUserById($reg_user_id);

      // if user is admin, redirect to admin area
      if ( in_array($_SESSION['user']['role'], ["Admin"])) {
        $_SESSION['message'] = "You are now Registered Successfully";
        // redirect to admin area
        header('location: ' . BASE_URL . 'admin/dashboard.php');
        exit(0);
      } else {
        $_SESSION['message'] = "You are now Registered Successfully";
        // redirect to public area
        header('location: index.php');        
        exit(0);
      }
    }
  }

  // LOG USER IN
  if (isset($_POST['login_btn'])) {
    $username = esc($_POST['username']);
    $password = esc($_POST['password']);

    if (empty($username)) { array_push($errors, "Username required"); }
    if (empty($password)) { array_push($errors, "Password required"); }
    if (empty($errors)) {
      $password = md5($password); // encrypt password
      $sql = "SELECT * FROM users WHERE username='$username' and password='$password' LIMIT 1";
      $result = $conn->query($sql);

      $res = null;
      if ($result && $result->num_rows > 0) {
        $rec = $result->fetch_assoc();
        // support both `id` and `userID` column names
        if (isset($rec['id'])) {
          $res = $rec['id'];
        } elseif (isset($rec['userID'])) {
          $res = $rec['userID'];
        }
        $_SESSION['role'] = isset($rec['role']) ? $rec['role'] : null;
      }

      if ($res !== null) {
        // get id of created user
        $reg_user_id = $res;

        // put logged in user into session array
        $_SESSION['user'] = getUserById($reg_user_id);

        // if user is admin, redirect to admin area
        if ($_SESSION['role']=="Admin") {
          $_SESSION['role']="Admin";
          $_SESSION['message'] = "You are now logged in";
          // redirect to admin area
          header('location: ' . BASE_URL . '/admin/dashboard.php');
          exit(0);
        } else {
          $_SESSION['message'] = "You are now logged in";
          // redirect to public area
          $_SESSION['username']="parkinguser";
          header('location: index.php');        
          exit(0);
        }
      } else {
        array_push($errors, 'Wrong credentials');
      }
    }
  }
  // escape value from form
  function esc(String $value)
  { 
    // bring the global db connect object into function
    global $conn;

    $val = trim($value); // remove empty space surrounding string
    $val = mysqli_real_escape_string($conn, $val);

    return $val;
  }
  // Get user info from user id
  function getUserById($id)
  {
    global $conn;
    // Detect which primary key column exists and query it safely
    $columns = [];
    $cols_res = mysqli_query($conn, "SHOW COLUMNS FROM users");
    if ($cols_res) {
      while ($c = mysqli_fetch_assoc($cols_res)) {
        $columns[] = $c['Field'];
      }
    }

    if (in_array('userID', $columns)) {
      $pk = 'userID';
    } elseif (in_array('id', $columns)) {
      $pk = 'id';
    } else {
      // unknown schema
      return null;
    }

    $id_int = intval($id);
    $sql = "SELECT * FROM users WHERE `$pk` = $id_int LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $user = $result ? mysqli_fetch_assoc($result) : null;

    // returns user in an array format: 
    // ['id'=>1 'username' => 'Ken', 'email'=>'Kenwaita@gmail.com', 'password'=> 'mypass']
    return $user; 
  }
?>