<?PHP

$_OPTIMIZATION["title"] = "���������������� ������";
$_OPTIMIZATION["description"] = "������� ������������";
$_OPTIMIZATION["keywords"] = "�������, ������ �������, ������������";

# ���������� ������
if(!isset($_SESSION["admin"])){ include("pages/admin/_login.php"); return; }

if(isset($_GET["sel"])){
		
	$smenu = strval($_GET["sel"]);
			
	switch($smenu){
		
		case "404": include("pages/_404.php"); break; // �������� ������
		case "stats": include("pages/admin/_stats.php"); break; // ����������
		case "config": include("pages/admin/_config.php"); break; // ���������
		case "story_insert": include("pages/admin/_story_insert.php"); break; // ������� ���������� �������
		case "users": include("pages/admin/_users.php"); break; // ������ �������������
		case "payments": include("pages/admin/_payments.php"); break; // ������� �� �������
		case "outputa": @session_destroy(); Header("Location: /"); return; break; // �����
			
	# �������� ������
	default: @include("pages/_404.php"); break;
			
	}
			
}else @include("pages/admin/_stats.php");

?>