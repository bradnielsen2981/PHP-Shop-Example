<?php
session_start();
if(!isset($_SESSION['uid'])){
		//login first
		echo '<script> 
	            setTimeout(function(){
	                 window.location.href="./"
	            },10)
			  </script>';
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>KWIK-E-MART: Shopping Cart</title>
</head>
<body>
<?php
	/*
	You can ANONYMOUSLY browse products, but will be prevented from
	adding to your cart until you LOG IN
	The "add to cart" button treats you differently depending on whether
	you are logged in or not
	*/
	//let's go
	echo '<h2>KWIK-E-MART Shopping Basket</h2>';
	echo '<h4><a href="index.php"><img src="img/quickeemart.png" height="30" alt="shopping basket"> Go Home</a> <a href="products.php"><img src="img/basketsml.png"  height="30" alt="shopping basket"> Add MORE to your Basket</a></h4>';
	echo '<h3>Shopper: '.$_SESSION['uname'].'</h3>';

	//handshake
	require('connect.php');

	//form process FIRST
	if (isset($_POST['killer'])){
		//user wants to empty their basket
		DB::query('delete from cart where owner = %s',$_SESSION['uid']);
	} elseif (isset($_POST['remove'])) {
		//user wants to remove an item - find out which one
		$which = $_POST['which'];
		//now remove it
		DB::query('delete from cart where itemid = %s',$which);

	}

	//now go get the shopping cart contents
	$contents = DB::query('select * from cart where owner = %s',$_SESSION['uid']);

	//derive the total for this cart
	$tot = DB::queryFirstField('select sum(subt) from cart where owner = %s',$_SESSION['uid']);

	//plate cart up
	echo '<table cellpadding="5" cellspacing="0" border="1">
	     <tr><th>Product</th><th>Quantity</th><th>Unit Price</th><th>Subtotal</th></tr>';
	foreach ($contents as $product) {
		echo '<tr><td>'.$product['pname'].'</td>';
		echo '<td style="text-align:right">'.$product['qty'].'</td>';
		printf('<td style="text-align:right">$ %.2f</td>',$product['ucost']);
		printf('<td style="text-align:right">$ %.2f</td>',$product['subt']);
		echo '<td>
		         <form name="removeproduct" method="post" action="cart.php">
		         	<input type="submit" name="remove" value="x" OnClick="return confirm(\'Are you SURE you want to REMOVE this item from your basket?\')">
		         	<input type="hidden" name="which" value="'.$product['itemid'].'">
		         </form>
		      </td></tr>';
		}
	printf('<tr><td></td><td></td><td>Order Total:</td><td style="text-align:right"><strong>$ %.2f</strong></td></tr></table>',$tot);

	//offer to empty the basket
	echo '<form method="post" name="killer" action="cart.php">
			<input type="submit" name="killer" value="EMPTY Basket" OnClick="return confirm(\'Are you SURE you want to EMPTY your basket?\')">
	      </form>';

?>
</body>
</html>