<!DOCTYPE html>
<html>
<head>
	<title>KWIK-E-MART: Register</title>
</head>
<body>
<h2>KWIK-E-MART Registration</h2> 
<h3>Join our Shopping Family - Thank you, come again.</h3>
<p>Enter your preferred credentials below:</p>

<form name="adder" action="register.php" method="post">
<table>
	<tr>
		<td>Proposed Username:</td>
		<td><input type="text" name="un" required></td>
	</tr>
	<tr>
		<td>First Name:</td>
		<td><input type="text" name="fn" required></td>
	</tr>
	<tr>
		<td>Surname:</td>
		<td><input type="text" name="sn" required></td>
	</tr>
	<tr>
		<td>Password:</td>
		<td><input type="password" name="pw" required></td>
	</tr>
	<tr>
		<td>Re-Enter Password:</td>
		<td><input type="password" name="pw2" required></td>
	</tr>
	<tr>
		<td><input type="submit" name="reg" value="Register Me"> <a href="login.php">Login</a></td>
		<td><input type="reset" name="oops" value="Reset"></td>
	</tr>
	
</table>
</form>
<?php
	if (isset($_POST['reg'])){
		//registration attempt
		//go get posted shiz and clean it up or clobber it
		$un = trim(stripslashes(htmlspecialchars($_POST['un'])));
		$fn = trim(stripslashes(htmlspecialchars($_POST['fn'])));
		$sn = trim(stripslashes(htmlspecialchars($_POST['sn'])));
		$pw = sha1($_POST['pw']);
		$pw2 = sha1($_POST['pw2']);

		//handshake with db
		require('connect.php');

		//check to see if username is used
		$row = DB::queryFirstRow('select * from users where uname = %s',$un);

		if (!$row){
			//that user must be a new user
			//final step - check passwords
			if ($pw == $pw2){
				//good to go
				//insert user
				DB::insert('users', array(
	  				'uname' => $un,
	  				'fname' => $fn,
	  				'sname' => $sn,
	  				'pwd' =>   $pw )
				);
				//confirm
				echo '<p>User: '.$un.' added</p>';
				//bounce because all is good
				//FORCE them to use new credentials
				echo '<script>
				        setTimeout(function(){window.location.href = "login.php";},1000); 
				      </script>';

			} else {
				//passwords do not match
				echo '<p>Passwords do not match, try again</p>';
			}
		} else {
			//duplicate user - how best to feed this back?
			echo '<p>User not available, try again</p>';
		}
	}

?>
</body>
</html>
