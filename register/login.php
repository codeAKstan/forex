<?php 
session_start();

if(isset($_POST['email']) && 
   isset($_POST['password'])){

    include "db_conn.php";

    $email = $_POST['email'];
    $password = $_POST['password'];

    $data = "email=".$email;
       // Validate email format
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $em = "Invalid email format";
         header("Location: ../x2/access/en.php?error=$em");
         exit;
     }
    
    if(empty($email)){
    	$em = "email is required";
    	header("Location: ../x2/access/en.php?error=$em&$data");
	    exit;
    }else if(empty($password)){
    	$em = "Password is required";
    	header("Location: ../x2/access/en.php?error=$em&$data");
	    exit;
    }else {

    	$sql = "SELECT * FROM users WHERE email = ?";
    	$stmt = $conn->prepare($sql);
    	$stmt->execute([$email]);

      if($stmt->rowCount() == 1){
          $user = $stmt->fetch();

         //  $password =  $user['password'];
         //  $fname =  $user['fname'];
         //  $id =  $user['id'];
         //  $points = $user['points'];
         //  $redeemedPoints = $user['redeemed_points'];
         //  $last_login = $user['last_login'];
         //  $withdraw = $user['withdraw'];
         //  $email = $user['email'];
            if (password_verify($password, $user['password'])) {
               // Create session variables for logged-in user
               $_SESSION['user_id'] = $user['id'];
               $_SESSION['user_name'] = $user['name'];
               $_SESSION['user_email'] = $user['email'];

                 header("Location: dashboard.php");
                 exit;
             }else {
               $em = "Incorect email or password";
               header("Location: ../x2/access/en.php?error=$em&$data");
               exit;
            }

      }else {
         $em = "Incorect email or password";
         header("Location: ../x2/access/en.php?error=$em&$data");
         exit;
      }
    }


}else {
	header("Location: ../x2/access/en.php?error=error");
	exit;
}
