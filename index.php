<?php
	ob_start();
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!--==============Slider1===================================================================================================-->

<!--==============end Slider1===================================================================================================-->

<?php require_once("include/metadata.php"); ?>
<title>Buononavi, Cambodian Restaurant Navigator</title>
<link rel="shortcut icon" href="icon.png">
<link href="style/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/slider.css" type="text/css" media="screen" charset="utf-8">
<link href="css/display.css" rel="stylesheet" type="text/css" />
<link href="css/resprofile.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>

<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-22830470-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>


<?php

//if(isset($_GET['dis'])){
//	if($_GET['dis']=='home'){
	//echo "<script src='js/slider.js' type='text/javascript' charset='utf-8'>/script>";
	//}
//}

?>
<script language="javascript">
	var st_search="Search...";
	window.onload=init;
	function init(){
		document.getElementById("txtsearch").value=st_search;
		
	}
</script>
<!--ScrollDemo-->
<style type="text/css">
#scrollup {
  position: relative;
  	overflow: hidden;
  	border: 1px solid #000;
  	height: 400px;
}
.headline {
  position: absolute;
  	top: 210px;
	
	display: block;
	color: #09C;
	text-align: left;
	font-size: 14px;
	padding: 10px 10px 10px 10px;
	margin: 5px 5px 5px 5px;
	border: 2px #e3e3e3 dotted;
}
</style>
<script type="text/javascript">
/*
var headline_count;
var headline_interval;
var old_headline = 0;
var current_headline = 0;
var per_page = 4;
var index = 0;

$(document).ready(function(){
  	headline_count = $("div.news_update_desc").size();
	
  	$("div.news_update_desc:eq("+current_headline+")").css('top', '0px');
   	$("div.news_update_desc:eq("+(current_headline+1)+")").css('top', '80px');
    $("div.news_update_desc:eq("+(current_headline+2)+")").css('top', '160px');
	$("div.news_update_desc:eq("+(current_headline+3)+")").css('top', '240px');
	$("div.news_update_desc:eq("+(current_headline+4)+")").css('top', '320px');
 
  headline_interval = setInterval(headline_rotate,5000);
	$('#news_update').hover(function() {clearInterval(headline_interval);}, 
		function() {
    		headline_interval = setInterval(headline_rotate,5000);
    		headline_rotate();
  	});
});

function headline_rotate() {
  current_headline = (old_headline + 1) % headline_count;
  //alert(current_headline + '_' + old_headline);
  //var i = 0;
  //for(i=0;i<per_page;i++){
	  $("div.news_update_desc:eq(" + (old_headline) + ")")
		.animate({top: -205},"slow", function() {//top: -205
		  $(this).css('top', '310px');
		});
		
		
	  $("div.news_update_desc:eq(" + (current_headline) + ")").animate({top: 0},"slow");  
	  $("div.news_update_desc:eq(" + (current_headline + 1) + ")").animate({top: 80},"slow");  
	  $("div.news_update_desc:eq(" + (current_headline + 2) + ")").animate({top: 160},"slow");  
	  $("div.news_update_desc:eq(" + (current_headline + 3) + ")").animate({top: 240},"slow");  
	  $("div.news_update_desc:eq(" + (current_headline + 4) + ")").animate({top: 320},"slow");

	  old_headline = current_headline;
  //}
}
*/
var headline_count;
var headline_interval;
var old_headline = 0;
var current_headline=0;
var headlines = new Array(); // an array of jQuery objects
var index = 0;
var per_page = 5;
$(document).ready(function(){
  headline_count = $("div.news_update_desc").size();

  for (var i = 0; i < headline_count; i++) {
	
    headlines[i] = $("div.news_update_desc:eq("+i+")");
	headlines[current_headline+i].css('top', index+'px');
	index = index+80;
  }
/*
  headlines[current_headline].css('top', '0px');
  headlines[current_headline].css('top', '80px');
  headlines[current_headline].css('top', '160px');
  headlines[current_headline].css('top', '240px');
  headlines[current_headline].css('top', '320px');
*/
  headline_interval = setInterval(headline_rotate,4000);
  $('#news_update').hover(function() {
    clearInterval(headline_interval);
  }, function() {
    headline_interval = setInterval(headline_rotate,4000);
    headline_rotate();
  });
});
function headline_rotate() {
  current_headline = (old_headline + 1) % headline_count;
  //alert(current_headline);
  headlines[old_headline].animate({top: -205},"slow", function() {
    $(this).css('top','410px');
    });
  
  //headlines[current_headline].show.animate({top: 5},"slow");
 	  $("div.news_update_desc:eq(" + (current_headline) + ")").animate({top: 0},"slow");  
	  $("div.news_update_desc:eq(" + (current_headline + 1) + ")").animate({top: 80},"slow");  
	  $("div.news_update_desc:eq(" + (current_headline + 2) + ")").animate({top: 160},"slow");  
	  $("div.news_update_desc:eq(" + (current_headline + 3) + ")").animate({top: 240},"slow");  
	  $("div.news_update_desc:eq(" + (current_headline + 4) + ")").animate({top: 320},"slow");
  old_headline = current_headline;
}
</script>
<!--end ScrollDemo-->
</head>
<?php
if(isset($_GET['dis'])){
	if($_GET['dis']=="map"){
		$city="";
		if(isset($_GET['city'])){
			$city=$_GET['city'];
		}
?>
		<body onload="show_map('<?php echo $city; ?>','')" onunload="close_map()">
<?php
	}
}
else{
	echo "<body>";
}
?>
<?php
require_once("connection/connection.php");
require_once("module/modules.php");
connectDB();
?>
<div id="wraper" >
	<div class="topbanner">
        <div id="top"><?php include("include/top.php"); ?></div>    
    	<?php include("include/menu.php"); ?>
		<hr />
    </div> 
         
