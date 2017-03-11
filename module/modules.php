<?php
$error_upload_file=array("* Upload Successfully","* File size is too big","* This file type is not allowed","* Error while uploading");
$commentSubject ="";

/*function getDiffTime($postdate){
	$postdate = new DateTime($postdate);
	$today = new DateTime(getDateTime());
	$dateDiff = $today->diff($postdate);
	$ph = $dateDiff->format("%h");
	$pm = $dateDiff->format("%i");
	$ps = $dateDiff->format("%s");
	if($ph<= 168){
		if($ph<=24){
			if($ph ==0){
				if($pm ==0){
					if($ps <=1)$postdate = $ps." second ago";
					else $postdate = $ps." seconds ago";
				}
				else{
					if($pm ==1)$postdate = $pm." minute ago";
					else $postdate = $pm." minutes ago";
				}
			}
			else{
				if($ph ==1)$postdate = $ph." hour ago";
				else $postdate = $ph." hours ago";
			}
		}
		else
			$postdate = "On ".date("D",strtotime($postdate));		
	}
	else $postdate = "On ".$postdate;
	return $postdate;
}
*/
/*RUN*/
function cutString($str,$numChar)
{
	if(strlen($str)>$numChar){$dot="...";} else{$dot="";}
	$str = substr($str,0, $numChar).$dot;
	return $str;
}
/*RUN*/
function getDiffTime($d){
	$today=date_parse(getDateTime());
	$min_year=1;
	$second_of_today=(($today['year']-$min_year)*31557600*60)+($today['month']*30*24*3600)+($today['day']*24*3600)+($today['hour']*3600)+($today['minute']*60)+$today['second'];
	//if($second_of_today<172800){
		$date=date_parse($d);
		$second_of_date=(($date['year']-$min_year)*31557600*60)+($date['month']*30*24*3600)+($date['day']*24*3600)+($date['hour']*3600)+($date['minute']*60)+$date['second'];;
		$diff=$second_of_today-$second_of_date;
		//echo "<br/>".$diff."<br/>";
		if($diff<60) return $diff." seconds ago";
		elseif($diff>=60 && $diff<3600) return ceil($diff/60) . " minutes ago";
		elseif($diff>=3600 && $diff<3600*24) return ceil($diff/3600)." hours ago";
		elseif($diff>=(3600*24) && $diff<3600*24*30) return ceil($diff/(3600*24))." days ago";
	//}
	else{
		return $date['day']."/".$date['month'].'/'.$date['year'];
	}
}


function getHack(){
	//header("location:../module/hack.php");
	include("../module/hack.php");
	exit();
}
function connectDB(){
	$cn=mysql_connect(HOST_NAME,USER_NAME,USER_PASSWORD) or die("Cannot connect to DB");
	$cn=mysql_select_db(DB_NAME) or die("cannot select database");
}
function runSQL($str){
	connectDB();
	mysql_query($str) or die("cannot execute statement: $str<br/>".mysql_error());
}
function getResultSet($str){
	connectDB();
	$rs=mysql_query($str) or die("cannot select: $str ".mysql_error());
	return $rs;
}
function getValue($str){
	$rs=getResultSet($str);
	while ($row = mysql_fetch_array($rs,MYSQL_NUM)) {
		return $row[0];
	}
}

