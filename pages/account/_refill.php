<?PHP
$_OPTIMIZATION["title"] = "���������� ��������";
$usid = $_SESSION["user_id"];
$purse = $_SESSION["purse"];

$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();
# ����������� ����� ������
$mini = 9; 
$mini2 = 499; 
$mini3 = 999; 
?>
<style>
.mode {
    font-size: 14px;
    color: #111;
    background: #FFD012;
    display: inline-block;
    padding: 3px 15px;
    vertical-align: top;
    border-radius: 3px;
    margin-bottom: 5px;
    border-radius: 25px;
}
</style>
		<div class="left-content section grid-70 np-mobile">
			<article>
				<h1 id="page-title" class="title large bordered">��������� �������</h1>
				<div class="text textcenter">
<center>
<?
/// ������
if(isset($_POST["mode1"])){

$sum = round($_POST["mode1"]);

	if($sum > $mini){

# ������� � ��
$db->Query("INSERT INTO db_payeer_insert (user_id, purse, sum, date_add) VALUES ('".$_SESSION["user_id"]."','".$_SESSION["purse"]."','$sum','".time()."')");

$desc = base64_encode($_SERVER["HTTP_HOST"]." - ACCOUNT ".$_SESSION["purse"]);
$m_shop = $config->shopID1;
$m_orderid = $db->LastInsert();
$m_amount = number_format($sum, 2, ".", "");
$m_curr = "RUB";
$m_desc = $desc;
$m_key = $config->secretW1;

$arHash = array(
 $m_shop,
 $m_orderid,
 $m_amount,
 $m_curr,
 $m_desc,
 $m_key
);
$sign = strtoupper(hash('sha256', implode(":", $arHash)));

$result = ($sonfig_site['speed'] * $sum);
?>
<center>
					<form method="GET" action="//payeer.com/api/merchant/m.php">
					<input type="hidden" name="m_shop" value="<?=$config->shopID1; ?>">
					<input type="hidden" name="m_orderid" value="<?=$m_orderid; ?>">
					<input type="hidden" name="m_amount" value="<?=number_format($sum, 2, ".", "")?>">
					<input type="hidden" name="m_curr" value="RUB">
					<input type="hidden" name="m_desc" value="<?=$desc; ?>">
					<input type="hidden" name="m_sign" value="<?=$sign; ?>">
					<div class="grid-100">
						<span class="mode" style="width: 40%;"><b style="width: 100%;">����� ���������</b></span><br>
						<input class="form-control" type="text" style="width: 40%; text-align: center;" value="<?=$sum; ?> RUB" disabled>
						<button class="epcl-shortcode epcl-button regular outline green" style="width: 40%;" name="m_process" type="submit">�����������</button>
						<p>����������� 70% � �����<br>
						���� ���������� ������� <b><?=sprintf("%.8f",$result)*60*60*24; ?> <font color="#f9234b">RUB</font></b></p>
					</div>
					</form>
</center>
				</div>			
			</article>
		</div>
<?PHP
	}else echo "<center><div class='epcl-shortcode epcl-box information'><i class='epcl-icon fa fa-info'></i> ����������� ����� ������ ����� ������: 10 RUB</div><a href='/refill' class='epcl-shortcode epcl-button regular outline red'>���������</a></center></div></article></div>";
?>
<?PHP

return;
}
?>
<?
/// ������
if(isset($_POST["mode2"])){

$sum = round($_POST["mode2"]);

	if($sum > $mini2){

# ������� � ��
$db->Query("INSERT INTO db_payeer_insert (user_id, purse, sum, date_add) VALUES ('".$_SESSION["user_id"]."','".$_SESSION["purse"]."','$sum','".time()."')");

$desc = base64_encode($_SERVER["HTTP_HOST"]." - ACCOUNT ".$_SESSION["purse"]);
$m_shop = $config->shopID2;
$m_orderid = $db->LastInsert();
$m_amount = number_format($sum, 2, ".", "");
$m_curr = "RUB";
$m_desc = $desc;
$m_key = $config->secretW2;

$arHash = array(
 $m_shop,
 $m_orderid,
 $m_amount,
 $m_curr,
 $m_desc,
 $m_key
);
$sign = strtoupper(hash('sha256', implode(":", $arHash)));

$result = ($sonfig_site['premium_speed'] * $sum);
?>
<center>
					<form method="GET" action="//payeer.com/api/merchant/m.php">
					<input type="hidden" name="m_shop" value="<?=$config->shopID2; ?>">
					<input type="hidden" name="m_orderid" value="<?=$m_orderid; ?>">
					<input type="hidden" name="m_amount" value="<?=number_format($sum, 2, ".", "")?>">
					<input type="hidden" name="m_curr" value="RUB">
					<input type="hidden" name="m_desc" value="<?=$desc; ?>">
					<input type="hidden" name="m_sign" value="<?=$sign; ?>">
					<div class="grid-100">
						<span class="mode" style="width: 40%;"><b style="width: 100%;">����� �������</b></span><br>
						<input class="form-control" type="text" style="width: 40%; text-align: center;" value="<?=$sum; ?> RUB" disabled>
						<button class="epcl-shortcode epcl-button regular outline green" style="width: 40%;" name="m_process" type="submit">�����������</button>
						<p>����������� 90% � �����<br>
						���� ���������� ������� <b><?=sprintf("%.8f",$result)*60*60*24; ?> <font color="#f9234b">RUB</font></b></p>
					</div>
					</form>
</center>
				</div>			
			</article>
		</div>
<?PHP
	}else echo "<center><div class='epcl-shortcode epcl-box information'><i class='epcl-icon fa fa-info'></i> ����������� ����� ������ ����� ������: 1000 RUB</div><a href='/refill' class='epcl-shortcode epcl-button regular outline red'>���������</a></center></div></article></div>";
?>
<?PHP

return;
}
?>
<?
/// ������
if(isset($_POST["mode3"])){

$sum = round($_POST["mode3"]);

	if($sum > $mini3){

# ������� � ��
$db->Query("INSERT INTO db_payeer_insert (user_id, purse, sum, date_add) VALUES ('".$_SESSION["user_id"]."','".$_SESSION["purse"]."','$sum','".time()."')");

$desc = base64_encode($_SERVER["HTTP_HOST"]." - ACCOUNT ".$_SESSION["purse"]);
$m_shop = $config->shopID3;
$m_orderid = $db->LastInsert();
$m_amount = number_format($sum, 2, ".", "");
$m_curr = "RUB";
$m_desc = $desc;
$m_key = $config->secretW3;

$arHash = array(
 $m_shop,
 $m_orderid,
 $m_amount,
 $m_curr,
 $m_desc,
 $m_key
);
$sign = strtoupper(hash('sha256', implode(":", $arHash)));

$result = ($sonfig_site['super_speed'] * $sum);
?>
<center>
					<form method="GET" action="//payeer.com/api/merchant/m.php">
					<input type="hidden" name="m_shop" value="<?=$config->shopID3; ?>">
					<input type="hidden" name="m_orderid" value="<?=$m_orderid; ?>">
					<input type="hidden" name="m_amount" value="<?=number_format($sum, 2, ".", "")?>">
					<input type="hidden" name="m_curr" value="RUB">
					<input type="hidden" name="m_desc" value="<?=$desc; ?>">
					<input type="hidden" name="m_sign" value="<?=$sign; ?>">
					<div class="grid-100">
						<span class="mode" style="width: 40%;"><b style="width: 100%;">����� ��������</b></span><br>
						<input class="form-control" type="text" style="width: 40%; text-align: center;" value="<?=$sum; ?> RUB" disabled>
						<button class="epcl-shortcode epcl-button regular outline green" style="width: 40%;" name="m_process" type="submit">�����������</button>
						<p>����������� 120% � �����<br>
						���� ���������� ������� <b><?=sprintf("%.8f",$result)*60*60*24; ?> <font color="#f9234b">RUB</font></b></p>
					</div>
					</form>
</center>
				</div>			
			</article>
		</div>
<?PHP
	}else echo "<center><div class='epcl-shortcode epcl-box information'><i class='epcl-icon fa fa-info'></i> ����������� ����� ������ ����� ������: 10000 RUB</div><a href='/refill' class='epcl-shortcode epcl-button regular outline red'>���������</a></center></div></article></div>";
?>
<?PHP

return;
}
?>
<div class="grid-33">
	<form action="" method="POST">
	<span class="mode"><b style="width: 100%;">����� ���������</b></span><br>
    <input class="form-control" name="mode1" type="text" style="width: 100%; text-align: center;" placeholder="������� �����" required="">
    <button class="epcl-shortcode epcl-button regular outline blue" style="width: 100%;" type="submit">��������</button>
	</form>
	<p><small>����������� 70% � �����<br>
	������ �� <b>10 <font color="#f9234b">RUB</font></b></small></p>
