<?php
require_once 'config.php';
$movie_id = $_POST['movie_id'];
$available = $_POST['available'];
$fullname = $_POST['fullname'];
$contactNo = $_POST['contactNo'];


$conn->query("INSERT INTO reservations( movie_id, fullname, contactNo) VALUES ('$movie_id','$fullname','$contactNo')") or die($conn->error);

$conn->query("UPDATE movies SET available=$available - 1 WHERE _id = '$movie_id'") or die($conn->error);

header("Location:index.php");
