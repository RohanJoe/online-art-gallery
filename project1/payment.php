<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
</head>
<body>
<div style="background-image: url('marble-2398946_1920.jpg'); background-repeat: repeat-y; height: 100%;">


<?php
$payment="";

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
Amount to be added to your account: <input type="text" name="payment" value="<?php echo $payment;?>">
<br><br>
<input type="submit" name="submit" value="Submit">
<br><br>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  if (isset($_POST['submit'])) 
  {
    if ($_POST["payment"])
      {
        $sql = 'UPDATE account SET money = money+'.test_input($_POST["payment"]).' WHERE username="'.$userresult['userName'].'"';
        $result = $conn->query($sql);
      }
  }
}
?>

<a href="http://project1/home_page.php">Return to the Home Page.</a><br>
</div>
</body>
</html>