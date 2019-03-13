<?
$_OPTIMIZATION["title"] = "Заказ выплаты";
$user_id = $_SESSION["user_id"];
$usid = $_SESSION["user_id"];
$purse = $_SESSION["purse"];

$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();
$db->Query("SELECT * FROM db_users_a WHERE id = '$usid' LIMIT 1");
$user_data2 = $db->FetchArray();

$db->Query("SELECT * FROM db_users_a WHERE id = '$usid' LIMIT 1");
$log_data = $db->FetchArray();

$db->Query("SELECT * FROM db_payment WHERE user_id = '$usid' order by id DESC LIMIT 1");
$frompayments = $db->FetchArray();

$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$config_site = $db->FetchArray();
$status_array = array( 0 => "<span class='text-warning'>ПРОВЕРЯЕТСЯ</span>", 1 => "<span class='text-warning'>ПРОВЕРЯЕТСЯ</span>", 2 => "<span class='text-warning'>ОТМЕНЕНО</span>", 3 => "<span class='text-success'>ВЫПЛАЧЕНО</span>", 4 => "<span class='text-warning'>REPEAT</span>");

$db->Query("SELECT * FROM db_payment WHERE user_id = '$usid' order by id DESC LIMIT 1");
$frompayments = $db->FetchArray();
# Настраиваем кол-во часов для ограничения.
$stoptime = 1; 
?>
		<div class="left-content section grid-70 np-mobile">
			<article>
				<h1 id="page-title" class="title large bordered">Вывод средств</h1>
				<div class="text textcenter">
<?PHP
# Блокировка выплаты
if($user_data2["money_off"] >= 1 ){

?>
<center>
<br><br>
					<i class="fa fa-exclamation-triangle fa-5x text-danger"></i>
					<h4 class="text-danger">ОГРАНИЧЕНИЕ</h4>
					<p class="text-warning">Обратитесь в службу поддержки</p>
</center>
<?PHP

return;
}

?>
<center>
<?PHP
# Выполнение заказа
$db->Query("SELECT COUNT(*) FROM db_payment WHERE user_id = '$user_id' AND status = 0");
if($db->FetchRow() == 1){
?>
<center>
					<font color="#46c267"><i class="fa fa-spinner fa-spin fa-5x"></i></font>
					<br><br>
					<h4 class="text-success">ВАШ ЗАКАЗ ОБРАБАТЫВАЕТСЯ</h4>
					<div class="epcl-shortcode epcl-box information"><i class="epcl-icon fa fa-info"></i>Выплата может занять от 2 мин до 24 часов</div>
					<a href="/history" style="width: 34%;" class="epcl-shortcode epcl-button regular outline blue">История выплат</a>
</center>
				</div>			
			</article>
		</div>
<?PHP

return;
}

