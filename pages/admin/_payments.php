		<div class="left-content section grid-70 np-mobile">
			<article>
				<h1 id="page-title" class="title large bordered">Выплаты</h1>
				<div class="text textcenter">
<?PHP


# Выплачено
if(isset($_POST["payment"])){

$ret_id = intval($_POST["payment"]);
$db->Query("SELECT * FROM db_payment WHERE status = '0' AND id = '{$ret_id}'");

	if($db->NumRows() == 1){
	
	$ret_data = $db->FetchArray();
	
	$user_id = $ret_data["user_id"];
	$sum = $ret_data["sum"];
	$serebro = $ret_data["serebro"];
		
		$payeer = new rfs_payeer($config->AccountNumber, $config->apiId, $config->secretW);
		if($payeer->isAuth()) {
		$arBalance = $payeer->getBalance();
		$purse = $ret_data['purse'];
		$usid = $ret_data['user_id'];
		$paymentid = $ret_data['payment_id'];
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
				$db->Query("UPDATE db_users_b SET payment_sum = payment_sum + '$sum' WHERE id = '$user_id'");
				$db->Query("UPDATE db_payment SET status = '3' WHERE id = '$ret_id'");
				$db->Query("UPDATE db_stats SET all_payments = all_payments + '$sum' WHERE id = '1'");
			} else echo '<center><b class="text-danger">Резерв недостаточен!</b></center><BR />';
		} else echo '<center><b class="text-danger">Ошибка API!</b></center><BR />';
		} else echo '<center><b class="text-danger">Ошибка авторизации!</b></center><BR />';	
		
		echo "<center><b class='text-success'>Выплачено, статистика обновлена</b></center><BR />";
		
	}else echo "<center><b class='text-danger'>Заявка не найдена :(</b></center><BR />";

}

# Возврат
if(isset($_POST["return"])){

$ret_id = intval($_POST["return"]);
$db->Query("SELECT * FROM db_payment WHERE status = '0' AND id = '{$ret_id}'");

	if($db->NumRows() == 1){
	
	$ret_data = $db->FetchArray();
	
	$user_id = $ret_data["user_id"];
	$sum = $ret_data["sum"];
		
		$db->Query("UPDATE db_users_b SET money = money + '$sum' WHERE id = '$user_id'");
		$db->Query("UPDATE db_payment SET status = '2' WHERE id = '$ret_id'");
		
		echo "<center><b class='text-success'>Заявка отменена, средства возвращены</b></center><BR />";
		
	}else echo "<center><b class='text-danger'>Заявка не найдена :(</b></center><BR />";

}




$db->Query("SELECT * FROM db_payment WHERE status = '0'");
$ast = $db->NumRows();
if($ast > 0){

?>
<table class="table">
  <tr>
    <td align="center">Кошелек</td>
    <td align="center" width="75">Сумма</td>
  </tr>

<?PHP

	while($data = $db->FetchArray()){
	
	?>
	<tr>
	<td align="center"><a href="/?menu=admpnl&sel=users&edit=<?=$data["user_id"]; ?>"><?=$data["purse"]; ?></a></td>
	<td align="center"><?=sprintf("%.2f", $data["sum"]); ?> <?=$config->VAL; ?></td>
	<td align="center">
	
		<form action="" method="post">
			<input type="hidden" name="payment" value="<?=$data["id"]; ?>" />
			<button type="submit" class="btn btn-success">Выплатить</button>
		</form>
	
	</td>
  	<td align="center">
	
		<form action="" method="post">
			<input type="hidden" name="return" value="<?=$data["id"]; ?>" />
			<button type="submit" class="btn btn-default">Отменить</button>
		</form>
	
	</td>
	</tr>
	<?PHP
	
	}

?>

</table>
<?PHP

}else echo "<center><b>Нет заказов для выплаты</b></center><BR />";

?>
				</div>			
			</article>
		</div>