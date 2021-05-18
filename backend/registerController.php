<?php 
session_start();
if(isset($_SESSION['user_id']))
{
    die("Kan niet registeren - je bent al ingelogd.");
}
$email = $_POST['email'];
if(filter_var($email, FILTER_VALIDATE_EMAIL) === false)
{
	die('Email is ongeldig!');
}

$password = $_POST['password'];
$password_check = $_POST['password_check'];
if($password != $password_check)
{
	die("Wachtwoorden zijn niet gelijk!");
}


require_once 'conn.php';
$sql = "SELECT * FROM users WHERE username = :email";
$statement = $conn->prepare($sql);
$statement->execute([
	":email" => $email
]);
if($statement->rowCount() > 0)
{
	die("Dit E-mailadres is al geregisteerd.");
}

if(empty($password))
{
	die("Wachtwoord mag niet leeg zijn!");
}
$hash = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO users (username, password) VALUES (:email, :hash)";
$statement = $conn->prepare($query);
$statement->execute([
	":email" => $email,
	":hash" => $hash
]);

header("Location: ../login.php");
exit;
?>