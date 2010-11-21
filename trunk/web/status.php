<?
require_once("./include/my_func.inc.php");
require_once("./include/db_info.inc.php");
if(isset($OJ_LANG)){
		require_once("./lang/$OJ_LANG.php");
	}
require_once("./include/const.inc.php");

?>


<meta http-equiv='refresh' content='60'>
<title>Submission Status</title>
<center>
<form action="status.php" method="get">
<?
if($OJ_SIM){
	$sql="SELECT * FROM `solution` left join `sim` on solution.solution_id=sim.s_id WHERE 1 ";
}else{
	$sql="SELECT * FROM `solution` WHERE 1 ";
}
$str2="";
if (isset($_GET['cid'])){
	$cid=intval($_GET['cid']);
	$sql=$sql." AND `contest_id`='$cid' ";
	$str2=$str2."&cid=$cid";
	require_once("contest-header.php");
}else{
	require_once("oj-header.php");
}
?>
<table width=90%>
<tr><td>
<?
$order_str=" ORDER BY `solution_id` DESC ";
$start_first=1;
// check the top arg
if (isset($_GET['top'])){
	$top=strval(intval($_GET['top']));
	if ($top!=-1) $sql=$sql."AND `solution_id`<'".$top."' ";
}
/*
else if (isset($_GET['bottom'])){
	$bottom=strval(intval($_GET['bottom']));
	if ($bottom!=-1){
	  	$sql=$sql."AND `solution_id`>'".strval(intval($bottom))."' ";
		//$order_str=" ORDER BY `solution_id` ASC ";
		$start_first=0;
	}
}*/
// check the problem arg
$problem_id="";
if (isset($_GET['problem_id'])){
	$problem_id=strval(intval($_GET['problem_id']));
	if ($problem_id!='0'){
		$sql=$sql."AND `problem_id`='".$problem_id."' ";
		$str2=$str2."&problem_id=".$problem_id;
	}
	else $problem_id="";
}
// check the user_id arg
$user_id="";
if (isset($_GET['user_id'])){
	$user_id=trim($_GET['user_id']);
	if (is_valid_user_name($user_id) && $user_id!=""){
		$sql=$sql."AND `user_id`='".$user_id."' ";
		if ($str2!="") $str=$str."&";
		$str2=$str2."&user_id=".$user_id;
	}else $user_id="";
}
if (isset($_GET['language'])) $language=intval($_GET['language']);
else $language=-1;

if ($language>3 || $language<0) $language=-1;
if ($language!=-1){
	$sql=$sql."AND `language`='".strval($language)."' ";
	$str2=$str2."&language=".$language;
}
?>
<?=$MSG_PROBLEM_ID?>:<input type=text size=4 name=problem_id value='<?=$problem_id?>'>
<?=$MSG_USER?>:<input type=text size=6 name=user_id value='<?=$user_id?>'>
<?if (isset($cid)) echo "<input type='hidden' name='cid' value='$cid'>";?>
<?=$MSG_LANG?>:<select size="1" name="language">
<?
if (isset($_GET['language'])) $language=$_GET['language'];
else $language=-1;
if ($language<0||$language>4) $language=-1;
if ($language==-1) echo "<option value='-1' selected>All</option>";
else echo "<option value='-1'>All</option>";
for ($i=0;$i<5;$i++){
	if ($i==$language) echo "<option value=$i selected>$language_name[$i]</option>";
	else echo "<option value=$i>$language_name[$i]</option>";
}
?>
</select>
<?=$MSG_RESULT?>:<select size="1" name="jresult">
<?
if (isset($_GET['jresult'])) $jresult=intval($_GET['jresult']);
else $jresult=-1;
if ($jresult>=12||$jresult<0) $jresult=-1;
if ($jresult!=-1){
	$sql=$sql."AND `result`='".strval($jresult)."' ";
	$str2=$str2."&jresult=".strval($jresult);
}
if ($jresult==-1) echo "<option value='-1' selected>All</option>";
else echo "<option value='-1'>All</option>";
for ($j=0;$j<12;$j++){
	$i=($j+4)%12;
	if ($i==$jresult) echo "<option value='".strval($jresult)."' selected>".$judge_result[$i]."</option>";
	else echo "<option value='".strval($i)."'>".$judge_result[$i]."</option>"; 
}
echo "</select>";
?>
</select>
<input type=submit value='<?=$MSG_SEARCH?>'>
</form>
</td></tr>
</table>
<table align=center>
<tr  class='toprow'>
<td width="8%"><?=$MSG_RUNID?>
<td width="10%"><?=$MSG_USER?>
<td width="6%"><?=$MSG_PROBLEM?>
<td width="17%"><?=$MSG_RESULT?>
<td width="10%"><?=$MSG_MEMORY?>
<td width="8%"><?=$MSG_TIME?>
<td width="6%"><?=$MSG_LANG?>
<td width="10%"><?=$MSG_CODE_LENGTH?>
<td width="17%"><?=$MSG_SUBMIT_TIME?>
</tr>
<?
$sql=$sql.$order_str."LIMIT 20";
//echo $sql;
$result = mysql_query($sql) or die("Error! ".mysql_error());
$rows_cnt=mysql_num_rows($result);
$top=$bottom=-1;
$cnt=0;
if ($start_first){
	$row_start=0;
	$row_add=1;
}else{
	$row_start=$rows_cnt-1;
	$row_add=-1;
}


