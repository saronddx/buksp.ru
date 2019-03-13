<?
$_OPTIMIZATION["title"] = "История выплат";
$usid = $_SESSION["user_id"];
$purse = $_SESSION["purse"];

$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();
$db->Query("SELECT * FROM db_users_a WHERE id = '$usid' LIMIT 1");
$user_data2 = $db->FetchArray();

$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$config_site = $db->FetchArray();
$status_array = array( 0 => "<span class='text-warning'>ПРОВЕРЯЕТСЯ</span>", 1 => "<span class='text-warning'>ПРОВЕРЯЕТСЯ</span>", 2 => "<span class='text-danger'>ОТМЕНЕН</span>", 3 => "<font color='#30a758'><i class='fa fa-check'></i> ВЫПЛАЧЕНО</font>", 4 => "<span class='text-warning'>REPEAT</span>");
?>
		<div class="left-content section grid-70 np-mobile">
			<article>
				<h1 id="page-title" class="title large bordered">История выплат</h1>
				<div class="text textcenter">
					<center><h2>Общая сумма выплат: <span><?=$user_data['payment_sum']; ?></span> <font color="#f9234b"><b>RUB</b></font></h2></center><br>
<?PHP
  
  $db->Query("SELECT * FROM db_payment, db_users_a WHERE user_id = '$usid' AND db_users_a.purse = db_payment.purse ORDER BY db_payment.date_add DESC");
  
	if($db->NumRows() > 0){
  
  		while($ref = $db->FetchArray()){
		
?>
<h5>
<div class="grid-25">
<small>ID<br><span>#<?=$ref["id"]; ?></span></small>
</div>
<div class="grid-25">
<small>Сумма выплаты<br><span> <?=sprintf("%.0f",$ref["sum"]); ?></span> <font color="#f9234b"><b>RUB</b></font></small>
</div>
<div class="grid-25">
<small>Статус<br><?=$status_array[$ref["status"]]; ?></small>
</div>
<div class="grid-25">
<small>Дата<br><span><?=date("H:i - d.m.Y",$ref["date_add"]); ?></span></small>
</div>
</h5>
<?PHP
		
		}
  
	}else echo ''
  
?>
				</div>			
			</article>
		</div>