<?PHP
##############################
# Скрипт предоставил https://vk.com/ffcreator
# Автор Алексей Кузнецов https://vk.com/id303150695
# Версия скрипта 1.0
# Покупайте скрипты только у нас в группе и вы будете получать новые версии бесплатно!
##############################

# Счетчик
function TimerSet(){
	list($seconds, $microSeconds) = explode(' ', microtime());
	return $seconds + (float) $microSeconds;
}

$_timer_a = TimerSet();

#откуда пришел
if (!isset($_COOKIE['rsite'])) {
setcookie('rsite', $_SERVER['HTTP_REFERER'], time() + 24 * 3600);
}

# Старт сессии
@session_start();

# Старт буфера
@ob_start();

# Default
$_OPTIMIZATION = array();
$_OPTIMIZATION["title"] = "Майнинг реальных денег без вложений";
$_OPTIMIZATION["description"] = "Nolix.Space - Майнинг реальных денег без вложений";
$_OPTIMIZATION["keywords"] = "Nolix.space, Nolix, майнинг, без вложений, рублёвый майнинг, платит, не обман, современный заработок, экономическая игра, инвестиции, работа, payeer, заработок, доход, прибыль, вложения, заработать";

# Константа для Include
define("CONST_RUFUS", true);

# Автоподгрузка классов
function __autoload($name){ include("classes/_class.".$name.".php");}

# Класс конфига 
$config = new config;

# Функции
$func = new func;

# Установка REFERER
include("inc/_set_referer.php");

# База данных
$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);

# Шапка
@include("inc/_header.php");

		if(isset($_GET["menu"])){
		
			$menu = strval($_GET["menu"]);
			
			switch($menu){
			
				case "404": include("pages/_404.php"); break; // Страница ошибки
				case "rules": include("pages/_rules.php"); break; // Правила проекта
				case "help": include("pages/_help.php"); break; // Правила проекта
				case "about": include("pages/_about.php"); break; // О проекте
				case "news": include("pages/_news.php"); break; // Новости
				case "recovery": include("pages/_recovery.php"); break; // Восстановление пароля
				case "account": include("pages/_account.php"); break; // Аккаунт
				case "stat": include("pages/_stat.php"); break; // Статистика
				case "contacts": include("pages/_contacts.php"); break; // Статистика
				case "success": include("pages/_success.php"); break; // Успешная оплата
				case "fail": include("pages/_fail.php"); break; // Фейл
				case "admpnl": include("pages/_admin.php"); break; // Админка
				
			# Страница ошибки
			default: @include("pages/_404.php"); break;
			
			}
			
		}else @include("pages/_index.php");


# Подвал
@include("inc/_footer.php");


# Заносим контент в переменную
$content = ob_get_contents();

# Очищаем буфер
ob_end_clean();
	
	# Заменяем данные
	$content = str_replace("{!TITLE!}",$_OPTIMIZATION["title"],$content);
	$content = str_replace('{!DESCRIPTION!}',$_OPTIMIZATION["description"],$content);
	$content = str_replace('{!KEYWORDS!}',$_OPTIMIZATION["keywords"],$content);
	$content = str_replace('{!GEN_PAGE!}', sprintf("%.5f", (TimerSet() - $_timer_a)) ,$content);
	
	# Вывод баланса
	if(isset($_SESSION["user_id"])){
	
		$user_id = $_SESSION["user_id"];
		$db->Query("SELECT money FROM db_users_b WHERE id = '$user_id'");
		$balance = $db->FetchArray();
		
		$content = str_replace('{!USER_ID!}', $user_id ,$content);
		$content = str_replace('{!BALANCE!}', sprintf("%.2f", $balance["money"]) ,$content);
	}
	
// Выводим контент
echo $content;
?>