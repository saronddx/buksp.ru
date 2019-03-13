<?PHP
$_OPTIMIZATION["title"] = "Статистика";
$_OPTIMIZATION["description"] = "Статистика игры";
$_OPTIMIZATION["keywords"] = "Статистика, последняя статистика игры с выводом денег платящие игры экономические фермы";
?>
		<div class="left-content section grid-70 np-mobile">
			<article>
			<div class="text textcenter">
	<div class="grid-25" style="padding: 5px;">Пользователей: <br/><div class="widget tag-cloud"><a href="#"><font color="#000000"><b><?=$stats_data["all_users"]; ?></b></font></a></div></div>
	<div class="grid-25" style="padding: 5px;">Проект работает:<br/><div class="widget tag-cloud"><a href="#"><font color="#000000"><b><?=intval(((time() - $config->SYSTEM_START_TIME) / 86400 ) ); ?>-й день</b></font></a></div></div>
	<div class="grid-25" style="padding: 5px;">Пополнено: <br/><div class="widget tag-cloud"><a href="#"><font color="#000000"><b><?=sprintf("%.2f",$stats_data["all_insert"]); ?> <?=$config->VAL2; ?></b></font></a></div></div>
	<div class="grid-25" style="padding: 5px;">Выплачено: <br/><div class="widget tag-cloud"><a href="#"><font color="#000000"><b><?=sprintf("%.2f",$stats_data["all_payment"]); ?> <?=$config->VAL2; ?></b></font></a></div></div>

<div class="grid-100">
<br>
<center>
<div class="grid-50">
<center><h4>ПОСЛЕДНИЕ 10 ВЫПЛАТ</h4></center>
<?PHP

$all_pay_sum=0;
$dt = time() - 60*60*48;
$db->Query("SELECT * FROM db_payment WHERE status = '3' ORDER BY date_add DESC LIMIT 10");
	while($data1 = $db->FetchArray()){
	
	$all_pay_sum += $data1["serebro"]/100;
		
	?>
<tr align="center">
		<td><?=$data1["purse"]; ?></td>
		<td><b><?=sprintf("%.2f",$data1["sum"]); ?> RUB</b></td>
		<td class="text-muted"><?=date("в H:i",$data1["date_add"]); ?></td>
	</tr>
	<br>
	<?PHP
	}
?>
</div>

<div class="grid-50">
<center><h4>ПОСЛЕДНИЕ 10 ПОПОЛНЕНИЙ</h4></center>
<?PHP	
$db->Query("SELECT * FROM db_insert_money ORDER BY date_add DESC LIMIT 10");
	while($data2 = $db->FetchArray()){
?>
<tr align="center">
		<td><?=$data2["purse"]; ?></td>
		<td><b><?=sprintf("%.2f",$data2["money"]); ?> RUB</b></td>
		<td class="text-muted"><?=date("в H:i",$data2["date_add"]); ?></td>
	</tr>
	<br>
	<?PHP
	}
?>
</div>
</center>
</div>

			</div>
			</article>
		</div>