function getDateTime(){
	return date("Y-m-d H:i:s");
}
function getToday(){
	return date("Y-m-d");
}
function getTime(){
	return date("H:i:s");
}
function autoID($tbname,$fname){
	
}
function randomID($tbname,$fname){
	$val=random(0,1999999999);
	while(getValue("select $fname from $tbname where $fname=$val")!=""){
		$val=random(0,1999999999);
	}
	return $val;
}
function random($min,$max){
	return rand($min,$max);
}
function getHeader($s){
	return substr($s,0,5);
}
function getPassword($s){
	return substr($s,5,strlen($s)-5);
}
function sqlStr($s){
	$rev="'".$s."'";
	return $rev;
}
function sentForgotPassword($to){
	$subject = 'Forgot Password :: buononavi';
	$username=getValue("select user_email from tbl_users where user_name='".$username."'");
	$key=md5($to);
	runSQL("update tbl_users set user_activatekey='$key' where user_email='$to'");
	$message ="<html><head><title>Forgot Password :: buononavi</title></head><body>
	<p>
Hello ! $username<br/>
<br/>
You have request for resetting new password<br/>
<br/>
Clink this link to input new password. <a href='http://buononavi.com/main/forgot.php?key=$key'>Reset</a>
<br/>
<br/>
<br>
<br>
<hr>
Cheer !!
</p></body></html>";
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'To:'.$to. "\r\n";
$headers .= 'From: no-reply@buononavi.com' . "\r\n";
	try{
		if(mail($to, $subject, $message, $headers)){
			return true;
		}
		else{
			return false;
		}
	}
	catch(Exception $ex){
		
	}
}
function sendEmailActivateAccount($to,$username,$password){
	$subject = 'New Member from buononavi.com';
	$key=getValue("select user_activatekey from tbl_users where user_name='".$username."'");
	$message ="<html><head><title>New Member</title></head><body>
	<p>
Dear Sir/Madam;<br/>
<br/>
You have registered at <a href='http://www.buononavi.com' target='_blank'>www.buononavi.com</a><br/>
<br/>
Your account information:<br/>
<strong>User Name</strong>: ".$username."<br/>
<strong>Password</strong>: ".$password."
<br/>
<br/>
Click this link to activate your account &nbsp;<a href='http://buononavi.com/main/register.php?activatekey=".$key."'>Active</a>
<br>
<br>
<hr>
Cheer !!
</p></body></html>";
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'To:'.$to. "\r\n";
$headers .= 'From: no-reply@buononavi.com' . "\r\n";
	try{
		if(mail($to, $subject, $message, $headers)){
			return true;
		}
		else{
			return false;
		}
	}
	catch(Exception $ex){
		
	}
}
function getFileType($path){
	$temp=explode(".",$path);
	return $temp[count($temp)-1];
}
?>


<?php
// ***** Page Method ********


// ***** End of Page Method *********
function upload($id,$path){
	$result=0;
	$allowtype=array("jpg","jpeg","gif","png");
	
	$filename=$_FILES[$id]['name'];
	$filename=str_replace("#","_",$filename);
	$filename=str_replace("$","_",$filename);
	$filename=str_replace("%","_",$filename);
	$filename=str_replace("^","_",$filename);
	$filename=str_replace("&","_",$filename);
	$filename=str_replace("*","_",$filename);
	$filename=str_replace("?","_",$filename);
	$filename=str_replace(" ","_",$filename);
	$filename=str_replace("!","_",$filename);
	$filename=str_replace("@","_",$filename);
	$filename=str_replace("(","_",$filename);
	$filename=str_replace(")","_",$filename);
	$filename=str_replace("/","_",$filename);
	$filename=str_replace(";","_",$filename);
	$filename=str_replace(":","_",$filename);
	$filename=str_replace("'","_",$filename);
	$filename=str_replace("\\","_",$filename);
	$filename=str_replace(",","_",$filename);
	$filename=str_replace("+","_",$filename);
	$filename=str_replace("-","_",$filename);
	$filesize=$_FILES[$id]['size'];
	$filetype=end(explode(".",strtolower($filename)));
	if(!in_array($filetype,$allowtype)){
		$result="2;";
	}
	if($filesize>$_POST['MAX_FILE_SIZE'] || $filesize==0){
		$result="1;";
	}
	if($result==0){
		$subfolder=date("Y_m_d_H_i_s");
		$path=$path.$subfolder."/";
		mkdir($path,0777,true);
		if(move_uploaded_file($_FILES[$id]['tmp_name'],$path.$filename)){
			$result=$result.";".$path.$filename;
		}
		else{
			$result="3;";
		}
	}
	return $result;
}



