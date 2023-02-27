<?php
session_start();
include_once ('connection.php');

$stmt = $conn->prepare("UPDATE players SET latitude = :latitude, longitude = :longitude, accuracy = :accuracy, latest = :latest WHERE Username =:username;" );
$stmt->bindParam(':latitude', $_GET['latitude']);
$stmt->bindParam(':longitude', $_GET['longitude']);
$stmt->bindParam(':accuracy', $_GET['accuracy']);
$stmt->bindParam(':latest', $_GET['latest']);
$stmt->bindParam(':username', $_GET['username']);
$stmt->execute();
?>