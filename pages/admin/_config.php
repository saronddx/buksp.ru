		<div class="left-content section grid-70 np-mobile">
			<article>
				<h1 id="page-title" class="title large bordered">���������</h1>
				<div class="text textcenter">
<?PHP
$db->Query("SELECT * FROM db_config WHERE id = '1'");
$data_c = $db->FetchArray();

# ����������
if(isset($_POST["admin"])){
	
	$speed = $_POST["speed"];
	
	$price_speed = intval($_POST["price_speed"]);

	
	# �������� �� ������
	$errors = true;
	
	if($speed < 0){
		$errors = false; echo "<center><span class = 'text-danger'><b>�������� ��������� ��������! ������� 0</b></span></center><BR />"; 
	}
	
	
	if($price_speed < 1){
		$errors = false; echo "<center><span class = 'text-danger'><b>����������� ��������� �������� �� ������ ���� ����� 1-�� �����</b></span></center><BR />"; 
	}
	
	# ����������
	if($errors){
	
		$db->Query("UPDATE db_config SET 
		
		speed = '$speed',
		price_speed = '$price_speed'
		
		WHERE id = '1'");
		
		echo "<center><span class = 'text-success'><b>���������</b></span></center><BR />";
		$db->Query("SELECT * FROM db_config WHERE id = '1'");
		$data_c = $db->FetchArray();
	}
	
}

?>
<form action="" method="post">
<table width="100%" class="table">
  <tr>
    <td><b>������� ��� �������� 1 RUB:</b></td>
	<td width="150" align="center"><div class="comments-form"><input class="form-control" type="text" name="speed" value="<?=$data_c["speed"]; ?>" /></div></td>
  </tr>

  <tr>
    <td><b>��������� ��������:</b></td>
	<td width="150" align="center"><div class="comments-form"><input class="form-control" type="text" name="price_speed" value="<?=$data_c["price_speed"]; ?>" /></div></td>
  </tr>
  
  <tr> <td colspan="2" align="center"><input class="btn btn-primary" name="admin" type="submit" value="��������� ���������" /></td> </tr>
</table>
</form>
				</div>			
			</article>
		</div>