function updateNotification($userid,$update,$addnew,$comment){
	connectDB();
	mysql_query("UPDATE tbl_notifications SET notification_whenupdate=$update, notification_whenaddednew=$addnew, notification_whencomment=$comment WHERE user_id=$userid");
}

function insertNotification($userid,$update,$addnew,$comment){
	connectDB();
	mysql_query("INSERT INTO tbl_notifications VALUES($userid,$update,$addnew,$comment)");
}
function deleteNotification($userid){
	connectDB();
	mysql_query("DELETE FROM tbl_notifications WHERE user_id=$userid");
}

function insertView($userid,$resid,$viewdate){
	connectDB();
	mysql_query("INSERT INTO tbl_views(user_id,restaurant_id,view_date)	VALUES( $userid,$resid,'$viewdate')");
}

function deleteView($resid){
	connectDB();
	mysql_query("DELETE FROM tbl_views WHERE restaurant_id=$resid");
}

function insertFavorite($userid,$resid,$favorite,$date){
	connectDB();
	mysql_query("INSERT INTO tbl_favorites VALUES($userid,$resid,$favorite,'$date')");	
}

function unFavorite($userid,$resid,$favorite,$date){
	connectDB();
	mysql_query("UPDATE tbl_favorites SET isfavorite=$favorite ,favorite_date='$date' WHERE user_id=$userid AND restaurant_id=$resid"); 
}
function deleteFavorite($userid,$resid){
	connectDB();
	mysql_query("DELETE FROM tbl_favorites WHERE user_id=$userid AND restaurant_id=$resid");	
}

function rating($n,$resID){
		$n = $n*25;
		echo "<ul class='star-rating'>";
			echo "<li class='current-rating' id='current-rating' style='width: ".$n."px;'></li>";			
			echo "<li><a href='#' onclick='return voteRes(1,$resID)' title='1 star out of 5' class='one-star'>1</a></li>";
			echo "<li><a href='#' onclick='return voteRes(2,$resID)' title='2 star out of 5' class='two-stars'>2</a></li>";
			echo "<li><a href='#' onclick='return voteRes(3,$resID)' title='3 star out of 5' class='three-stars'>3</a></li>";
			echo "<li><a href='#' onclick='return voteRes(4,$resID)' title='4 star out of 5' class='four-stars'>4</a></li>";
			echo "<li><a href='#' onclick='return voteRes(5,$resID)' title='5 star out of 5' class='five-stars'>5</a></li>";
		echo "</ul>";
		//echo "</div>";
	}
	
