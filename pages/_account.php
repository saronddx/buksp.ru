<?PHP

$_OPTIMIZATION["title"] = "Аккаунт";
$_OPTIMIZATION["description"] = "Аккаунт пользователя";
$_OPTIMIZATION["keywords"] = "Аккаунт, личный кабинет, пользователь";

# Блокировка сессии
if(!isset($_SESSION["user_id"])){ Header("Location: /"); return; }

if(isset($_GET["sel"])){
		
	$smenu = strval($_GET["sel"]);
			
	switch($smenu){
		
		case "404": include("pages/_404.php"); break; // Страница ошибки
		case "referrals": include("pages/account/_referrals.php"); break; // Рефералы
		case "farm": include("pages/account/_farm.php"); break; // Моя ферма
		case "history": include("pages/account/_history.php"); break; // Моя ферма
		case "exchange": include("pages/account/_exchange.php"); break; // Обменный пункт	
		case "balanceout": include("pages/account/_balanceout.php"); break; // Выплата пользователю
		case "withdraw": include("pages/account/_balanceout.php"); break; // Выплата пользователю
		case "refill": include("pages/account/_refill.php"); break; // Пополнение баланса
		case "bonus": include("pages/account/_bonus.php"); break; // Ежедневный бонус
		case "output": @session_destroy(); Header("Location: /"); return; break; // Выход
				
	# Страница ошибки
	default: @include("pages/_404.php"); break;
			
	}
			
}else @include("pages/account/_user_account.php");

?>