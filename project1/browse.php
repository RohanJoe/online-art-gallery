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

$sql = "SELECT artistName FROM artist";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") 
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
  if ($userresult)
  {
  $accsql = 'SELECT * FROM account where username="'.$userresult['userName'].'"';
  $accresult = $conn->query($accsql)->fetch_assoc();
  echo "<center>Your Account Balance: ".$accresult['money']."</center><br><br>";
  }

  $artName=key($_POST['clicked']);

  $sql3 = 'SELECT * from art where artName="' .$artName. '"';
  $result3 = $conn->query($sql3);
  $row3 = $result3->fetch_assoc();

  if(!$row3["sold"])
  {
    $sql4 = 'update art set sold=1,userName="'.$userresult['userName'].'" where artName="'. $artName .'"';
    $result4 = $conn->query($sql4);
    $sql5 = 'update account set money=money-'.$row3["price"].' where userName="'.$userresult['userName'].'"';
    $result5 = $conn->query($sql5);
  }

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

if ($result->num_rows > 0) 
{
  // output data of each row
  while ($row0=$result->fetch_assoc())
  {
    echo '<h3>'.$row0['artistName'].'</h3><br>';
    $sql6='select * from art where artistName="'.$row0['artistName'].'"';
    $result6 = $conn->query($sql6);
    while ($row=$result6->fetch_assoc())
    {
      if (!$row['sold']) 
      {
        echo "<i>" . $row["artName"]. "</i>, ".$row["artistName"].'<br><img src="'.$row["imgurl"].'"><br>';
        echo '<input type="submit" name="clicked['.$row["artName"].']" value="Buy for $200"><br><br>';
      }
      elseif ($row['sold'])
      {
        echo "<i>" . $row["artName"]. "</i>, ".$row["artistName"].'<br>';
        echo '<b>sold to '.$row["username"].'</b><br><br>';
      }
    }
  }
} 
else 
{
  echo "0 results";
}


$conn->close();
?> 
</form>

<a href="http://project1/home_page.php">Return to the Home Page.</a><br>
</div>
</body>
</html>