//////////////////////////////////////
//rating food
function all_food_rating($n,$rid,$uid){
		$n = $n*25;
		echo "<ul class='star-rating'>";
			echo "<li class='current-rating' id='current-rating' style='width: ".$n."px;'></li>";			
			echo "<li><a href='#' onclick='return allVoteFood(1,$rid,$uid)' title='1 star out of 5' class='one-star'>1</a></li>";
			echo "<li><a href='#' onclick='return allVoteFood(2,$rid,$uid)' title='2 star out of 5' class='two-stars'>2</a></li>";
			echo "<li><a href='#' onclick='return allVoteFood(3,$rid,$uid)' title='3 star out of 5' class='three-stars'>3</a></li>";
			echo "<li><a href='#' onclick='return allVoteFood(4,$rid,$uid)' title='4 star out of 5' class='four-stars'>4</a></li>";
			echo "<li><a href='#' onclick='return allVoteFood(5,$rid,$uid)' title='5 star out of 5' class='five-stars'>5</a></li>";
		echo "</ul>";
		//echo "</div>";
	}
	
	function all_service_rating($n,$rid,$uid){
		$n = $n*25;
		echo "<ul class='star-rating'>";
		
			echo "<li class='current-rating' id='current-rating' style='width: ".$n."px;'></li>";			
			echo "<li><a href='#' onclick='return allVoteService(1,$rid,$uid)' title='1 star out of 5' class='one-star'>1</a></li>";
			echo "<li><a href='#' onclick='return allVoteService(2,$rid,$uid)' title='2 star out of 5' class='two-stars'>2</a></li>";
			echo "<li><a href='#' onclick='return allVoteService(3,$rid,$uid)' title='3 star out of 5' class='three-stars'>3</a></li>";
			echo "<li><a href='#' onclick='return allVoteService(4,$rid,$uid)' title='4 star out of 5' class='four-stars'>4</a></li>";
			echo "<li><a href='#' onclick='return allVoteService(5,$rid,$uid)' title='5 star out of 5' class='five-stars'>5</a></li>";
		echo "</ul>";
		//echo "</div>";
	}
	
	function atmosphere_rating($n,$rid,$uid){
		$n = $n*25;
		echo "<ul class='star-rating'>";
			echo "<li class='current-rating' id='current-rating' style='width: ".$n."px;'></li>";			
			echo "<li><a href='#' onclick='return VoteAtmosphere(1,$rid,$uid)' title='1 star out of 5' class='one-star'>1</a></li>";
			echo "<li><a href='#' onclick='return VoteAtmosphere(2,$rid,$uid)' title='2 star out of 5' class='two-stars'>2</a></li>";
			echo "<li><a href='#' onclick='return VoteAtmosphere(3,$rid,$uid)' title='3 star out of 5' class='three-stars'>3</a></li>";
			echo "<li><a href='#' onclick='return VoteAtmosphere(4,$rid,$uid)' title='4 star out of 5' class='four-stars'>4</a></li>";
			echo "<li><a href='#' onclick='return VoteAtmosphere(5,$rid,$uid)' title='5 star out of 5' class='five-stars'>5</a></li>";
		echo "</ul>";
		//echo "</div>";
	}
	

	function value_rating($n,$rid,$uid){
		$n = $n*25;
		echo "<ul class='star-rating'>";
			echo "<li class='current-rating' id='current-rating' style='width: ".$n."px;'></li>";			
			echo "<li><a href='#' onclick='return VoteValue(1,$rid,$uid)' title='1 star out of 5' class='one-star'>1</a></li>";
			echo "<li><a href='#' onclick='return VoteValue(2,$rid,$uid)' title='2 star out of 5' class='two-stars'>2</a></li>";
			echo "<li><a href='#' onclick='return VoteValue(3,$rid,$uid)' title='3 star out of 5' class='three-stars'>3</a></li>";
			echo "<li><a href='#' onclick='return VoteValue(4,$rid,$uid)' title='4 star out of 5' class='four-stars'>4</a></li>";
			echo "<li><a href='#' onclick='return VoteValue(5,$rid,$uid)' title='5 star out of 5' class='five-stars'>5</a></li>";
		echo "</ul>";
		//echo "</div>";
	}
	

