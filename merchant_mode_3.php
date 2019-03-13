<?PHP
# Автоподгрузка классов
function __autoload($name){ include("classes/_class.".$name.".php");}

# Класс конфига 
$config = new config;

# Функции
$func = new func;

# База данных
$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);

if (isset($_POST["m_operation_id"]) && isset($_POST["m_sign"]))
{
	$m_key = $config->secretW3;
	$arHash = array($_POST['m_operation_id'],
			$_POST['m_operation_ps'],
			$_POST['m_operation_date'],
			$_POST['m_operation_pay_date'],
			$_POST['m_shop'],
			$_POST['m_orderid'],
			$_POST['m_amount'],
			$_POST['m_curr'],
			$_POST['m_desc'],
			$_POST['m_status'],
			$m_key);
	
	$sign_hash = strtoupper(hash('sha256', implode(":", $arHash)));
	if ($_POST["m_sign"] == $sign_hash && $_POST['m_status'] == "success")
	{
		
	$db->Query("SELECT * FROM db_payeer_insert WHERE id = '".intval($_POST['m_orderid'])."'");
	if($db->NumRows() == 0){ echo $_POST['m_orderid']."|error"; exit;}
	
	$payeer_row = $db->FetchArray();
	if($payeer_row["status"] > 0){ echo $_POST['m_orderid']."|success"; exit;}
	
	$db->Query("UPDATE db_payeer_insert SET status = '1' WHERE id = '".intval($_POST['m_orderid'])."'");
	
	$ik_payment_amount = $payeer_row["sum"];
	$user_id = $payeer_row["user_id"];
   
	# Настройки
	$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
	$sonfig_site = $db->FetchArray();
   
   $db->Query("SELECT purse, referer_id FROM db_users_a WHERE id = '{$user_id}' LIMIT 1");
   $user_ardata = $db->FetchArray();
   $purse = $user_ardata["purse"];
   $refid = $user_ardata["referer_id"];
   $date = time(); 
   
   # Зачисляем баланс
   $serebro = sprintf("%.4f", floatval($sonfig_site["ser_per_wmr"] * $ik_payment_amount) );
   
   $db->Query("SELECT insert_sum FROM db_users_b WHERE id = '{$user_id}' LIMIT 1");
   $ins_sum = $db->FetchRow();
   
   $lsb = time();

   /* ====== Рефералка ====== */
	$db->Query("SELECT purse, referer_id FROM db_users_a WHERE id = '{$user_id}' LIMIT 1");
    $user_ardata = $db->FetchArray();

    # Задаем процент рефки
    $to_referer  = ($ik_payment_amount * 0.07); // 7 процента
 
   # Зачисляем средства рефералу
   $db->Query("UPDATE db_users_b SET money = money + $to_referer WHERE id = '$refid'");
   
   # Зачисляем средства
   $db->Query("UPDATE db_users_b SET super_speed = super_speed + '$serebro', to_referer = to_referer + '$to_referer', insert_sum = insert_sum + '$ik_payment_amount' WHERE id = '{$user_id}'");
   # Зачисляем бонус
   $db->Query("UPDATE db_users_b SET super_speed = super_speed + '$bonus' WHERE id = '{$user_id}'");
   
   # Статистика пополнений
   $da = time();
   $dd = $da + 60*60*24*15;
   $db->Query("INSERT INTO db_insert_money (user_id, purse, money, serebro, date_add, date_del) 
   VALUES ('$user_id','$purse','$ik_payment_amount','$serebro','$da','$da')");
   
								// Уведомить админа
								$to  = "mr.kukareky@gmail.com";
								// Тема 
								$subject = "Доход с проекта";
								// Сообщение 
								$message =   "
								<p>+$ik_payment_amount.00 RUB | В режим Максимальный | $purse</p>
								";
								// Указываем правильный MIME-тип сообщения:
								$headers  =   'MIME-Version: 1.0' . "\r\n";
								$headers.= "Content-type: text/html; charset=Windows-1251\r\n";
								$headers.= "Date: ".date("m.d.Y (H:i:s)",time())."\r\n";
								$headers.= "From: support@nolix.space \r\n";
								// Отправляем сообщение
								mail($to, $subject,   $message, $headers);
   
	echo $_POST['m_orderid']."|success";
	exit;
	
	
	}
	echo $_POST['m_orderid']."|error";
}
?>