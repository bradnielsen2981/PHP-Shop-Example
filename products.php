<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>KWIK-E-MART: Products</title>
	<style>
		input[type="number"] {
   			width:50px;
		}
	</style>
</head>
<body>
<?php
	/*
	You can ANONYMOUSLY browse products, but will be prevented from
	adding to your cart until you LOG IN
	The "add to cart" button treats you differently depending on whether
	you are logged in or not
	*/
	
	//handshake
	require('connect.php');

	//form processing
	if (isset($_POST['submit'])) {
		if(!isset($_SESSION['uid'])){
			//not logged in user - MUST login first
			echo '<script> 
		            setTimeout(function(){
		                 window.location.href="login.php"
		            },10)
				  </script>';
		}
		//user MAY have tried to add something to their shopping basket
		//let's see
		$which =    $_POST['item'];
		$howmany = $_POST['qty'];
		if($howmany != 0){
			//ordered at least 1 of something
			//let's go get that product's details first
			$thatproduct = DB::queryFirstRow('select * from products where pid = %s',$which);

			//calculate subtotal
			$subt = $howmany*$thatproduct['pcost'];

			//now add that many to the cart
			DB::insert('cart', array(
					'owner' => $_SESSION['uid'],
					'pid'    => $which,
					'pname'  => $thatproduct['pname'],
					'qty'    => $howmany,
					'ucost'  => $thatproduct['pcost'],
					'subt'   => $subt )
			);

		}
	}

	//check to see if logged in or not - onscreen feedback varies accordingly
	if(isset($_SESSION['uid'])){
		$feedback = 'Add this item to your shopping basket?';
		echo '<p>Shopper: '.$_SESSION['uname'].'</p>';
		//go get how many items in your cart
		$cartcontents = DB::queryFirstField("SELECT sum(qty) FROM cart WHERE owner = %s", $_SESSION['uid']);

	}else {
		$feedback = 'You need to LOG IN to shop, redirecting you now.';
		echo '<p>Remember: You need to <a href="login.php">LOG IN</a> to add items to your basket.</p>';
		//no shopping cart to display
		$cartcontents = '-';
	}


	//main interface plating up
	echo '<h2>KWIK-E-MART Online Stupormarket</h2>';
	echo '<h4><a href="index.php"><img src="img/quickeemart.png" height="30" alt="shopping basket"> Go Home</a> <a href="cart.php"><img src="img/basketsml.png"  height="30" alt="shopping basket"> VIEW your shopping basket ['.$cartcontents.']</a></h4>';

	//go get products
	$allproducts = DB::query('select * from products order by pname');

	//plate all products up
	//note to self - paginate and categorise items
	echo '<table cellpadding="5" cellspacing="0" border="1">';
	foreach ($allproducts as $item) {
		echo '<tr><td><strong>'.$item['pname'].'</strong></td>';
		printf('<td><img src="img/%s" width="100" alt="%s"</td>',$item['ppic'],$item['pname']);
		echo '<td>'.$item['pdesc'].'</td>';
		printf('<td>$%.2f</td>',$item['pcost']);
		//now the add to cart bit
		/*
		This is relatively clever - each item has the "SUBMIT" button
		and each item drops a HIDDEN value corresponding to the PRODUCTID
		for that item, and the QTY. Regardless of what product is ordered
		then, we pick that up post-submit and process it :)
		*/
		echo '<td>
		     <form name="itemadd" method="post" action="products.php">
		         <input type="number" name="qty" value="0" min="0" required>
		         <input type="hidden" name="item" value="'.$item['pid'].'"><br>
		         <input type="submit" name="submit" value="add to basket" OnClick="return confirm(\''.$feedback.'\')">
		     </form>
		  </td>';
		}
	echo '</table>';

	
?>
</body>
<script src='js/new_ajax_helper.js'></script>
<script src='js/custom.js'></script>
</html>