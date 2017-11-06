<?php
$conn=mysql_connect("localhost","root","sql@zio!tes");
mysql_select_db("asteriskcdrdb", $conn);

$sql = "select * from cdr where (dstchannel like  'SIP/SMI%') AND LENGTH(dst) != '4'";  //## ?쒖옉??怨?留덉?留됱씪 蹂?섏뿉 ?쒓컙 異붽?
$result1 = mysql_query($sql,$conn);
if(! $result1){
    die('Could not get data: ' . mysql_error());
}
?>
<?php
$totals = 0;
while($row1 = mysql_fetch_array($result1,MYSQL_ASSOC)){
    $src_tit1 = substr(str_replace('SIP/','',$row1['dstchannel']),0,4);
//echo $row1['dst'];
    if(strlen($row1['dst']) == 4){
        $brand_num1 = $src_tit1;
    }else{
        $brand_num1 =  $row1['dst'];
    }

    if(substr($brand_num1,0,2) == '01' ){
        $totals = $totals + ((ceil($row1['billsec']/10))*6.8);
    }
    if(substr($brand_num1,0,2) == '86' ){
        $totals = $totals + ((ceil($row1['billsec']/60))*22);
    }
    if((substr($brand_num1,0,2) != '01' ) && (substr($brand_num1,0,2) != '86' )){
        $totals = $totals + ((ceil($row1['billsec']/180))*32);
    }
}
?>
<?php

mysql_close($conn);

$conn2=mysql_connect("58.229.240.123","root","sql@zio!tes");
mysql_select_db("smi", $conn2);

if(isset($_POST['save_deposit']))
{
    $amount = $_POST['amount'];
    $date_deposit = date('y-m-d');

    $sql_ins="INSERT INTO client_deposit(amount,date) 
					VALUES
					('$amount',
					 '$date_deposit'
					 )";
    $result_ins=mysql_query($sql_ins);
}
?>
<?php
echo trim(shell_exec('whoami'));

$deposit = 0;
$compute_query = "Select * from client_deposit";
$result_deposit = mysql_query($compute_query,$conn2);
while($row_dep = mysql_fetch_array($result_deposit,MYSQL_ASSOC))
{
    $deposit = $deposit + $row_dep['amount'];

}
$deposit = $deposit;
$less=$deposit - $totals;

if
($less <= 0 ) {
    $output = shell_exec('asterisk -rx "database put cidname 0269740025 test"');
    //echo "<pre>$output</pre>";
}
if
($less > 0){
    $output = shell_exec('asterisk -rx "database del cidname 0269740025"');
    //echo "<pre>$output</pre>";
}
?>

<?php echo number_format($less);?>