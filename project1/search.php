<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
</head>
<body>
<div style="background-image: url('marble-2398946_1920.jpg'); background-repeat: repeat-y; height: 100%;">


<?php
$name="";

$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="";
$dbname="art";

$conn = new mysqli($host, $user, $password, $dbname, $port, $socket);

if ($conn->connect_error) 
{
  die("Connection failed: " . $conn->connect_error);
}


$usersql = "SELECT userName FROM user WHERE online = 1";
  $userresult = $conn->query($usersql)->fetch_assoc();
  if ($userresult)
  {
    echo "<center>User: ".$userresult['userName']."<br><br></center>";
  }
  else
  {
    echo "<center>User: Not Currently Logged In<br><br></center>";
  }
  echo "<br>";
  if ($userresult)
  {
  $accsql = 'SELECT * FROM account where username="'.$userresult['userName'].'"';
  $accresult = $conn->query($accsql)->fetch_assoc();
  echo "<center>Your Account Balance: ".$accresult['money']."</center><br><br>";
  }


function test_input($data) 
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = strtolower($data);
  return $data;
}
?>


<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
Enter the Name of the Artist or Artwork: <input type="text" name="name" value="<?php echo $name;?>">
<br><br>
<input type="submit" name="submit" value="Submit">
</form>

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  echo "<br><br><h2><b>RESULTS:</b></h2>";

  $sql = 'SELECT * FROM art';
  $result = $conn->query($sql);
  
  while($row = $result->fetch_assoc()) 
  {
    if (strpos(test_input($row["artName"]),test_input($_POST["name"]))!== false||strpos(test_input($row["artistName"]),test_input($_POST["name"]))!== false)
    {
      echo "<i>" . $row["artName"]. "</i>, ".$row["artistName"].'<br><img src="'.$row["imgurl"].'"><br><br>';
    }
  }
}
?>

<br><a href="http://project1/home_page.php">Return to the Home Page.</a><br>
</div>
</div>
</body>
</html>