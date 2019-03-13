<?PHP

$_OPTIMIZATION["title"] = "Административная панель";
$_OPTIMIZATION["description"] = "Аккаунт пользователя";
$_OPTIMIZATION["keywords"] = "Аккаунт, личный кабинет, пользователь";

# Блокировка сессии
if(!isset($_SESSION["admin"])){ include("pages/admin/_login.php"); return; }

if(isset($_GET["sel"])){
		
	$smenu = strval($_GET["sel"]);
			
	switch($smenu){
		
		case "404": include("pages/_404.php"); break; // Страница ошибки
		case "stats": include("pages/admin/_stats.php"); break; // Статистика
		case "config": include("pages/admin/_config.php"); break; // Настройки
		case "story_insert": include("pages/admin/_story_insert.php"); break; // История пополнений баланса
		case "users": include("pages/admin/_users.php"); break; // Список пользователей
		case "payments": include("pages/admin/_payments.php"); break; // Запросы на выплаты
		case "outputa": @session_destroy(); Header("Location: /"); return; break; // Выход
			
	# Страница ошибки
	default: @include("pages/_404.php"); break;
			
	}
			
}else @include("pages/admin/_stats.php");

?>