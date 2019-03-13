		<div class="left-content section grid-70 np-mobile">
			<article>
				<h1 id="page-title" class="title large bordered">Настройки</h1>
				<div class="text textcenter">
<?PHP
$db->Query("SELECT * FROM db_config WHERE id = '1'");
$data_c = $db->FetchArray();

# Обновление
if(isset($_POST["admin"])){
	
	$speed = $_POST["speed"];
	
	$price_speed = intval($_POST["price_speed"]);

	
	# Проверка на ошибки
	$errors = true;
	
	if($speed < 0){
		$errors = false; echo "<center><span class = 'text-danger'><b>Неверная настройка мощности! Минимум 0</b></span></center><BR />"; 
	}
	
	
	if($price_speed < 1){
		$errors = false; echo "<center><span class = 'text-danger'><b>Минимальная стоимость мощности не должна быть менее 1-го рубля</b></span></center><BR />"; 
	}
	
	# Обновление
	if($errors){
	
		$db->Query("UPDATE db_config SET 
		
		speed = '$speed',
		price_speed = '$price_speed'
		
		WHERE id = '1'");
		
		echo "<center><span class = 'text-success'><b>Сохранено</b></span></center><BR />";
		$db->Query("SELECT * FROM db_config WHERE id = '1'");
		$data_c = $db->FetchArray();
	}
	
}

?>
<form action="" method="post">
<table width="100%" class="table">
  <tr>
    <td><b>Сколько даёт мощности 1 RUB:</b></td>
	<td width="150" align="center"><div class="comments-form"><input class="form-control" type="text" name="speed" value="<?=$data_c["speed"]; ?>" /></div></td>
  </tr>

  <tr>
    <td><b>Стоимость мощности:</b></td>
	<td width="150" align="center"><div class="comments-form"><input class="form-control" type="text" name="price_speed" value="<?=$data_c["price_speed"]; ?>" /></div></td>
  </tr>
  
  <tr> <td colspan="2" align="center"><input class="btn btn-primary" name="admin" type="submit" value="Применить настройки" /></td> </tr>
</table>
</form>
				</div>			
			</article>
		</div>