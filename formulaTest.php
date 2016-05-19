<?php
$servername = "localhost";
$username = "root";
$password = "meroot";

// Create connection
$conn = mysql_connect($servername,$username,$password);

// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";
mysql_select_db("mtr");

$output = new stdClass();


$sql = "SELECT * FROM labtype_inputs WHERE id=19 ";

$result = mysql_query($sql) or die(mysql_error());

$result = mysql_query($sql);
while ($job = mysql_fetch_object($result)) {
    $output = $job;
}
//print_r($output);

echo $output->formula."<br>";

$formula_str = $output->formula;

function avg()
{
    //print_r(func_get_args());

    echo $result = array_sum(func_get_args())/count(func_get_args());
}


//load param value
$param = 'E';
$val = 10;
eval('$'.$param.' = '.$val.';');

$param = 'G';
$val = 10;
eval('$'.$param.' = '.$val.';');

$param = 'H';
$val = 20;
eval('$'.$param.' = '.$val.';');


$formula_str = '(pi()*pow($E,3))/6';
$formula_str = '($E-$G)*100/$E';
$formula_str = '10-sqrt(100-pow($G,2))';
$formula_str = 'avg($E,$G,$H)';


eval('$result = '.$formula_str.';');
echo $result;

?>