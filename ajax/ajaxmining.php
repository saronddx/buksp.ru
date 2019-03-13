<?
session_start();
$usid=$_SESSION['user_id'];
$purse=$_SESSION['purse'];

function __autoload($name){ include($_SERVER['DOCUMENT_ROOT']."/classes/_class.".$name.".php");}
$config = new config;
$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);

$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();
$last_sbor = $user_data['last_sbor'];

$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();

$db->Query("SELECT * FROM db_store WHERE user_id  = '$usid' LIMIT 1");
$store_data = $db->FetchArray();

$time = time();
$sobrano = (time() - $last_sbor);

# Вычисление заработка игрока в секунду
$kyr12 = ($user_data["speed"]*$sonfig_site["speed"])*$sobrano;
$kyr22 = ($user_data["premium_speed"]*$sonfig_site["premium_speed"])*$sobrano;
$kyr32 = ($user_data["super_speed"]*$sonfig_site["super_speed"])*$sobrano;
 
$kyrcall2 = $kyr12+$kyr22+$kyr32;
$summa = sprintf("%.8f",$kyrcall2);
	
if(($user_data["speed"]+$user_data["premium_speed"]+$user_data["super_speed"]) > 0){
		
	if($user_data["last_sbor"] < (time() - 1) ){
		
		# Изменяем данные игрока
		$db->Query("UPDATE db_users_b SET money = money + '$summa', last_sbor = '".time()."'
		WHERE id = '$usid'");
		
		$db->Query("UPDATE db_users_a SET date_login = '".time()."' WHERE id = '$usid'");
		
		echo ("+$summa");

	}else echo ("Подождите..");
		
}else echo ("Нечего собирать!");
	
?>
