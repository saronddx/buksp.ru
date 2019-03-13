		<div class="left-content section grid-70 np-mobile">
			<article>
				<h1 id="page-title" class="title large bordered">Статистика проекта</h1>
				<div class="text textcenter">
<?PHP
if(isset($_SESSION["admin"])){ Header("Location: /?menu=admpnl"); return; }

if(isset($_POST["admlogin"])){

	$db->Query("SELECT * FROM db_config WHERE id = 1 LIMIT 1");
	$data_log = $db->FetchArray();
	
	if(strtolower($_POST["admlogin"]) == strtolower("ADMINLOG") AND strtolower($_POST["admpass"]) == strtolower("ADMINPASS") ){
	
		$_SESSION["admin"] = true;
		Header("Location: /?menu=admpnl&sel=stats");
		return;
	}else echo "<center><h3 class='text-danger'><b>Неверно введен логин и/или пароль</b></h3></center><BR />";
	
}

?>
<center>
<center><h3 style="margin-top: 50px;">Панель управления</h3></center>
					<div class="col-lg-5">
                      <form action="" method="post">
                        <div class="form-group">
                          <label class="form-control-label">Логин:</label>
                          <input placeholder="Введите логин" class="form-control" type="text" name="admlogin">
                        </div>
                        <div class="form-group">
                          <label class="form-control-label">Пароль:</label>
                          <input type="password" name="admpass" placeholder="Введите пароль" class="form-control">
                        </div>
                        <div class="form-group">
                          <input class="btn btn-primary" type="submit" value="Войти" />
                        </div>
                      </form>
					</div>
</center>
				</div>			
			</article>
		</div>