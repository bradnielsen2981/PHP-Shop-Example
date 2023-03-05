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
    // Get reference to the HTML table
    var table = document.getElementById('myTable');
    table.innerHTML = "";
    // Loop through the JSON array and insert each item into the HTML table
    results.forEach(function(item) {
        // Create a new row for the table
        var row = table.insertRow();
        // Insert the data into the row cells
        var pname = row.insertCell(0);
        pname.innerHTML = item.pname;
        var pdesc = row.insertCell(1);
        pdesc.innerHTML = item.pdesc;
        var pcost = row.insertCell(2);
        pcost.innerHTML = item.pcost;
    });
}