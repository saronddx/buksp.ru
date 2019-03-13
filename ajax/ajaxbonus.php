<?
session_start();
$usid=$_SESSION['user_id'];
$purse=$_SESSION['purse'];

function __autoload($name){ include($_SERVER['DOCUMENT_ROOT']."/classes/_class.".$name.".php");}
$config = new config;
$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);

$ddel = time() + 600;
$dadd = time();
$db->Query("SELECT COUNT(*) FROM db_bonus_list WHERE user_id = '".$_SESSION['user_id']."' AND date_del > '$dadd'");
if($db->FetchRow() == 0){
   
# Настройки бонусов
$bonus_min = 10;
$bonus_max = 100;
	$sumrad = rand($bonus_min, rand($bonus_min, $bonus_max) );
	$sum=$sumrad/1000;
    //echo $sum;
    $db->Query("UPDATE db_users_b SET money = money + '$sum' WHERE id = '$usid'");
    $db->Query("INSERT INTO db_bonus_list (purse, user_id, sum, date_add, date_del) VALUES ('".$_SESSION['purse']."','".$_SESSION['user_id']."','$sum','$dadd','$ddel')");
    echo "ЗАЧИСЛЕНО ".$sum." RUB";
} else echo "Вы уже получали бонус за последние 10 минут!";
?>