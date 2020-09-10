<?php
$servername = "localhost";
$username = "root";
$password = "!qaz2wsX";
$dbname = "radical_guestlist";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, 'utf8');

$sql = "SELECT COUNT(id) FROM guests WHERE checked=1";
$result = mysqli_query($conn, $sql);

$return_arr = Array();
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    array_push($return_arr,$row);
}

echo json_encode($return_arr);

echo "</br>";

$sql = "SELECT COUNT(id) FROM guests";
$result = mysqli_query($conn, $sql);

$return_arr = Array();
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    array_push($return_arr,$row);
}

echo json_encode($return_arr);

?>