<?php if (!$_SESSION["user_id"]) : ?>
			<!-- start: .left-content -->
		<div class="left-content section grid-70 np-mobile">
			<article>
			  <div class="text">
				<center>
				<h1>����� ����������</h1>
				<p>Nolix.Space - ������� �������� ����� ��� ��������. ��� ����� ������, ������������� ��������� ���� ������ <b><font color="#1f3139">PAY</font><font color="#2791d9">EER</font></b> � �� ������� � ������ �������. ��� ��������� ���� �������� � �������� ���� ����������� ������ ��� ������� ���� ��� �� �����.</p>
		<div>
<style>
.schet {
    background: #f5f5f5;
    display: inline-block;
    padding: 14px 15px;
    vertical-align: top;
    border-radius: 3px;
    margin-bottom: 5px;
    border-radius: 5px;
}
</style>
		<h2 class="schet"><span id="mining_run">0.00000000</span> <font color="#f9234b"><b>RUB</b></font></h2>
		<div style="margin-top: -12px;">
            <small><b>��������:</b> <font color="">0.00026100</font> <font color="#f9234b">RUB/sec</font> <b>���������� �����:</b> <font color="">*22.55</font> <font color="#f9234b">RUB</font></small><br>
			<small>
				* ����� �� ������� ���������� �� ����� 1000 ������ � ����� "���������"
			</small>
        </div>
			<script>
(function () {
	var writeTo = document.getElementById("mining_run");
	var sec = 0;
	var a = setInterval(function () {
		sec = sec + 0.0002610037037037/10;
		writeTo.innerHTML = sec.toFixed(8);
	}, 100)
})();
			</script>
		</div>
				<br>
				<h3>���� ������������</h3>
				<div class="grid-50">
					<h5 style="margin-bottom: -5px;"><font color="#f9234b">SSL ����������</font></h5>
					<small>���� ������ ������������ <br>�� ����������� ����������</small><br>
					<img style="margin-top: 10px;" src="/images/ssl-certificate.png" width="70">
					<br><br>
					<h5 style="margin-bottom: -5px;"><font color="#f9234b">��������� 24/7</font></h5>
					<small>���� ������ ��������� <br>�������� 24/7 ��� ��������</small><br>
					<img style="margin-top: 10px;" src="/images/communication.png" width="70">
				</div>
				<div class="grid-50">
					<h5 style="margin-bottom: -5px;"><font color="#f9234b">���������� �������</font></h5>
					<small>������� �������������� <br>��������� � ��� ��������</small><br>
					<img style="margin-top: 10px;" src="/images/maps-and-flags.png" width="70">
					<br><br>
					<h5 style="margin-bottom: -5px;"><font color="#f9234b">���������� ������</font></h5>
					<small>�� ����������� ��� ����������� �������<br>������� � ����� �������� ����������� �����</small><br>
					<img style="margin-top: 10px;" src="/images/script.png" width="70">
				</div>
				</center>
			  </div>
			</article>
		</div>
<?php endif;?>
<?php if ($_SESSION["user_id"]) : ?>
<?PHP
$_OPTIMIZATION["title"] = "������ �������";
$user_id = $_SESSION["user_id"];
$db->Query("SELECT * FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_a.id = '$user_id'");
$prof_data = $db->FetchArray();
$db->Query("SELECT * FROM db_users_b WHERE id = '$user_id'");
$user_data = $db->FetchArray();
$db->Query("SELECT * FROM db_users_a WHERE id = '$user_id'");
$user_data2 = $db->FetchArray();
?>
<?
$usid = $_SESSION["user_id"];
$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();
$last_sbor = $user_data['last_sbor'];

$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();

$db->Query("SELECT * FROM db_store WHERE user_id  = '$usid' LIMIT 1");
$store_data = $db->FetchArray();

# ���������� ��������� � �����
$kyr1 = $user_data["speed"]*$sonfig_site["speed"]*60*60*24;
$kyr2 = $user_data["premium_speed"]*$sonfig_site["premium_speed"]*60*60*24;
$kyr3 = $user_data["super_speed"]*$sonfig_site["super_speed"]*60*60*24;
 
$kyrcall = $kyr1+$kyr2+$kyr3;

$time = time();
$sobrano = (time() - $last_sbor);

# ���������� ��������� ������ � �������
$kyr12 = ($user_data["speed"]*$sonfig_site["speed"])*$sobrano;
$kyr22 = ($user_data["premium_speed"]*$sonfig_site["premium_speed"])*$sobrano;
$kyr32 = ($user_data["super_speed"]*$sonfig_site["super_speed"])*$sobrano;
 
