<?php
require_once 'config.php';
$movieId = $_GET['id'];

$movies = $conn->query("SELECT * FROM movies WHERE _id = '$movieId'") or die($conn->error);
$movie = $movies->fetch_array(MYSQLI_ASSOC);
echo json_encode($movie);