</div>
<div class="grid-33">
	<form action="" method="POST">
	<span class="mode"><b style="width: 100%;">����� �������</b></span><br>
    <input class="form-control" name="mode2" type="text" style="width: 100%; text-align: center;" placeholder="������� �����" required="">
    <button class="epcl-shortcode epcl-button regular outline blue" style="width: 100%;" type="submit">��������</button>
	</form>
	<p><small>����������� 90% � �����<br>
	������ �� <b>500 <font color="#f9234b">RUB</font></b></small></p>
</div>
<div class="grid-33">
	<form action="" method="POST">
	<span class="mode"><b style="width: 100%;">����� ��������</b></span><br>
    <input class="form-control" name="mode3" type="text" style="width: 100%; text-align: center;" placeholder="������� �����" required="">
    <button class="epcl-shortcode epcl-button regular outline blue" style="width: 100%;" type="submit">��������</button>
	</form>
	<p><small>����������� 120% � �����<br>
	������ �� <b>1000 <font color="#f9234b">RUB</font></b></small></p>
</div>
<hr>
<p>��� ��������� � ����������� ������� �� ������, ���������� ����� ������� �� ������ ������������� � ��������� �����.<br><small>���� ����� ���������� ����� 10 RUB, ������������ � "���������", ���� ����� 500 RUB � "�������", ���� ����� 1000 RUB � "������������".</small></p>
</center>
				</div>			
			</article>
		</div>