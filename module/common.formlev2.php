<?
//-----------------------------------------------------------------
//	add_table_header
//-----------------------------------------------------------------
function add_table_header($label,$value){
	$at = '
	<div id="headtable">
		<div id="hlabel"><b>'.$label.'</b></div>
		<div id="hvalue">'.$value.'</div>
	</div>';
	return $at;
}
//-----------------------------------------------------------------
//		form select db room
//-----------------------------------------------------------------
function form_select_db_room($value=null){
	if(empty($_POST['ydatefrom'])) $_POST['ydatefrom']=date('Y');
	if(empty($_POST['mdatefrom'])) $_POST['mdatefrom']=date('m');
	if(empty($_POST['ddatefrom'])) $_POST['ddatefrom']=date('d');
	if(empty($_POST['ydateto'])) $_POST['ydateto']=date('Y');
	if(empty($_POST['mdateto'])) $_POST['mdateto']=date('m');
	if(empty($_POST['ddateto'])) $_POST['ddateto']=date('d');
	$unixfromdate = mktime(0,0,0,$_POST['mdatefrom'],$_POST['ddatefrom'],$_POST['ydatefrom']);
	$unixtodate = mktime(23,50,50,$_POST['mdateto'],$_POST['ddateto'],$_POST['ydateto']);
?>
	<div>
		<div id="label">Room : </div>
		<div id="field">
		<select name="room" onchange="submit()">
			<option value=""></option>
			<?
			$q = mysql_query("SELECT b.id,b.name,a.name FROM room_category AS a,room AS b 
			WHERE b.room_category=a.id AND status='active' ORDER BY a.name ASC,b.name ASC");
			while($d = mysql_fetch_row($q)){
				if($d[0]==$value){
					$selected = 'selected';
				}else{
					$selected = null;
				}
				$qreserved = mysql_num_rows(mysql_query("SELECT id FROM reservation 
				WHERE room='".$d[0]."' AND (unixfrom<='".$unixfromdate."' 
				OR unixto>='".$unixtodate."') AND status='reserved'"));
				if(empty($qreserved)){
			?>
				<option value="<? echo $d[0]; ?>" <? echo $selected; ?>><? echo $d[2].' - '.$d[1]; ?></option>
			<? }} ?>
		</select>
		</div>
	</div>
	<div>
		<div id="label">Reserved Room : </div>
		<div id="field"><ul>
		<?
		$qreserved = mysql_query("SELECT c.name,b.name,a.datefrom,a.dateto FROM reservation AS a WHERE a.room=b.id 
		AND b.room_category=c.id AND (a.unixfrom<='".$unixfromdate."' OR a.unixto>='".$unixtodate."')");
		while($dreserved = mysql_fetch_row($qreserved)){
		?>
		<li><? echo '<b>'.$dreserved[0].' '.$dreserved[1].'</b> <i>('.$dreserved[2].' to '.$dreserved[3].')</i>'; ?></li>
		<? } ?>
		</ul></div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form select db room search
//-----------------------------------------------------------------
function form_select_db_room_search($value=null){
?>
	<div style="margin:0px;padding:0px;margin-bottom:4px;">
		<div style="float:left;width:100px;text-align:right;margin-right:20px;"><b>Room : </b></div>
		<div style="text-align:left;">
		<select name="room">
			<option value=""></option>
			<?
			$q = mysql_query("SELECT b.id,b.name,a.name FROM room_category AS a,room AS b 
			WHERE b.room_category=a.id AND status='active' ORDER BY a.name ASC,b.name ASC");
			while($d = mysql_fetch_row($q)){
				if($d[0]==$value){
					$selected = 'selected';
				}else{
					$selected = null;
				}
			?>
				<option value="<? echo $d[0]; ?>" <? echo $selected; ?>><? echo $d[2].' - '.$d[1]; ?></option>
			<? } ?>
		</select>
		</div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form select value add
//-----------------------------------------------------------------
function form_select_value_add(){
	$out = '<select name="valueadd"><option value=""></option>';
	$q = mysql_query("SELECT b.id,b.name,a.name FROM valueadd_category AS a,valueadd AS b 
	WHERE b.valueadd_category=a.id ORDER BY a.name ASC,b.name ASC");
	while($d = mysql_fetch_row($q)){
		if($d[0]==$value){
			$selected = 'selected';
		}else{
			$selected = null;
		}
		$out .= '<option value="'.$d[0].'" '.$selected.'>'.$d[2].' - '.$d[1].'</option>';
	}
	$out .= '</select>';
	return $out;
}
//-----------------------------------------------------------------
//		reservation_amount
//-----------------------------------------------------------------
function reservation_amount(){
	$unixfromdate = mktime(0,0,0,$_POST['mdatefrom'],$_POST['ddatefrom'],$_POST['ydatefrom']);
	$unixtodate = mktime(23,50,50,$_POST['mdateto'],$_POST['ddateto'],$_POST['ydateto']);
	$unixamount = $unixtodate-$unixfromdate;
	$amount = ceil($unixamount/86400);
	$out = array($amount,$unixfromdate,$unixtodate);
	return $out;
}
//-----------------------------------------------------------------
//		get_price
//-----------------------------------------------------------------
function get_price($amount=null){
	if(!empty($amount) && !empty($_POST['room'])){
		$dprice = mysql_fetch_row(mysql_query("SELECT price FROM room WHERE id='".$_POST['room']."'"));
		$total_price = $dprice[0]*$amount;
		$price = $dprice[0].' x '.$amount.' days = '.$total_price;
		return $price;
	}
}
//-----------------------------------------------------------------
//		color_button
//-----------------------------------------------------------------
function color_button($link,$color,$label){
	$out = '<a href="'.$link.'">
	<div style="background-color:'.$color.';width:20px;height:20px;
		float:left;border:1px solid #BBB;margin-right:10px;">&nbsp;</div></a>
	<div style="margin-right:10px;float:left;margin-top:2px;">'.$label.'</div>';
	return $out;
}
//-----------------------------------------------------------------
//		color_button_box
//-----------------------------------------------------------------
function color_button_box($button=array()){
	$out = '<div style="text-align:left;padding:4px;border:1px solid #BBB;margin-top:5px;">';
	foreach($button AS $button1){
		$out .= $button1;
	}
	$out .= '<div style="clear:both;"></div></div>';
	return $out;
}
//-----------------------------------------------------------------
//		sub_info_list
//-----------------------------------------------------------------
function sub_info_list($label,$text){
	$out = '<div style="text-align:left;padding:4px;border:1px solid #BBB;margin:2px;">';
	$out .= '<div style="text-align:right;width:200px;float:left;margin-right:10px;"><b>'.$label.' :</b></div>';
	$out .= '<div style="width:700px;float:left;">'.$text.'</div>';
	$out .= '<div style="clear:both;"></div>';
	$out .= '</div>';
	return $out;
}
?>
