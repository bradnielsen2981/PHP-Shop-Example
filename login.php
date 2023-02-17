<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>KWIK-E-MART: Login</title>
</head>
<body>
<h2>KWIK-E-MART Customer Portal<br>Login</h2>
<form name="loginnerrer" action="login.php" method="post">
<p>Username:<input type="text" name="un" required></p>
<p>Password:<input type="password" name="pw" required></p>
<p><input type="submit" name="login" value="login"> <a href="register.php">Register</a></p>
</form>

<?php
if(isset($_POST['login'])){
	//attempted a login

	//retrieve and cleanup user input
	$who = trim(stripslashes(htmlspecialchars($_POST['un'])));
	$pw = sha1($_POST['pw']);

	//handshake with db
	require ('connect.php');

	//go get nominated users data
	$row = DB::queryFirstRow('select * from users where uname = %s',  $who);

	//how good a choice?
	if (!$row){
		//nothing came back, therefore username not registered
		echo '<p>Error with username or password</p>';
		//burn them, burn them all
		session_destroy();

	} else {
		//got a live user, let's check password
		if($pw == $row['pwd']){
			//huzzah, user knows their password, all good
			echo '<h3>Welcome '.$row['fname'].'</h3>';

			//account keeping for other pages
			$_SESSION['user'] = $row['uname'];
			$_SESSION['uname'] = $row['fname'].' '.$row['sname'];
			$_SESSION['uid'] = $row['uid'];

			//bounce them, logged in, to the homepage
			echo '<script> 
                     setTimeout(function(){
                     	window.location.href="index.php"
                     	},1000)
			      </script>';

		} else {
			//password error
			echo '<p>Error with username or password</p>';
			//burn them, burn them all
			session_destroy();

		}

	}
}


?>

</body>
</html>