/////////////////////////////////////
	function subrating($n,$iID,$subname,$rID){
		$n = $n*15;
		//echo $n.";".$iID.";".$subname;
		echo "<ul class='substar-rating'>";
		echo "<li class='current-rating' id='current-rating' style='width: ".$n."px;'></li>";
		if(substr_compare($subname,"food",0)==0){						
			echo "<li><a href='#' onclick='return voteFood(1,$iID,$rID);' title='1 star out of 5' class='one-star'>1</a></li>";
			echo "<li><a href='#' onclick='return voteFood(2,$iID,$rID);' title='2 star out of 5' class='two-stars'>2</a></li>";
			echo "<li><a href='#' onclick='return voteFood(3,$iID,$rID);' title='3 star out of 5' class='three-stars'>3</a></li>";
			echo "<li><a href='#' onclick='return voteFood(4,$iID,$rID);' title='4 star out of 5' class='four-stars'>4</a></li>";
			echo "<li><a href='#' onclick='return voteFood(5,$iID,$rID);' title='5 star out of 5' class='five-stars'>5</a></li>";
		}
		else{
			echo "<li><a href='#' onclick='return voteService(1,$iID,$rID);' title='1 star out of 5' class='one-star'>1</a></li>";
			echo "<li><a href='#' onclick='return voteService(2,$iID,$rID);' title='2 star out of 5' class='two-stars'>2</a></li>";
			echo "<li><a href='#' onclick='return voteService(3,$iID,$rID);' title='3 star out of 5' class='three-stars'>3</a></li>";
			echo "<li><a href='#' onclick='return voteService(4,$iID,$rID);' title='4 star out of 5' class='four-stars'>4</a></li>";
			echo "<li><a href='#' onclick='return voteService(5,$iID,$rID);' title='5 star out of 5' class='five-stars'>5</a></li>";
		}
		echo "</ul>";
	}
	
	function showrate($n){
		$n = $n*25;		
		echo "<ul class='star-rating'>";
		echo "<li class='current-rating' id='current-rating' style='width: ".$n."px;'></li></ul>";
	}
	
	function subrate($n){
		$n = $n*15;		
		echo "<ul class='substar-rating'>";
		echo "<li class='current-rating' id='current-rating' style='width: ".$n."px;'></li></ul>";
	}

function change_email_sendemail(){
	
}
function getLastLogin($id){
	$date=getValue("select user_lastlogin from tbl_users where user_id=$id");
	return $date;
}

function countUser(){
	$session=session_id();
	$time=time();
	$time_check=$time-60;
	$sql="select * from tbl_user_online where session='$session'";
	$result=getResultSet($sql);
	$count=mysql_num_rows($result);
	if($count==0){
		$sql1="INSERT INTO tbl_user_online(session, time)VALUES('$session', '$time')";
		runSQL($sql1);
	}
	else{
		$sql2="UPDATE tbl_user_online SET time='$time' WHERE session = '$session'";
		runSQL($sql2);
	}
	$sql3="select * from tbl_user_online";
	$result3=getResultSet($sql3);
	$count_user_online=mysql_num_rows($result3);
	$sql4="Delete from tbl_user_online where time<$time_check";
	runSQL($sql4);

	return $count_user_online;
	
	//return $session;
}

function prevent_include(){
	/*$url=$_SERVER['SCRIPT_NAME'];
	if(strpos($url,'include')!=""){
		$filename=basename($url);
		$filelist=scandir("../");
		if(in_array($filename,$filelist)==true){
			echo 'redirect';
			exit();
		}
	}*/
}


/*------------------------------------------------------------------------
Structure of Message:
Subject: Restaurant is updated
Content:
Dear Sir/Madam
$restaurant_name has update its content
Click this link to see this restaurant. (Link to $restaurant_name)

Best Regard



------------------------------------------------------------------------*/


function sendAddNew($usrid,$AddNewSubject,$AddNewInfo){
	if(getAddNewNotification($usrid)==1){
		//send addnew Info
	}
}

