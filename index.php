<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>KWIK-E-MART: Home Page</title>
</head>
<body>
<?php    
    if(isset($_SESSION['uid'])){    
        //logged in, offer logout
        echo '<form name="logouter" method="post" action="./">
                <h4><input type="submit" name="logout" value="logout">';
        echo ' Welcome back '.$_SESSION['uname'].'</h4></form>';

    } else {
        //not logged in, offer login
        echo '<p><a href="login.php">Login</a></p>';
    }


    if (isset($_POST['logout'])){
        //user chose to logout, burn them, burn them all
    	session_destroy();

        //now return here, allow the script to process
        echo '<script>
            setTimeout(function(){window.location.href = "index.php";},0); 
          </script>';
    }

    echo '<h2>Welcome to KWIK-E-MART</h2>';
    echo '<img src="img/quickeemart.png" alt="Store Logo">';
    //rest of the homepage here

    echo '<h3><a href="products.php">Go shopping</a></h3>';
    echo '<h3><a href="cart.php">View shopping cart</a></h3>';

?>
</body>
</html>