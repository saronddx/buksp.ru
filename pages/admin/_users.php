		<div class="left-content section grid-70 np-mobile">
			<article>
				<h1 id="page-title" class="title large bordered">������������</h1>
				<div class="text textcenter">
<?PHP
# �������������� ������������
if(isset($_GET["edit"])){

$eid = intval($_GET["edit"]);

$db->Query("SELECT *, INET_NTOA(db_users_a.ip) uip FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_b.id = '$eid' LIMIT 1");

# ��������� �� �������������
if($db->NumRows() != 1){ echo "<center><h3 class='text-danger'>��������� ������������ �� ������</b></center><BR />"; }

# ��������� ������
if(isset($_POST["balance_set"])){

$sum = intval($_POST["sum"]);
$bal = $_POST["schet"];
$type = ($_POST["balance_set"] == 1) ? "-" : "+";

$string = ($type == "-") ? "� ������ ����� {$sum} ������" : "������ ��������� {$sum} ������";

	$db->Query("UPDATE db_users_b SET {$bal} = {$bal} {$type} {$sum} WHERE id = '$eid'");
	$db->Query("SELECT *, INET_NTOA(db_users_a.ip) uip FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_b.id = '$eid' LIMIT 1");
	echo "<center><b>$string</b></center><BR />";
	
}

# �������� ������������
if(isset($_POST["banned"])){

	$db->Query("UPDATE db_users_a SET banned = '".intval($_POST["banned"])."' WHERE id = '$eid'");
	$db->Query("SELECT *, INET_NTOA(db_users_a.ip) uip FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_b.id = '$eid' LIMIT 1");
	echo "<center><b>������������ ".($_POST["banned"] > 0 ? "�������" : "��������")."</b></center><BR />";
	
}

# �������� �������
if(isset($_POST["moneyoff"])){

	$db->Query("UPDATE db_users_a SET money_off = '".intval($_POST["moneyoff"])."' WHERE id = '$eid'");
	$db->Query("SELECT *, INET_NTOA(db_users_a.ip) uip FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_b.id = '$eid' LIMIT 1");
	echo "<center><b>������������ ".($_POST["moneyoff"] > 0 ? "�������" : "��������")."</b></center><BR />";
	
}

$data = $db->FetchArray();

?>

<table width="100%" class="table">
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">ID:</td>
    <td width="200" align="center"><?=$data["id"]; ?></td>
  </tr>
  <tr>
    <td style="padding-left:10px;">������:</td>
    <td width="200" align="center"><?=$data["purse"]; ?></td>
  </tr> 
  
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">������:</td>
    <td width="200" align="center"><?=sprintf("%.2f",$data["money"]); ?> RUB</td>
  </tr>
  
  <tr>
    <td style="padding-left:10px;">���������:</td>
    <td width="200" align="center"><a href="/?menu=admpnl&sel=users&edit=<?=$data["referer_id"]; ?>">[ID <?=$data["referer_id"]; ?>] <?=$data["referer"]; ?></a></td>
  </tr>
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">���������:</td>
	
	<?PHP
	$db->Query("SELECT COUNT(*) FROM db_users_a WHERE referer_id = '".$data["id"]."'");
	$counter_res = $db->FetchRow();
	?>
	
    <td width="200" align="center"><?=$data["referals"]; ?> [<?=$counter_res; ?>] ���.</td>
  </tr>
  
  <tr>
    <td style="padding-left:10px;">��������� �� ���������:</td>
    <td width="200" align="center"><?=sprintf("%.2f",$data["from_referals"]); ?> RUB</td>
  </tr>
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">������ ��������:</td>
    <td width="200" align="center"><?=sprintf("%.2f",$data["to_referer"]); ?> RUB</td>
  </tr>
  
  
  
  <tr>
    <td style="padding-left:10px;">���������������:</td>
    <td width="200" align="center"><?=date("d.m.Y � H:i:s",$data["date_reg"]); ?></td>
  </tr>
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">��������� ����:</td>
    <td width="200" align="center"><?=date("d.m.Y � H:i:s",$data["date_login"]); ?></td>
  </tr>
  <tr>
    <td style="padding-left:10px;">��������� IP:</td>
    <td width="200" align="center"><?=$data["uip"]; ?></td>
  </tr>
  
  
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">��������� �� ������:</td>
    <td width="200" align="center"><?=sprintf("%.2f",$data["insert_sum"]); ?> <?=$config->VAL; ?></td>
  </tr>
  <tr>
    <td style="padding-left:10px;">��������� �� �������:</td>
    <td width="200" align="center"><?=sprintf("%.2f",$data["payment_sum"]); ?> <?=$config->VAL; ?></td>
  </tr>
  
  <tr bgcolor="#efefef">
    <td style="padding-left:10px;">������� (<?=($data["banned"] > 0) ? '<span class = "text-danger"><b>��</b></span>' : '<span class = "text-success"><b>���</b></span>'; ?>):</td>
    <td width="200" align="center">
	<form action="" method="post">
	<input type="hidden" name="banned" value="<?=($data["banned"] > 0) ? 0 : 1 ;?>" />
	<input type="submit" class="btn btn-primary" value="<?=($data["banned"] > 0) ? '���������' : '��������'; ?>" />
	</form>
	</td>
  </tr>
  <tr>
    <td style="padding-left:10px;">��� �������:</td>
    <td width="200" align="center"><?=$data["passcode"]; ?></td>
  </tr>
  
  
</table>
<BR />
<BR />
<form action="" method="post">
<table width="100%" border="0">
  <tr bgcolor="#EFEFEF">
    <td align="center" colspan="4"><b>��������:</b></td>
  </tr>
  <tr>
    <td align="center">
		<select name="balance_set">
			<option value="2">��������</option>
			<option value="1">�����</option>
		</select>
	</td>
	<td align="center">
		<select name="schet">
			<option value="money">������</option>
			<option value="speed">��������</option>
		</select>
	</td>
    <td align="center"><input type="text" name="sum" value="100" size="7"/></td>
    <td align="center"><input type="submit" class="btn btn-primary" value="���������" /></td>
  </tr>
</table>
</form>

<?PHP

return;
}

