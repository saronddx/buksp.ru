		<div class="left-content section grid-70 np-mobile">
			<article>
				<h1 id="page-title" class="title large bordered">���������� �������</h1>
				<div class="text textcenter">
<?PHP

$db->Query("SELECT
	COUNT(id) all_users,
	SUM(money) money,
	SUM(payment_sum) payment_sum, 
	SUM(insert_sum) insert_sum
	FROM db_users_b");
$data_stats = $db->FetchArray();

?>
<br>
<center>
<table class="table" align="center">
  <tr >
    <td><b>���������������� �������������:</b></td>
	<td width="100" align="center"><?=$data_stats["all_users"]; ?> ���.</td>
  </tr>
  
  <tr> <td colspan="2" align="center"><b>- - - - -</b></td> </tr>
  
  <tr>
    <td><b>����� ������ �������:</b></td>
	<td width="200" align="center"><?=sprintf("%.0f",$data_stats["money"]); ?> <?=$config->VAL; ?></td>
  </tr>
  
  <tr> <td colspan="2" align="center"><b>- - - - -</b></td> </tr>

  <tr>
    <td><b>��������� ��������������:</b></td>
	<td width="300" align="center"><?=sprintf("%.2f",$data_stats["insert_sum"]); ?> <?=$config->VAL; ?></td>
  </tr>
  
  <tr>
    <td><b>��������� �������������:</b></td>
	<td width="300" align="center"><?=sprintf("%.2f",$data_stats["payment_sum"]); ?> <?=$config->VAL; ?></td>
  </tr>
  
</table>
</center>
				</div>			
			</article>
		</div>