<?php 

if(isset($_POST['name']) && 
   isset($_POST['email']) &&
   isset($_POST['password']) &&
   isset($_POST['cpassword']) && 
   isset($_POST['cnumber']) && 
   isset($_POST['country']) &&
   isset($_POST['terms'])){

    include "db_conn.php";

    $name = $_POST['name'];
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    $cnumber = $_POST['cnumber'];

    // Form data to pass back to form if there's an error
    $data = "name=".$name."&email=".$email."&country=".$country."&cnumber=".$cnumber;
	
    // Validate form fields
    if (empty($name)) {
    	$em = "Full name is required";
    	header("Location: ../x2/access/in/index.php?error=$em&$data");
	    exit;
    } else if(empty($email)){
		$em = "Email is required";
		header("Location: ../x2/access/in/index.php?error=$em&$data");
		exit;
	} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$em = "Invalid email format";
		header("Location: ../x2/access/in/index.php?error=$em&$data");
		exit;
	} else if(empty($pass)){
    	$em = "Password is required";
    	header("Location: ../x2/access/in/index.php?error=$em&$data");
	    exit;
	} else if ($pass !== $cpass) {
		$em = "Passwords do not match";
		header("Location: ../x2/access/in/index.php?error=$em&$data");
		exit;
	} else if(empty($cnumber)){
    	$em = "Phone number is required";
    	header("Location: ../x2/access/in/index.php?error=$em&$data");
	    exit;
    } else if(empty($country)){
    	$em = "Country is required";
    	header("Location: ../x2/access/in/index.php?error=$em&$data");
	    exit;
    } else {
		// Ensure email is unique
		$query = "SELECT * FROM users WHERE email = ?";
    	$stmt = $conn->prepare($query);
    	$stmt->execute([$email]);

		if ($stmt->rowCount() > 0) {
			$em = "Email already exists";
    		header("Location: ../x2/access/in/index.php?error=$em&$data");
	    	exit;
		} else {
			// Hash the password
			$hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

			// Insert data into the database
			$sql = "INSERT INTO users(name, password, email, country, phone_number) 
    	            VALUES(?,?,?,?,?)";
			$stmt = $conn->prepare($sql);
			$stmt->execute([$name, $hashed_pass, $email, $country, $cnumber]);

			header("Location: ../x2/access/in/index.php?success=Your account has been created successfully");
			exit;
		}
	}
} else {
	$em = "All fields are required!";
	header("Location: ../x2/access/in/index.php?error=$em");
	exit;
}