//for ($i=0;$i<$rows_cnt;$i++){
//	mysql_data_seek($result,$row_start+$row_add*$i);
while(	$row=mysql_fetch_object($result)){
	if ($top==-1) $top=$row->solution_id;
	$bottom=$row->solution_id;
	if ($cnt) echo "<tr align=center class='oddrow'>";
	else echo "<tr align=center class='evenrow'>";
	$flag=!is_running(intval($row->contest_id)) || isset($_SESSION['administrator']) || strcmp($row->user_id,$_SESSION['user_id'])==0;
	$cnt=1-$cnt;
	echo "<td>".$row->solution_id;
	echo "<td><a href='userinfo.php?user=".$row->user_id."'>".$row->user_id."</a>";
	if (isset($cid)) echo "<td><a href='problem.php?cid=$cid&pid=$row->num'>".$PID[$row->num]."</a>";
	else echo "<td><a href='problem.php?id=".$row->problem_id."'>".$row->problem_id."</a>";
	if (intval($row->result)==11 && ($row->user_id==$_SESSION['user_id'] || isset($_SESSION['source_browser']))){
		echo "<td><a href='ceinfo.php?sid=$row->solution_id'><font color=".$judge_color[$row->result].">".$judge_result[$row->result]."</font></a>";
	}else{
		if($OJ_SIM&&$row->sim) {
			echo "<td><font color=".$judge_color[$row->result].">*".$judge_result[$row->result]."</font>-<font color=red>";
			if( isset($_SESSION['source_browser'])){
					echo "<a href=showsource.php?id=".$row->sim_s_id.">".$row->sim_s_id."</a>";
			}else{
					echo $row->sim_s_id;
			}
			echo	 "</font>";
		}else{
			echo "<td><font color=".$judge_color[$row->result].">".$judge_result[$row->result]."</font>";
		}
		
	}
	if ($flag){

	if ($row->result>=4){
		echo "<td>".$row->memory." <font color=red>kb</font>";
		echo "<td>".$row->time." <font color=red>ms</font>";
	}else{
		echo "<td>------<td>------";
	}
	if (!(isset($_SESSION['user_id'])&&strtolower($row->user_id)==strtolower($_SESSION['user_id']) || isset($_SESSION['source_browser']))){
		echo "<td>".$language_name[$row->language];
	}else{
		echo "<td><a target=_blank href=showsource.php?id=".$row->solution_id.">".$language_name[$row->language]."</a>";
	}
	echo "<td>".$row->code_length." B";
	
	}else echo "<td>------<td>------<td>".$language_name[$row->language]."<td>------";
	echo "<td>".$row->in_date;
	echo "</tr>";
}
mysql_free_result($result);
?>
</table>
<?
echo "[<a href=status.php?".$str2.">Top</a>]&nbsp;&nbsp;";
echo "[<a href=status.php?".$str2."&top=".($top+20).">Previous Page</a>]&nbsp;&nbsp;";
echo "[<a href=status.php?".$str2."&top=".$bottom.">Next Page</a>]";
?>
</center>
<?require_once("oj-footer.php");
?>
