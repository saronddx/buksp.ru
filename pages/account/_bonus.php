<?PHP
$_OPTIMIZATION["title"] = "���������� �����";
$usid = $_SESSION["user_id"];
$uname = $_SESSION["user"];

# ��������� �������
$bonus_min = 1;
$bonus_max = 100;

?>
<script LANGUAGE="JavaScript1.1">
document.oncontextmenu = function(){return false;};
</script> 
		<div class="left-content section grid-70 np-mobile">
			<article>
				<h1 id="page-title" class="title large bordered">�����</h1>
				<div class="text textcenter">
<center>
����� �������� 1 ��� ������ 10 �����. ������ ������ ������������ ��������� ������� �� <b class="text-danger"><?=$bonus_min/1000;?></b> �� <b class="text-success"><?=$bonus_max/1000;?></b> ���.
<center><h2><font color="#30a758" id="bounce"></font></h2></center>
</center>
<div id="btn">
<?PHP
$ddel = time() + 600;
$dadd = time();
$db->Query("SELECT COUNT(*) FROM db_bonus_list WHERE user_id = '$usid' AND date_del > '$dadd'");

$hide_form = false;

	if($db->FetchRow() == 0){

			$db->Query("DELETE FROM db_bonus_list WHERE date_del < '$dadd'");
			
			# ���������� ��� ��� �����
			if(!$hide_form){
?>
<script type="text/javascript"> 
function showLinks(el,id){var linkBox=document.getElementById(id).style.display='block';el.style.display='none';} 
</script> 
<style type="text/css"> 
.banerBox{cursor:pointer;
width:468px;} 
.myLinkBox{display:none;} 
</style>
<center>
<?
//<div class="banerBox"> 
//<p class="text-muted">������� �� ������ ��� ��������� ������</p>
//<div id="linkslot_224334" onclick="showLinks(this,'linkBox');"><script src="https://linkslot.ru/bancode.php?id=224334" async></script></div>
//</div> 
//<div id="linkBox" class="myLinkBox">
//<button id="bonusform" name="bonus" class="epcl-shortcode epcl-button regular outline green">������� �����</button>
//</div>
?>
<button id="bonusform" name="bonus" class="epcl-shortcode epcl-button regular outline green" style="width: 40%;">������� �����</button>
<br><br>
</center>
<?PHP 

			}

	}else 
	{
	   // echo "<center><font color = '#b06100'>�� ��� �������� ����� �� ��������� ���</font></center><BR />";
$db->Query("SELECT * FROM db_bonus_list WHERE user_id = '$usid' AND date_del > '$dadd'");
$u_data = $db->FetchArray();
$time = $u_data['date_del'] - $dadd;
$time2 = $u_data['date_del'];
	    ?>
		<hr>
<center><p id="bounce2"><i class="fa fa-clock"></i> ��������� ����� � <?=date("H:i",$time2); ?></p></center>
		<hr>
        <?php
	}
?>
</div>
					<div class="thw-autohr-bio" id="refr_table">
                      <table style="width: 100%;">
  <?PHP
  
  $db->Query("SELECT * FROM db_bonus_list ORDER BY id DESC LIMIT 20");
  
	if($db->NumRows() > 0){
  
  		while($bon = $db->FetchArray()){
		
		?>
<h4>
<div class="grid-25">
<small>ID<br><span>#<?=$bon["id"]; ?></span></small>
</div>
<div class="grid-25">
<small>�������<br><span><?=$bon["purse"]; ?></span></small>
</div>
<div class="grid-25">
<small>�����<br><span> <?=sprintf("%.2f",$bon["sum"]); ?></span> <font color="#f9234b"><b>RUB</b></font></small>
</div>
<div class="grid-25">
<small>����<br><span><?=date("H:i",$bon["date_add"]); ?></span></small>
</div>
</h4>
<br>
		<?PHP
		
		}
  
	}else echo '<tr><td align="center" colspan="5">��� ����� �� ������� �����</td></tr>'
  ?>
                      </table>
					</div>
				</div>			
			</article>
		</div>
<script type="text/javascript">
    $(document).ready(function(){
            $("#bonusform").click(function() {
                $.ajax({
                    url: "../ajax/ajaxbonus.php",
                    type: "POST",
                    success: function(data){
                    if (data) {
					$("#bounce").text(" "+data+" ").addClass("animated bounceIn");
					$("#bounce2").text(" "+data+" ").addClass("animated fadeInUp");
                    $('#refr_table').load('# #refr_table');
					$('#btn').load('# #btn');
					$('#balance').load('# #balance');
                  
                    }else {
                        $("#err").text("������ 2");
                    }
                    },
                    error: function(){          
                alert("������ �� ��������!");          
                }
                });
              
            });
    });
</script>