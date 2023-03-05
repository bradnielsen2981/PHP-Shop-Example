<?php
	//handshake with database server
	require('connect.php');

    if (isset($_POST['pname'])) //test if form field exists in POST
    {
        $products = DB::query("select * from products where pname LIKE %ss", $_POST['pname']);
        echo json_encode($products);
    }
?>