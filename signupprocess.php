<?php
include_once("connection.php");
array_map("htmlspecialchars", $_POST);
$username=$_POST['username'];
$stmt = $conn->prepare("SELECT * FROM players WHERE Username = '$username'");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if ($result > 0) {
  header('Location: signup.php');
  echo("Try again");
}
else {
    $hashedPassword = hash('sha256', $_POST['passwd']);
    try{
            $stmt = $conn->prepare("INSERT INTO players (Username,Password,Hunter,Latest,Latitude,Longitude)VALUES (:username,:password,'False','0','0','0')");
            $stmt->bindParam(':username', $_POST["username"]);
            $stmt->bindParam(':password', $hashedPassword);

            $stmt->execute();
        }
    catch(PDOException $e)
        {
            echo "error".$e->getMessage();
        }
    $conn=null;
    header('Location: login.php');
}

echo $_POST["username"]."<br>";
echo $hashedPassword."<br>";
echo $_POST["accounttype"]."<br>";
print_r($_POST);
?>