function sendUpdate($usrid,$resID){
    $res_name=getValue("SELECT restaurant_name FROM tbl_restaurants WHERE restaurant_id= $resID");   
    $subject = "Restaurant has been updated :: buononavi";
    $uid="";
    $rs = getResultSet("SELECT user_id FROM tbl_notifications WHERE notification_whenupdate=1");
    $today=getDateTime();
    runSQL("UPDATE tbl_restaurants SET restaurant_lastupdate='".$today."' WHERE restaurant_id=$resID");
    while($r = mysql_fetch_array($rs)){
        //send updateInfo       
        $uid=$r[0];
        if(getUpdateNotification($uid)){
            $username=getValue("SELECT user_name FROM tbl_users WHERE user_id = $uid");
            $to = getValue("SELECT user_email FROM tbl_users WHERE user_id = $uid");
            $message ="<html><head><title>Restaurant has been updated :: buononavi</title></head><body>
            <p>
            Dear $username:<br/>
            <br/>       
            $res_name has been updated its content.
            Click <a href='http://".DOMAIN."/".ROOT."/restaurant.php?resID=$resID'>here</a> to see this restaurant.
            <br/>
            <br/>       
            Best Regard,
            </p></body></html>";
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'To:'.$to. "\r\n";
            $headers .= 'From: no-reply@buononavi.com' . "\r\n";
            try{
                if(mail($to, $subject, $message, $headers)){
                    return true;
                }
                else{
                    return false;
                }
            }
            catch(Exception $ex){
               
            }
        }
    }
}

function sendComment($usrid,$resID){
    $res_name=getValue("SELECT restaurant_name FROM tbl_restaurants WHERE restaurant_id= $resID");   
    $subject = "Restaurant has been updated :: buononavi";
    $uid="";
    $rs = getResultSet("SELECT user_id FROM tbl_notifications WHERE notification_whencomment=1");
    while($r = mysql_fetch_array($rs)){
        //send updateInfo
        $uid=$r[0];
        if(getAddNewNotification($uid)){
           
            $username=getValue("SELECT user_name FROM tbl_users WHERE user_id = $uid");
            $to = getValue("SELECT user_email FROM tbl_users WHERE user_id = $uid");
            $message ="<html><head><title>Commented on restaurant :: buononavi</title></head><body>
            <p>
            Dear $username:<br/>
            <br/>       
            $res_name has been commented.
            Click <a href='http://".DOMAIN."/".ROOT."restaurant.php?resID=$resID#comments'>here</a> to see this restaurant.
            <br/>
            <br/>       
            Best Regard,
            </p></body></html>";
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'To:'.$to. "\r\n";
            $headers .= 'From: no-reply@buononavi.com' . "\r\n";
            try{
                if(mail($to, $subject, $message, $headers)){
                    return true;
                }
                else{
                    return false;
                }
            }
            catch(Exception $ex){
               
            }
        }
    }
}
function getUpdateNotification($usrid){
	return getValue("SELECT notification_whenupdate FROM tbl_notifications WHERE user_id = $usrid");
}

function getAddNewNotification($usrid){
	return getValue("SELECT notification_whenaddednew FROM tbl_notifications WHERE user_id = $usrid");
}

function getCommentNotification($usrid){
	return getValue("SELECT notification_whencomment FROM tbl_notifications WHERE user_id = $usrid");
}
function spliteItem($item,$ternimator){
	$tem=explode($ternimator,$item);
	if(count($tem)==1) return $item;
	return $tem[1];
}
function getUrl($id){
	$sub=ROOT;
	$name=getValue("select restaurant_name from tbl_restaurants_name where restaurant_id=$id");
	if($name==""){
		return "restaurant.php?resID=".$id;
	}
	else{
		return $sub."/".$name;
	}
}
function showAvaiableTime($str){
	//str= 10PM-10AM;;;
	$tem=explode(";",$str);
	if(count($tem)==1) return $str;
	if($tem[0]!="") $tem[0]="Breakfast&nbsp;: <b>".$tem[0]."</b>";
	if($tem[1]!="") $tem[1]="Lunch&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <b>".$tem[1]."</b>";
	if($tem[2]!="") $tem[2]="Dinner&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <b>".$tem[2]."</b>";
	if($tem[3]!="") $tem[3]="Super&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <b>".$tem[3]."</b>";
	return $tem[0].",".$tem[1].",".$tem[2].",".$tem[3];
}
function showRateTab($uid){
	$show=false;
	if($uid=="") return false;
	$utype=strtoupper(getValue("select user_type from tbl_users where user_id=$uid"));
	if($utype==strtoupper("owner")) $show=false;
	if($utype==strtoupper("user")) $show=true;
	return $show;
}
function showHoliday($day){
	$day=trim($day," ");
	$day=trim($day,",");
	$day=trim($day,";");
	$day=trim($day,".");
	return $day;
}

