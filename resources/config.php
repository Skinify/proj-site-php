<?php
 include "../resources/models/User.php";
$servername = "localhost";
$username = "root";
$password = "";
$db = "manga_online";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$sql = "SELECT * FROM User";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  $user;
  while($row = $result->fetch_assoc()) {
    $user = new User($row["Id"], $row["Nickname"], $row["Email"]);
    echo $user->id;
  }
} else {
  echo "0 results";
}
$conn->close();

?>