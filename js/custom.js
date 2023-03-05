alert("Custom.js loaded");

//use AJAX to send results
function search()
{
    productname = document.getElementById("productname").value;
    formobject = new FormData(); //create a form object
    formobject.append("pname", productname); //email is a textinput tag value
    new_ajax_helper('/shop/getresults.php',handleresults,formobject); //send the formobject to the url, you can define a callback 
}

function handleresults(results)
{
    console.log(results);
}