$kyrcall2 = $kyr12+$kyr22+$kyr32;
$summa = sprintf("%.8f",$kyrcall2);

# ���������� � script
$kyr13 = ($user_data["speed"]*$sonfig_site["speed"]);
$kyr23 = ($user_data["premium_speed"]*$sonfig_site["premium_speed"]);
$kyr33 = ($user_data["super_speed"]*$sonfig_site["super_speed"]);
 
$kyrcall3 = $kyr13+$kyr23+$kyr33;

# ���������� ��������� ������ � �������
$kyr14 = $user_data["speed"]*$sonfig_site["speed"];
$kyr24 = $user_data["premium_speed"]*$sonfig_site["premium_speed"];
$kyr34 = $user_data["super_speed"]*$sonfig_site["super_speed"];
 
$kyrcall4 = $kyr14+$kyr24+$kyr34;
?>
			<!-- start: .left-content -->
		<div class="left-content section grid-70 np-mobile">
			<article>
				<h1 id="page-title" class="title large bordered">������ �������</h1>
				<div class="text textcenter">
				<center>
<style>
.schet {
    background: #f5f5f5;
    display: inline-block;
    padding: 14px 15px;
    vertical-align: top;
    border-radius: 3px;
    margin-bottom: 5px;
    border-radius: 5px;
}
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
		<h2 class="schet"><span id="resu"></span><span id="hid"><span id="mining_run"><?=sprintf("%.8f",$kyrcall2); ?></span></span> <font color="#f9234b"><b>RUB</b></font></h2>
		<div id="main">
		<div style="margin-top: -12px;">
            <small><b>��������:</b> <font color=""><?=sprintf("%.8f",$kyrcall4); ?></font> <font color="#f9234b">RUB/sec</font> <b>���������� �����:</b> <font color=""><?=sprintf("%.2f",$kyrcall); ?></font> <font color="#f9234b">RUB</font></small><br>
        </div>
<script>
(function () {
	var writeTo = document.getElementById("mining_run");
	var sec = <?=$kyrcall2; ?>;
	var a = setInterval(function () {
		sec = sec + <?=$kyrcall3/10; ?>;
		writeTo.innerHTML = sec.toFixed(8);
	}, 100)
})();
</script>
		<button class="epcl-shortcode epcl-button regular outline green" style="width: 40%; margin-top: 10px;" id="sbor">�������</button>
		</div>
		<br>
		<h3>���� ����������</h3>
<div class="grid-33">
	<span class="mode"><b style="width: 100%;">����� ���������</b></span><br>
    <input class="form-control" name="mode1" type="text" style="width: 100%; text-align: center;" value="<?=$user_data['speed']; ?> RUB" disabled>
	<p><small>����������� 70% � �����<br>
	����� � ����� <b><?=sprintf("%.2f",sprintf("%.8f",$kyr14)*60*60*24*31); ?> <font color="#f9234b">RUB</font></b></small></p>
</div>
<div class="grid-33">
	<span class="mode"><b style="width: 100%;">����� �������</b></span><br>
    <input class="form-control" name="mode2" type="text" style="width: 100%; text-align: center;" value="<?=$user_data['premium_speed']; ?> RUB" disabled>
	<p><small>����������� 90% � �����<br>
	����� � ����� <b><?=sprintf("%.2f",sprintf("%.8f",$kyr24)*60*60*24*31); ?> <font color="#f9234b">RUB</font></b></small></p>
</div>
<div class="grid-33">
	<span class="mode"><b style="width: 100%;">����� ��������</b></span><br>
    <input class="form-control" name="mode3" type="text" style="width: 100%; text-align: center;" value="<?=$user_data['super_speed']; ?> RUB" disabled>
	<p><small>����������� 120% � �����<br>
	����� � ����� <b><?=sprintf("%.2f",sprintf("%.8f",$kyr34)*60*60*24*31); ?> <font color="#f9234b">RUB</font></b></small></p>
</div>
<p>����� ����������� ����� <b><?=sprintf("%.2f",sprintf("%.8f",$kyrcall4)*60*60*24*31); ?> <font color="#f9234b">RUB</font></b></p>
				</center>
				</div>
			</article>
		</div>
<script type="text/javascript">
    $(document).ready(function(){
            $("#sbor").click(function() {
                $.ajax({
                    url: "../ajax/ajaxmining.php",
                    type: "POST",
                    success: function(data){
					$("#resu").text(" "+data+" ");
                    $('#hid').hide(0,function(){
					$('#balance').load('# #balance');
					$('#main').load('# #main');
					});
                    },
                    error: function(){          
                alert("������ �� ��������!");          
                }
                });
              
            });
    });
</script>
<?php endif;?>