?>
<?PHP
	$pay_id = 1;

	$db->Query("SELECT * FROM db_pay_systems WHERE id = '$pay_id'");

	$pdata = $db->FetchArray();
	$min_ser = $pdata["min_pay"] * $sonfig_site["ser_per_wmr"];
	$ps = $pdata["title"];


	# Создание заявки на выплату
	if(isset($_POST["swap"])){

		$purse = $user_data2['purse'];
		$sum = intval($_POST["sum"]);
				
              ### Устанавливаем лимит по времени
			  if ($frompayments["date_add"] <= time() - $stoptime * 3600) {

				if(1 <= $sum){

					if($sum <= $user_data["money"]){

							# Проверяем на существующие заявки
							$db->Query("SELECT COUNT(*) FROM db_payment WHERE user_id = '$usid' AND status = 0");
							if($db->FetchRow() == 0){
								
							  # Проверка на сумму вывода. Проверять или нет.
						      if(100 <= $sum){

								# Снимаем с пользователя
								$db->Query("UPDATE db_users_b SET money = money - '$sum' WHERE id = '$usid'");

								# Вставляем запись в выплаты
								$da = time();
								$dd = $da + 60*60*24*15;
								$sum_r = round($sum / $sonfig_site["ser_per_wmr"], 2);
								$db->Query("INSERT INTO db_payment (user_id, purse, sum, pay_sys, date_add, date_del)
								VALUES ('$usid','$purse','$sum_r','$ps','$da','$dd')");
								
								// Уведомить админа о заказе
								$to  = "mr.kukareky@gmail.com";
								// Тема 
								$subject = "Заказ выплаты от $purse на сумму $sum_r руб";
								// Сообщение 
								$message =   "
								<p>$purse на сумму $sum_r руб</p>
								";
								// Указываем правильный MIME-тип сообщения:
								$headers  =   'MIME-Version: 1.0' . "\r\n";
								$headers.= "Content-type: text/html; charset=Windows-1251\r\n";
								$headers.= "Date: ".date("m.d.Y (H:i:s)",time())."\r\n";
								$headers.= "From: support@nolix.space \r\n";
								// Отправляем сообщение
								mail($to, $subject,   $message, $headers);

								header('Location: /balanceout'); 
								
							  }else{
								# Снимаем с пользователя
								$db->Query("UPDATE db_users_b SET money = money - '$sum' WHERE id = '$usid'");

								# Вставляем запись в выплаты
								$da = time();
								$dd = $da + 60*60*24*15;
								$sum_r = round($sum / $sonfig_site["ser_per_wmr"], 2);
								$db->Query("INSERT INTO db_payment (user_id, purse, sum, pay_sys, status, date_add, date_del)
								VALUES ('$usid','$purse','$sum_r','$ps','3','$da','$dd')");
								
								# Выплачиваем
								$payeer = new rfs_payeer($config->AccountNumber, $config->apiId, $config->apiKey);
								if($payeer->isAuth()) {
								$arBalance = $payeer->getBalance();
								if($arBalance["auth_error"] == 0) {
									$balance = $arBalance['balance']['RUB']['DOSTUPNO'];
									if($balance >= $sum){
															$arTransfer = $payeer->transfer(array(
															'curIn' => 'RUB', // счет списания
															'sumOut' => $sum, // сумма получения
															'curOut' => 'RUB', // валюта получения
															'to' => $purse, // получатель (email)
															'anonim' => 'Y', // получатель (email)
															'comment' => iconv('windows-1251', 'utf-8', "Выплата с майнинга реальных денег - Nolix.space")
															));
										$db->Query("UPDATE db_users_b SET payment_sum = payment_sum + '$sum' WHERE id = '$usid'");
										$db->Query("UPDATE db_stats SET all_payments = all_payments + '$sum' WHERE id = '1'");
										echo "<center><div class='epcl-shortcode epcl-box success'><i class='epcl-icon fa fa-check'></i> Выплата на сумму {$sum} RUB успешно произведена!</div></center>";
									} else echo '<center><div class="epcl-shortcode epcl-box notice"><i class="epcl-icon fa fa-info"></i> Пожалуйста ожидайте пополнения резерва!</div></center>';
								} else echo '<center><div class="epcl-shortcode epcl-box notice"><i class="epcl-icon fa fa-info"></i>Ошибка API!</div></center>';
								} else echo '<center><div class="epcl-shortcode epcl-box notice"><i class="epcl-icon fa fa-info"></i>Ошибка авторизации!</div></center>';	
							  }

							}else echo "<center><div class='epcl-shortcode epcl-box notice'><i class='epcl-icon fa fa-info'></i> Вы уже заказали выплату!</div></center>";

					}else echo "<center><div class='epcl-shortcode epcl-box notice'><i class='epcl-icon fa fa-info'></i> Вы указали больше, чем имеется на вашем балансе!</div></center>";

				}else echo "<center><div class='epcl-shortcode epcl-box notice'><i class='epcl-icon fa fa-info'></i> Минимальная сумма для вывода 1 RUB</div></center>";
				
			  }else echo "<center><div class='epcl-shortcode epcl-box notice'><i class='epcl-icon fa fa-info'></i> За последний час вы уже выводили средства!</div></center>";

	}



?>
							<form action="" method="post">
							<div class="thw-autohr-bio">
								<small>Доступно для выплаты <h2 class="text-center"><span><?=intval($user_data['money']); ?></span> <font color="#f9234b"><b>RUB</b></font></h2></small>
							</div>
                                    <input class="form-control" style="text-align:center; width: 40%;" type="text" placeholder="Введите сумму" required="" name="sum" size="5"/>
									<button class="epcl-shortcode epcl-button regular outline green" style="width: 40%; text-align: center;" name="swap" type="submit">Заказать выплату</button><br>
									<a href="/history" style="width: 34%;" class="epcl-shortcode epcl-button regular outline blue">История выплат</a>
							</form>
</center>
				</div>			
			</article>
		</div>