?>

<form action="/?menu=admpnl&sel=users&search" method="post" style="width: 250px;">
    <div class="input-group">
	<input type="text" name="sear" class="form-control" placeholder="������� ������" />
	<span class="input-group-btn"><input type="submit" class="btn btn-primary" value="�����" /></span>
	</div>
</form>
<?PHP

function sort_b($int_s){
	
	$int_s = intval($int_s);
	
	switch($int_s){
	
		case 1: return "db_users_a.purse";
		case 2: return "all_serebro";
		case 3: return "all_trees";
		case 4: return "db_users_a.date_reg";
		
		default: return "db_users_a.id";
	}

}
$sort_b = (isset($_GET["sort"])) ? intval($_GET["sort"]) : 0;

$str_sort = sort_b($sort_b);


$num_p = (isset($_GET["page"]) AND intval($_GET["page"]) < 1000 AND intval($_GET["page"]) >= 1) ? (intval($_GET["page"]) -1) : 0;
$lim = $num_p * 100;

if(isset($_GET["search"])){
$search = $_POST["sear"];
$db->Query("SELECT *, (db_users_b.speed) all_trees, (db_users_b.money) all_serebro 
FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_a.purse = '$search' ORDER BY {$str_sort} DESC LIMIT {$lim}, 100");

}else $db->Query("SELECT *, (db_users_b.speed) all_trees, (db_users_b.money) all_serebro 
FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id ORDER BY {$str_sort} DESC LIMIT {$lim}, 100");

if($db->NumRows() > 0){

?>
<table cellpadding='3' cellspacing='0' align='center' class='table table-bordered'>
  <thead>
	<td align="center" width="50"><b><a href="/?menu=admpnl&sel=users&sort=0" class="stn-sort">ID</a></b></td>
	<td align="center"><b><a href="/?menu=admpnl&sel=users&sort=1" class="stn-sort">������</a></b></td>
	<td align="center" width="90"><b><a href="/?menu=admpnl&sel=users&sort=2" class="stn-sort">������</a></b></td>
	<td align="center" width="75"><b><a href="/?menu=admpnl&sel=users&sort=3" class="stn-sort">��������</a></b></td>
	<td align="center"><b>������</b></td>
	<td align="center" width="100"><b><a href="/?menu=admpnl&sel=users&sort=4" class="stn-sort">���������������</a></b></td>
</thead>


<?PHP

	while($data = $db->FetchArray()){
	
	?>
<tr>
	<td align="center"><?=$data["id"]; ?></td>
	<td align="center"><a href="/?menu=admpnl&sel=users&edit=<?=$data["id"]; ?>" class="stn"><?=$data["purse"]; ?></a></td>
	<td align="center"><?=sprintf("%.2f",$data["all_serebro"]); ?> RUB</td>
	<td align="center"><?=$data["all_trees"]; ?></td>
	<td align="center"><?=$data["refsite"]; ?></td>
	<td align="center"><?=date("H:i - d.m.Y",$data["date_reg"]); ?></td>
</tr>
	<?PHP
	
	}

?>

</table>
<BR />
<?PHP


}else echo "<center><b>��� �������������</b></center><BR />";

	if(isset($_GET["search"])){
	
	?>



	<?PHP
	
		return;
	
	}
	
$db->Query("SELECT COUNT(*) FROM db_users_a");
$all_pages = $db->FetchRow();

	if($all_pages > 100){
	
	$sort_b = (isset($_GET["sort"])) ? intval($_GET["sort"]) : 0;
	
	$nav = new navigator;
	$page = (isset($_GET["page"]) AND intval($_GET["page"]) < 1000 AND intval($_GET["page"]) >= 1) ? (intval($_GET["page"])) : 1;
	
	echo "<BR /><center>".$nav->Navigation(10, $page, ceil($all_pages / 100), "/?menu=admpnl&sel=users&sort={$sort_b}&page="), "</center>";
	
	}
?>
				</div>			
			</article>
		</div>