<!--Main Table-->
<table border="0px" width="93%" height="100%"  bordercolor="#FF0000" cellpadding="0" cellspacing="0">
	<tr valign="top"><!--row 1-->
<!--=========================================================================================================================================================-->
		<td width="150px"><!--category (left)-->
			<?php require_once("include/list_category.php");?>
		</td><!--end category (left)-->
<!--=========================================================================================================================================================-->
<!--==Slider==========================================================================================================================================-->                       
<?php include("include/viewlist.php"); ?>
<?php
if($dis=='home') //start if($dis=='home')
{
echo '<td valign="top">';
/*++Display Top3 Restaurants+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
		$pop = $_GET['pop'];
		require_once("include/filter_restaurant.php");
		echo '<div class="top_block">';
			echo '<table border="0" width="100%" height="200px">';
				echo '<tr>';
					echo '<td class="top_res" width="50%" valign="top">';
					/*Month Declaraton*/
					function get_last_day($year, $last_month){
 						$timestamp = strtotime("$year-$last_month-01");
    					$number_of_days = date('t',$timestamp);
    					return $number_of_days;
					}
					//$last_month=date('m')-1;
					//Monthly
					$current_momth = date('m');
					$last_month = ($current_momth==1 ? 12: $current_momth-1);		
					$year=date('Y');
					$first_date = "$year-$last_month-01";
					$last_date = "$year-$last_month-".get_last_day($year,$last_month);
					$month_name = date( 'F', mktime(0, 0, 0, $last_month) );
					/*end Month Declaraton*/
					
					echo '<div class="my_label"><img src="images/rlabelicon.png" />Most Popular in '.$month_name.'</div>';			
					/*
					$q_top_res = "SELECT Res.restaurant_id, Res.restaurant_name, Res.restaurant_type, Res.restaurant_available,		
												Top.on_toplist,Top.activated
												FROM tbl_restaurants AS Res
												Inner Join tbl_restaurant_settings AS Top ON Res.restaurant_id= Top.restaurant_id
												WHERE Top.on_toplist='1' AND Top.activated='1' 
												LIMIT 0,3";
					*/
					$q_top_res = "SELECT Res.restaurant_id, Res.restaurant_name, Res.restaurant_type, Res.restaurant_available,		
									Cou.count_value, Cou.count_date
									FROM tbl_restaurants AS Res
									Inner Join tbl_counts AS Cou ON Res.restaurant_id= Cou.restaurant_id 
									WHERE Cou.count_date BETWEEN '$first_date' AND '$last_date' 
									GROUP BY restaurant_id
									ORDER BY SUM(Cou.count_value) DESC LIMIT 0,3";
									//WHERE Cou.count_date  BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()
						display_TopRestaurant($q_top_res);
					echo '</td>';
					
					echo '<td width="50%" align="center" valign="top">';
					?>
<!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++--
<div id="scrollup">
  <div class="headline">Royal University of Phnom Penh1 </div>  
  <div class="headline">Royal University of Phnom Penh2 </div>  
  <div class="headline">Royal University of Phnom Penh3 </div>  
  <div class="headline">Royal University of Phnom Penh4 </div>    
</div>
<!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->					
                    <?php

						$q_newsupdated = getResultSet("SELECT DISTINCT restaurant_id, news_title, news_description FROM tbl_restaurant_news GROUP BY restaurant_id ORDER BY news_id DESC LIMIT 0,10");// 
						display_NewsUpdate($q_newsupdated);
					echo '</td>';
				echo '</tr>';
			echo '</table>';
		 //display_toplist($sql_pop,12); 
		echo '</div>';
/*++END Display Top3 Restaurants+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*==Staff Recommendation============================================================================================*/
		echo '<div class="my_label"><img src="images/rlabelicon.png" />Staff Recommend</div>';
		echo '<div class="top_recommedation_block">';
			echo '<table border="0" width="100%">';
				echo '<tr>';
					$q_top_res = getResultSet("SELECT Res.restaurant_id, Res.restaurant_name, Res.restaurant_type, Res.restaurant_available,		
												Top.on_toplist,Top.activated, Top.on_pickup
												FROM tbl_restaurants AS Res
												Inner Join tbl_restaurant_settings AS Top ON Res.restaurant_id= Top.restaurant_id
												WHERE Top.on_pickup = '1' OR Top.on_pickup = '2' OR Top.on_pickup = '3' AND Top.activated='1' 
												ORDER BY Top.on_pickup ASC LIMIT 0,3");//Top.on_toplist='1' AND Top.activated='1' 
					display_StaffRecommendation($q_top_res);
				echo '</tr>';
			echo '</table>';
		 //display_toplist($sql_pop,12); 
		echo '</div>';
/*==END Staff Recommendation============================================================================================*/


echo '<div class="my_label"><img src="images/rlabelicon.png" />In Focus</div>';
?>  	 
<link rel="stylesheet" type="text/css" href="style/styleSlide.css" media="all">
<link href="style/localNavi.css" type="text/css" rel="stylesheet" media="screen,print">

<script src="js/slide/jquery_slide.js" type="text/javascript"></script>
<script src="js/slide/jquery_slide1.js" type="text/javascript"></script>
<script src="js/slide/slideshow.js" type="text/javascript"></script>

<!--start movingBox-->
<!--
<div id="wrapper" style="border: 1px #00f solid; vertical-align: bottom;">
-->
<div id="hcsBtmTopics" style="border: 0px #F00 solid;">
<div class="slider-wrap">
<div class="stripNavL"><a id="stripNavL0" href="#">Left</a></div>
<div class="stripNav"></div>
<div id="slider1" class="stripViewer">
<div class="panelContainer">

<div class="panel">
<div class="wrapper" style="border: 0px #00f solid;">

<div id="slideshow">
<div class="slides">
<ul style="position: relative;height: 270px; overflow: hidden;" class="topicsItem">
<?php
								
				$sql_recommand = "SELECT Res.restaurant_id, Res.restaurant_name, Res.restaurant_type, Res.restaurant_available,		
					Top.on_slide,Top.activated
					FROM tbl_restaurants AS Res
					Inner Join tbl_restaurant_settings AS Top ON Res.restaurant_id= Top.restaurant_id
					WHERE Top.on_slide='1' AND Top.activated='1' 
					ORDER BY RAND()";
				
                $q_recommand = getResultSet($sql_recommand);
                $total = mysql_num_rows($q_recommand);
				$arr = array("","one","two","three","four","five","six","seven","eight","nine","ten");
                $sub_rec = 10 - $total;
                $res_desc="";
                $res_name="";
				$id =0;
				while($row = mysql_fetch_array($q_recommand))
				{
					$id = $id + 1;
					$res_id = $row['restaurant_id'];
					
					$q_res_desc =getResultSet("SELECT Res.restaurant_id,Res.restaurant_name,Res.restaurant_description FROM tbl_restaurants AS Res  
											WHERE restaurant_id= '$res_id' ");
											
					$q_attached_file_path = getValue("SELECT attached_file_path FROM tbl_attached_files WHERE attached_type='restaurant_profile' and restaurant_id = $res_id");
	
					if (!file_exists($q_attached_file_path)) {$q_attached_file_path = "images/image_not_found.jpg";} 					
					$img_path = $q_attached_file_path;
					if (($id%2)!=0) 
					{					
						echo '<div style="top: 0px; left: -770px; display: none; z-index:5; opacity: 1; width: 770px; height:227px;" id="slide-' . $arr[$id] . '">';
					}
						echo  '<li>';
						//echo	'<a href="http://www.google.com">';
								echo '<a href="'.getUrl($res_id).'">';
								echo '<img src="'. $img_path . '" /> </a>';
								echo '<div class="textBox"> ';
									
					if(strlen($res_desc)>120){$dots="...";}else{$dots="";} 
					while($r_res_info=mysql_fetch_array($q_res_desc))
					{
						$res_name = str_replace(";"," ",$r_res_info['restaurant_name']);
						$res_desc = ltrim($r_res_info['restaurant_description']);
						$res_desc = rtrim($res_desc);
						echo '<div style="height:105px;"><h4>'.$res_name.'</h4>';
						echo '<p>'.substr($res_desc,0,120).$dots.'</p></div>';
						echo '<p class="num">' . $id .'/'.$total.'</p>';
						echo		'</div> '; // close textBox
						echo	'</li>';						
						
					}					
				   if (($id%2)==0) { echo	'</div> '; }
			}
?>

</ul><!-- /.topicsItem -->
</div> <!--/slides -->
</div><!--/slideshow -->
</div> <!--/ wrapper -->
</div><!--/panel-->

</div><!-- .panelContainer -->
</div><!-- #slider1 -->
<div class="stripNavR"><a id="stripNavR0" href="#">Right</a></div>
<div class="stripEmpty" style=" z-index:200;"><div class="fix_height"></div></div>

</div><!-- .slider-wrap -->
</div>
<br />
<!--end movingBox-->

<!-- /#hcsTopTopics --><!--/ banner -->
<!--==end Slider==========================================================================================================================================-->                       

<?php
	echo "</td>";
}	//stop if($dis=='home')	
?>

<!--==============================================================================================================================================================-->
<?php
	require_once("include/category.php");
?>
<!--==create_page_nav============================================================================================================================================================-->
<!--==END create_page_nav============================================================================================================================================================-->
</table><!--End Main Table-->
<br>
</div>
<?php
	include("include/footer.php");
?>
	<div id="bg">
		<img src="background_image/bg.jpg">
    </div>
</body>
</html>