function enum_value_view($restaurant_type){
		$sql = "SELECT enum_id, enum_value FROM tbl_enums WHERE enum_type = '".$restaurant_type. "'" ;

		$alt = 1;
		$value_rs = getResultSet($sql);
		$total_row = mysql_num_rows($value_rs);
		
		$num_col = 3;
		
		if($total_row!=0){
			echo '<table border="0px">';
			while($restaurant_info = mysql_fetch_array($value_rs)){                    
                  
                    if($alt%$num_col==1){
                        echo '<tr><td width="150">';
                    }
                    else {echo '<td width="150">';}
                    
						echo '<input type="checkbox" style="margin:0px 5px 5px 5px" name="chb_'.$restaurant_type.'[]" value="'.$restaurant_info['enum_value'].'"/>'.$restaurant_info['enum_value'].'';

                    if($alt % $num_col==0){
						echo'</td>';
						echo '</tr>';
                    }
                    else {
						echo '</td>';
						
					}
						
                    $alt++;
		}
		echo '<tr><td colspan="3"><input type="checkbox" name="chb_other'.$restaurant_type.'"/>Others<input  size="41" type="text" name="txt_'.$restaurant_type.'""/>
				  </td>
			  </tr>';
		echo '</table>';
		}
 }// end of enum_value_view function
 
 function enum_value_view_checked($enum_type,$restaurant_type,$other_res_type,$id){
		$sql = "SELECT enum_id, enum_value FROM tbl_enums WHERE enum_type = '".$enum_type."'";
			//"SELECT SELECT enum_id, enum_value FROM tbl_enums WHERE enum_type ='".dkjdskjdsk. "'"
		$sql_checked = "SELECT $restaurant_type, $other_res_type FROM tbl_register_restaurants WHERE reg_restaurant_id =".$id;
		$alt = 1;
		$value_rs = getResultSet($sql);
		$checked_rs = getResultSet($sql_checked);
		$total_row = mysql_num_rows($value_rs);
		
		$num_col = 3;
			while($checked_info = mysql_fetch_array($checked_rs)) {
				$all_value_checked = $checked_info[0];
				$other_restaurant_type = $checked_info[1];
				}// end while $checked_info
				$each_value_checked = explode(';',$all_value_checked);
						
		if($total_row!=0){
			
			echo '<table border="0px">';
			while($restaurant_info = mysql_fetch_array($value_rs)){
			                    		
                    if($alt%$num_col==1){
                        echo '<tr><td width="150">';
                    }
                    else {echo '<td width="150">';}
                    
						echo '<input type="checkbox" style="margin:0px 5px 5px 5px" name="chb_'.$enum_type.'[]" value="'.$restaurant_info['enum_value'].'"';
							 for($i=0;$i<count($each_value_checked); $i++){
								if($restaurant_info['enum_value']==$each_value_checked[$i]) echo 'checked';
								}/*end for*/ 
						echo ' onclick="return false;" />'/* end checkbox*/.$restaurant_info['enum_value'].''; 

                    if($alt % $num_col==0){
						echo'</td>';
						echo '</tr>';
                    }
                    else {
						echo '</td>';
						
					}
						
                    $alt++;
		}
		if($other_restaurant_type!='') $check='checked';
		else $check = '';
		echo '<tr><td colspan="3"><input type="checkbox" name ="chb_other'.$enum_type.'" '.$check.' onclick="return false;" />Others<input  size="41" type="text" name="txt_'.$enum_type.'"" value ="'.$other_restaurant_type.'" readonly />
				  </td>
			  </tr>';
		echo '</table>';
		//} end while checked_info
		}// end while 
 }// end of enum_value_view function

?>