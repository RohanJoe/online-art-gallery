<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
</head>
<body>
<div style="background-image: url('marble-2398946_1920.jpg'); background-repeat: repeat-y; height: 100%;">
<?php
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
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  
  $usersql = "SELECT * FROM user WHERE online = 1";
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

  $artName=key($_POST['clicked']);

  $sqlpriceupdate = 'UPDATE art set price=price+100,sold=0,userName=NULL where artName="'.$artName.'"';
  $resultpriceupdate = $conn->query($sqlpriceupdate);
  $sqluserupdate = 'UPDATE account set money=money+(select price from art where artName="'.$artName.'") where userName="'.$userresult['userName'].'"';
  $resultuserupdate = $conn->query($sqluserupdate);
}
else
{
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
  $accsql = 'SELECT * FROM account where username="'.$userresult['userName'].'"';
  $accresult = $conn->query($accsql)->fetch_assoc();
  echo "<center>Your Account Balance: ".$accresult['money']."</center><br><br>";
}



$sql = 'SELECT * FROM art where sold=1 and username="'.$userresult['userName'].'"';
$result = $conn->query($sql);
if ($result->num_rows > 0) 
{
  // output data of each row
  while($row = $result->fetch_assoc()) 
  {
    echo "<i>" . $row["artName"]. "</i>, ".$row["artistName"].'<br><img src="'.$row["imgurl"].'"><br>';
    echo '<input type="submit" name="clicked['.$row["artName"].']" value="Sell Back to Gallery for $'.(string)((int)$row["price"]+100).'!"><br><br>';
  }
}
else
{
  echo "No results...<br><br>";
}
?>
</form>

<a href="http://project1/home_page.php">Return to the Home Page.</a><br>
</div>
</body>
</html>