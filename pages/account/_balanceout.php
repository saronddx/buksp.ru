<?
$_OPTIMIZATION["title"] = "����� �������";
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
$status_array = array( 0 => "<span class='text-warning'>�����������</span>", 1 => "<span class='text-warning'>�����������</span>", 2 => "<span class='text-warning'>��������</span>", 3 => "<span class='text-success'>���������</span>", 4 => "<span class='text-warning'>REPEAT</span>");

$db->Query("SELECT * FROM db_payment WHERE user_id = '$usid' order by id DESC LIMIT 1");
$frompayments = $db->FetchArray();
# ����������� ���-�� ����� ��� �����������.
$stoptime = 1; 
?>
		<div class="left-content section grid-70 np-mobile">
			<article>
				<h1 id="page-title" class="title large bordered">����� �������</h1>
				<div class="text textcenter">
<?PHP
# ���������� �������
if($user_data2["money_off"] >= 1 ){

?>
<center>
<br><br>
					<i class="fa fa-exclamation-triangle fa-5x text-danger"></i>
					<h4 class="text-danger">�����������</h4>
					<p class="text-warning">���������� � ������ ���������</p>
</center>
<?PHP

return;
}

?>
<center>
<?PHP
# ���������� ������
$db->Query("SELECT COUNT(*) FROM db_payment WHERE user_id = '$user_id' AND status = 0");
if($db->FetchRow() == 1){
?>
<center>
					<font color="#46c267"><i class="fa fa-spinner fa-spin fa-5x"></i></font>
					<br><br>
					<h4 class="text-success">��� ����� ��������������</h4>
					<div class="epcl-shortcode epcl-box information"><i class="epcl-icon fa fa-info"></i>������� ����� ������ �� 2 ��� �� 24 �����</div>
					<a href="/history" style="width: 34%;" class="epcl-shortcode epcl-button regular outline blue">������� ������</a>
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


	# �������� ������ �� �������
	if(isset($_POST["swap"])){

		$purse = $user_data2['purse'];
		$sum = intval($_POST["sum"]);
				
              ### ������������� ����� �� �������
			  if ($frompayments["date_add"] <= time() - $stoptime * 3600) {

				if(1 <= $sum){

					if($sum <= $user_data["money"]){

							# ��������� �� ������������ ������
							$db->Query("SELECT COUNT(*) FROM db_payment WHERE user_id = '$usid' AND status = 0");
							if($db->FetchRow() == 0){
								
							  # �������� �� ����� ������. ��������� ��� ���.
						      if(100 <= $sum){

								# ������� � ������������
								$db->Query("UPDATE db_users_b SET money = money - '$sum' WHERE id = '$usid'");

								# ��������� ������ � �������
								$da = time();
								$dd = $da + 60*60*24*15;
								$sum_r = round($sum / $sonfig_site["ser_per_wmr"], 2);
								$db->Query("INSERT INTO db_payment (user_id, purse, sum, pay_sys, date_add, date_del)
								VALUES ('$usid','$purse','$sum_r','$ps','$da','$dd')");
								
								// ��������� ������ � ������
								$to  = "mr.kukareky@gmail.com";
								// ���� 
								$subject = "����� ������� �� $purse �� ����� $sum_r ���";
								// ��������� 
								$message =   "
								<p>$purse �� ����� $sum_r ���</p>
								";
								// ��������� ���������� MIME-��� ���������:
								$headers  =   'MIME-Version: 1.0' . "\r\n";
								$headers.= "Content-type: text/html; charset=Windows-1251\r\n";
								$headers.= "Date: ".date("m.d.Y (H:i:s)",time())."\r\n";
								$headers.= "From: support@nolix.space \r\n";
								// ���������� ���������
								mail($to, $subject,   $message, $headers);

								header('Location: /balanceout'); 
								
							  }else{
								# ������� � ������������
								$db->Query("UPDATE db_users_b SET money = money - '$sum' WHERE id = '$usid'");

								# ��������� ������ � �������
								$da = time();
								$dd = $da + 60*60*24*15;
								$sum_r = round($sum / $sonfig_site["ser_per_wmr"], 2);
								$db->Query("INSERT INTO db_payment (user_id, purse, sum, pay_sys, status, date_add, date_del)
								VALUES ('$usid','$purse','$sum_r','$ps','3','$da','$dd')");
								
								# �����������
								$payeer = new rfs_payeer($config->AccountNumber, $config->apiId, $config->apiKey);
								if($payeer->isAuth()) {
								$arBalance = $payeer->getBalance();
								if($arBalance["auth_error"] == 0) {
									$balance = $arBalance['balance']['RUB']['DOSTUPNO'];
									if($balance >= $sum){
															$arTransfer = $payeer->transfer(array(
															'curIn' => 'RUB', // ���� ��������
															'sumOut' => $sum, // ����� ���������
															'curOut' => 'RUB', // ������ ���������
															'to' => $purse, // ���������� (email)
															'anonim' => 'Y', // ���������� (email)
															'comment' => iconv('windows-1251', 'utf-8', "������� � �������� �������� ����� - Nolix.space")
															));
										$db->Query("UPDATE db_users_b SET payment_sum = payment_sum + '$sum' WHERE id = '$usid'");
										$db->Query("UPDATE db_stats SET all_payments = all_payments + '$sum' WHERE id = '1'");
										echo "<center><div class='epcl-shortcode epcl-box success'><i class='epcl-icon fa fa-check'></i> ������� �� ����� {$sum} RUB ������� �����������!</div></center>";
									} else echo '<center><div class="epcl-shortcode epcl-box notice"><i class="epcl-icon fa fa-info"></i> ���������� �������� ���������� �������!</div></center>';
								} else echo '<center><div class="epcl-shortcode epcl-box notice"><i class="epcl-icon fa fa-info"></i>������ API!</div></center>';
								} else echo '<center><div class="epcl-shortcode epcl-box notice"><i class="epcl-icon fa fa-info"></i>������ �����������!</div></center>';	
							  }

							}else echo "<center><div class='epcl-shortcode epcl-box notice'><i class='epcl-icon fa fa-info'></i> �� ��� �������� �������!</div></center>";

					}else echo "<center><div class='epcl-shortcode epcl-box notice'><i class='epcl-icon fa fa-info'></i> �� ������� ������, ��� ������� �� ����� �������!</div></center>";

				}else echo "<center><div class='epcl-shortcode epcl-box notice'><i class='epcl-icon fa fa-info'></i> ����������� ����� ��� ������ 1 RUB</div></center>";
				
			  }else echo "<center><div class='epcl-shortcode epcl-box notice'><i class='epcl-icon fa fa-info'></i> �� ��������� ��� �� ��� �������� ��������!</div></center>";

	}



?>
							<form action="" method="post">
							<div class="thw-autohr-bio">
								<small>�������� ��� ������� <h2 class="text-center"><span><?=intval($user_data['money']); ?></span> <font color="#f9234b"><b>RUB</b></font></h2></small>
							</div>
                                    <input class="form-control" style="text-align:center; width: 40%;" type="text" placeholder="������� �����" required="" name="sum" size="5"/>
									<button class="epcl-shortcode epcl-button regular outline green" style="width: 40%; text-align: center;" name="swap" type="submit">�������� �������</button><br>
									<a href="/history" style="width: 34%;" class="epcl-shortcode epcl-button regular outline blue">������� ������</a>
							</form>
</center>
				</div>			
			</article>
		</div>