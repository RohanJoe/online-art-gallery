<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
</head>
<body>
<div style="background-image: url('marble-2398946_1920.jpg'); background-repeat: repeat-y; height: 100%;">


<?php
$artname="";
$imgurl="";
$price="";

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
Name of the Artwork: <input type="text" name="artname" value="<?php echo $artname;?>">
<br><br>
URL to the current image location: <input type="text" name="imgurl" value="<?php echo $imgurl;?>">
<br>
Price: <input type="text" name="price" value="<?php echo $price;?>">
<br><br>
<input type="submit" name="submit" value="Submit">
<br><br>
<input type="submit" name="logout" value="Log Out">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  if (isset($_POST['submit'])) 
  {
    if ($_POST["artname"])
    {
      $sql = 'INSERT INTO art VALUES("'. test_input($_POST["artname"]).'","'.$userresult['userName'].'",NULL,"'.test_input($_POST["imgurl"]).'",0,'.test_input($_POST["price"]).')';
      $result = $conn->query($sql);
    }
    $artistsql = 'SELECT artistName FROM artist where artistName="'.$userresult['userName'].'"';
    $artistresult = $conn->query($artistsql)->fetch_assoc();
    if ($artistresult)
    {
      $updsql = 'UPDATE artist set worksCreated=worksCreated+1 where artistName="'.$userresult['userName'].'"';
      $updresult = $conn->query($updsql);
    }
    else
    {
      $inssql = 'INSERT INTO artist VALUES("'.$userresult['userName'].'",1)';
      $insresult = $conn->query($inssql);
    }
  }
}
?>

<a href="http://project1/home_page.php">Return to the Home Page.</a><br>
</div>
</body>
</html>