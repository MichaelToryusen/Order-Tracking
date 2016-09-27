<!doctype html public "-//w3c//dtd html 3.2//en">
<html>

<?php
//***************************************
//Html table design from https://mottie.github.io/tablesorter/ By Christian Bach
//*****************************************

require "config2.php"; // Your Database details 
include '../Constants/navbar.php';
?>

<style type="text/css">
	.TFtable{
		width:100%; 
		border-collapse:collapse; 
	}
	.TFtable td{ 
		padding:7px; border:#4e95f4 1px solid;
	}
	/* provide some minimal visual accomodation for IE8 and below */
	.TFtable tr{
		background: #b8d1f3;
	}
	/*  Define the background color for all the ODD background rows  */
	.TFtable tr:nth-child(odd){ 
		background: #b8d1f3;
	}
	/*  Define the background color for all the EVEN background rows  */
	.TFtable tr:nth-child(even){
		background: #dae5f4;
	}
	
	.test {background: rgba(222,22,22,0.4) ;}
	.test2 {background: rgba(22,222,22,0.4) ;}
	.test3{background: rgba(204,204,22,0.4) ;}
	
</style>

<head>
<title>Order Tracking</title>
<meta name="GENERATOR" content="Arachnophilia 4.0">
<meta name="FORMATTER" content="Arachnophilia 4.0">

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://mottie.github.io/tablesorter/js/jquery.tablesorter.js"></script>
<script src="http://mottie.github.io/tablesorter/js/jquery.tablesorter.widgets.js"></script>
<link rel="stylesheet" type="text/css" href="theme.blue.css">

</head>



<body>
<center>In order to use this feature please fill in the "Required Delivery Date" field when creating an order. Located in the top right of the Denton Order screen.</center>
<?Php
//////results query////////



$code1="select 
	Orders.id as [Order ID], 
	Customers.Title, 
	Customers.Surname, 
    CONVERT (varchar, [OrderDate],103) AS [Order date] ,
    CONVERT (varchar, [Estimated date],103) AS [Estimated date] ,
	DATEDIFF(day,GETDATE(),	[Estimated date]) AS Countdown, 
	[status], 
	Customers.Telephone,
	Customers.Telephone2 ,
	Customers.Mobile,
	Employees.Name as Employee
from 
	Orders
	join Customers on Orders.CustomerID=Customers.ID
	join Employees on Orders.EmployeeID=Employees.ID
where 
	[Estimated date]IS NOT NULL and
	[Agreed date] IS NULL
	
order by Employee,Countdown,[Order ID]
";


$result=$code1;

$resultquery = mssql_query($result);


echo'<table class="tablesorter">';
echo('<thead><tr>


<th><center><b>Order ID</b><br><input name="inputrange" class="search" placeholder="Order ID" data-column="0" type="search"></center></th>
<th><center><b>Title</b></center></th>
<th><center><b>Surname</b></center></th>
<th><center><b>Order Date</b></center></th>
<th><center><b>Estimated Date</b></center></th>
<th><center><b>Countdown</b></center></th>
<th><center><b>Status</b></center></th>
<th><center><b>Telephone</b></center></th>
<th><center><b>Telephone2</b></center></th>
<th><center><b>Mobile</b></center></th>
<th><center><b>Employee</b><br><input name="inputrange" class="search" placeholder="Employee" data-column="10" type="search"></center></th>


</tr></b></thead>');

echo'<tbody>';
for ($i = 0; $i < mssql_num_rows($resultquery); ++$i) {
	$Orderid = mssql_result($resultquery,$i, 'Order ID');
	$Title = mssql_result($resultquery,$i, 'Title');
	$Surname = mssql_result($resultquery,$i, 'Surname');
	$Orderdate = mssql_result($resultquery,$i, 'Order date');
	$Estimateddate = mssql_result($resultquery,$i, 'Estimated date');
	$Countdown = mssql_result($resultquery,$i, 'Countdown');
	$status = mssql_result($resultquery,$i, 'status');
	$Telephone = mssql_result($resultquery,$i, 'Telephone');
	$Telephone2 = mssql_result($resultquery,$i, 'Telephone2');
	$Mobile = mssql_result($resultquery,$i, 'Mobile');
	$Employee = mssql_result($resultquery,$i, 'Employee');
	
	
	if ($Countdown == 1 or $Countdown == -1){$Countdowndays=' day';} else {$Countdowndays=' days';};


	if ($Countdown >14){$tableclass='test2';};
	if ($Countdown <15){$tableclass='test3';};	
	if ($Countdown <1){$tableclass='test';};

echo('<tr class="'.$tableclass.'">

<td>'.$Orderid. '</td>

<td>'.$Title . '</td>
<td>'.$Surname . '</td>
<td>'.$Orderdate . '</td>
<td>'.$Estimateddate . '</td>
<td>'.$Countdown . $Countdowndays . '</td>
<td>'.$status . '</td>
<td>'.$Telephone . '</td>
<td>'.$Telephone2 . '</td>
<td>'.$Mobile . '</td>
<td>'.$Employee . '</td>
</tr>');


}
echo'</tbody>';
echo'</table>';



echo "</form>";
//    theme: 'blue',
?>
<br><br>

<script type="text/javascript">
	
$(function() {

  var $table = $('table').tablesorter({
 theme: 'blue',
    widgets: ["filter"],
    widgetOptions : {
      // if true overrides default find rows behaviours and if any column matches query it returns that row
      // filter_anyMatch : true,
      filter_columnFilters: false,
      filter_reset: '.reset'
    }
  });

  // Target the $('.search') input using built in functioning
  // this binds to the search using "search" and "keyup"
  // Allows using filter_liveSearch or delayed search &
  // pressing escape to cancel the search
  $.tablesorter.filter.bindSearch( $table, $('.search') );

});


</script>

<form>
<input type="submit" value="Menu" onclick="this.form.action='/Delivery';return true;">
</form>
</body>

</html>








