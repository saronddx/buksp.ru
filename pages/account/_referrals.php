<?PHP
$_OPTIMIZATION["title"] = "����������� �������";
$user_id = $_SESSION["user_id"];
$purse = $_SESSION["purse"];
$db->Query("SELECT COUNT(*) FROM db_users_a WHERE referer_id = '$user_id'");
$refs = $db->FetchRow(); // ������� ��������� 1 ������
$db->Query("SELECT COUNT(*) FROM db_users_a WHERE referer_id2 = '$user_id'");
$refs2 = $db->FetchRow(); // ������� ��������� 2 ������
$db->Query("SELECT COUNT(*) FROM db_users_a WHERE referer_id3 = '$user_id'");
$refs3 = $db->FetchRow(); // ������� ��������� 3 ������

$db->Query("SELECT * FROM db_users_a WHERE id = '".$_SESSION['user_id']."'");
$users_info = $db->FetchAssoc();
?>
		<div class="left-content section grid-70 np-mobile">
			<article>
				<h1 id="page-title" class="title large bordered">����������� ���������</h1>
				<div class="text textcenter">
<center><h4 class="text-success">����������� � ������ ����� ������ � ��������� 7% �� �� ������ �� ���� ������</h4></center>
<center>
	<div class="comments-form">
		<p>���� ������ ��� �����������</p>
        <input type="text" onclick="this.select()" class="form-control col-lg-4" style="text-align: center;" value="https://<?=$_SERVER['HTTP_HOST']; ?>/?ref=<?=$_SESSION["user_id"]; ?>">
		<small>���������� ����� ����������� ������� � �������� � ���������� �����<br>��� ���������: ID <?=$users_info['referer_id']; ?></small>
		<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
		<script src="//yastatic.net/share2/share.js"></script>
		<div class="ya-share2" data-url="https://<?=$_SERVER['HTTP_HOST']; ?>/?ref=<?=$_SESSION["user_id"]; ?>" data-services="vkontakte,odnoklassniki,twitter,tumblr,viber,whatsapp,skype,telegram"></div>
	</div>
</center>
<br><br>
<center><h4>���� ��������</h4></center>	
	<table class="table">
	<thead>
	<tr align="center">
	<th><b>������</b></th>
	<th><b>�����</b></th>
	<th><b>������</b></th>
	<th><b>���� �����������</b></th>
	</tr>
	</thead>
<tbody>
<?PHP
  $all_money = 0;
  $db->Query("SELECT db_users_a.purse, db_users_a.date_reg, db_users_a.referals, db_users_a.refsite, db_users_b.to_referer FROM db_users_a, db_users_b 
  WHERE db_users_a.id = db_users_b.id AND db_users_a.referer_id = '$user_id' ORDER BY to_referer DESC");
  
	if($db->NumRows() > 0){
  
  		while($ref = $db->FetchArray()){
		
		?>
	<tr align="center">
		<td><?=$ref["purse"]; ?></td>
		<td><?=sprintf("%.2f",$ref["to_referer"]); ?> RUB</td>
		<td><a href="http://<?=$ref["refsite"]; ?>" target="_blank"><?=$ref["refsite"]; ?></a></td>
		<td><?=date("d.m.Y H:i",$ref["date_reg"]); ?></td>
	</tr>
		<?PHP
		$all_money += $ref["to_referer"];
		}
  
	}else echo '<tr><td align="center" colspan="5">� ��� ��� ���������</td></tr>'
  ?>
</tbody>
	</table>
				</div>			
			</article>
		</div>