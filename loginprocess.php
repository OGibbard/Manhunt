<?php
session_start();
include_once ('connection.php');

array_map('htmlspecialchars', $_POST);

$stmt = $conn->prepare("SELECT * FROM players WHERE Username =:username ;" ); 

$stmt->bindParam(':username', $_POST['username']); 

$stmt->execute();
$row= $stmt->fetch(PDO::FETCH_ASSOC);
if($_POST['username']==''){
    header('Location: login.php');
}elseif($row['Username']!=$_POST['username']){
    header('Location: login.php');
}else{
    $hashedPassword = hash('sha256', $_POST['passwd']);
    if($row['Password']== $hashedPassword){
        $_SESSION['name']=$row['Username'];
        header('Location: map.php');
    }
    else{
        header('Location: login.php');
        echo ('Try again');
    }
}
$conn=null;

?>