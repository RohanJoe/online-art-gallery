<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body, html {
  height: 100%;
  margin: 0;
}

.bg {
  /* The image used */
  background-image: url("marble-2398946_1920.jpg");

  /* Full height */
  height: 100%; 

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}
</style>
</head>
<body>
<div style="background-image: url('marble-2398946_1920.jpg'); background-repeat: repeat-y; height: 100%;">
<?php
$username="";
$newusername="";
$profile="";

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
<h3><b>Welcome To The Gallery.</b></h3><br>
<i>We hope you will enjoy your stay.<br><br>
<!-- If you have not already done so, kindly</i> <a href="http://project1/register_login.php">login or register.</a><br> -->
<!-- <a href="http://project1/art_page.php">Your Profile.</a><br>
<br> -->

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
Login: <input type="text" name="username" value="<?php echo $username;?>">
<br><br>
Register: <input type="text" name="newusername" value="<?php echo $newusername;?>">
<br>
Profile (optional): <input type="text" name="profile" value="<?php echo $profile;?>">
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
    if ($_POST["username"])
      {
        $sql = 'UPDATE user SET online = 1 WHERE username="'. test_input($_POST["username"]).'"';
        $result = $conn->query($sql);
      }
    else if ($_POST["newusername"])
      {
        if ($_POST["profile"])
        {
          $sql = 'INSERT INTO user VALUES("'. test_input($_POST["newusername"]).'",0,"'.test_input(($_POST["profile"])).'",1)';
          $result = $conn->query($sql);
        }
        else
        {
          $sql = 'INSERT INTO user VALUES("'. test_input($_POST["newusername"]).'",0,"",1)';
          $result = $conn->query($sql);
        }
        $sql = 'INSERT INTO account VALUES("'. test_input($_POST["newusername"]).'",0)';
        $result = $conn->query($sql);
      }
  }
  else if (isset($_POST['logout'])) 
  {
    $sql = 'UPDATE user SET online = 0';
    $result = $conn->query($sql);
  }
}
?>
<div style="position: absolute; bottom: 5px;">
<?php
$loginornotsql = 'SELECT * FROM user where online=1';
$loginornotresult = $conn->query($loginornotsql);
if ($loginornotresult->num_rows > 0) 
{
  echo '<br><br><a href="http://project1/search.php">Search Artists or Art</a><br>';
  echo '---------------<br>';
  echo '<a href="http://project1/browse.php">Browse Artists</a><br>';
  echo '---------------<br>';
  echo '<a href="http://project1/art_page.php">Browse Your Collection</a><br>';
  echo '---------------<br>';
  echo '<a href="http://project1/payment.php">Add Money to Your Account</a><br>';
  echo '---------------<br>';
  echo '<a href="http://project1/submission.php">Submit Your Artwork to the Gallery</a><br>';
}
?>

</div>

</div>
</body>
</html>
