<?
//-----------------------------------------------------------------
//	HEAD
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	head_room_list
//-----------------------------------------------------------------
function head_room_list(){
	if(isset($_GET['delete'])){
		mysql_query("DELETE FROM room WHERE id='".$_GET['delete']."'");
		header('location:index.php?p=room_list');
	}
}
//-----------------------------------------------------------------
//	head_room_add
//-----------------------------------------------------------------
function head_room_add(){
	if(isset($_POST['add'])){
		mysql_query("INSERT INTO room VALUES(null,'".$_POST['name']."',
		'".$_POST['room_category']."','".$_POST['price']."','".$_POST['description']."',
		'".$_POST['status']."')") or die(mysql_error());
		header('location:index.php?p=room_list');
	}
}
//-----------------------------------------------------------------
//	head_room_edit
//-----------------------------------------------------------------
function head_room_edit(){
	if(isset($_POST['edit_send'])){
		mysql_query("UPDATE room SET 
		name='".$_POST['name']."',
		room_category='".$_POST['room_category']."',
		price='".$_POST['price']."',
		description='".$_POST['description']."',
		status='".$_POST['status']."' 
		WHERE id='".$_POST['edit']."'") or die(mysql_error());
		header('location:index.php?p=room_list');
	}
}
//-----------------------------------------------------------------
//	MAIN
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	main_room_list
//-----------------------------------------------------------------
function main_room_list(){
	$title = 'Room List';
	$head = array('Name','Category','Price','Description','Status','availability');
	$width = array('20%','10%','10%','30%','10%','20%');
	$link = '<a href="index.php?p=room_add">Add New Room &raquo;</a>';
	$datelink = '&ysearchfrom='.$_GET['ysearchfrom'].'&ysearchto='.$_GET['ysearchto'];
	$datelink .= '&msearchfrom='.$_GET['msearchfrom'].'&msearchto='.$_GET['msearchto'];
	$datelink .= '&dsearchfrom='.$_GET['dsearchfrom'].'&dsearchto='.$_GET['dsearchto'];
	$button1 = color_button('index.php?p=room_list&select=reserved'.$datelink,'#ff8f8f','reserved');
	$button2 = color_button('index.php?p=room_list&select=booked'.$datelink,'#fff478','booked');
	$button3 = color_button('index.php?p=room_list&select=available'.$datelink,'#ffffff','available');
	$button = array($button1,$button2,$button3);
	$link .= color_button_box($button);
	$room1 = 'index.php?p=room_edit&edit=';
	$room2 = 'index.php?p=room_list&delete=';
	$q = mysql_query("SELECT a.name,b.name,a.price,a.description,a.status,a.id 
	FROM room AS a,room_category AS b WHERE a.room_category=b.id ORDER BY b.name ASC,a.name ASC");
	$rows = array();
	$ids = array();
	$now = time();
	if(!empty($_GET['ysearchfrom']) && !empty($_GET['msearchfrom']) && !empty($_GET['dsearchfrom']))
		$searchfrom = mktime(0,0,0,$_GET['msearchfrom'],$_GET['dsearchfrom'],$_GET['ysearchfrom']);
	if(!empty($_GET['ysearchto']) && !empty($_GET['msearchto']) && !empty($_GET['dsearchto']))
		$searchto = mktime(23,50,50,$_GET['msearchto'],$_GET['dsearchto'],$_GET['ysearchto']);
	if(empty($searchfrom)) $searchfrom=$now;
	if(empty($searchto)) $searchto=$now;
	while($data = mysql_fetch_row($q)){
		$qreserved = mysql_fetch_row(mysql_query("SELECT status,datefrom,dateto FROM reservation 
			WHERE room='".$data[5]."' AND (unixfrom<='".$searchfrom."' OR unixto>='".$searchto."')"));
		if(empty($qreserved[0])){ $status='available'; $qreserved[0]='available'; }
		if($qreserved[0]!='available') $status='<b>'.$qreserved[0].'</b><br><i>('.$qreserved[1].' to '.$qreserved[2].')</i>';
		$d = array($data[0],$data[1],$data[2],$data[3],$data[4],$status,$qreserved[0]);
		if($_GET['select']=='reserved'){
			if($qreserved[0]=='reserved'){ 
				array_push($rows,$d);
				array_push($ids,$data[5]);
			}
		}elseif($_GET['select']=='booked'){
			if($qreserved[0]=='booked'){ 
				array_push($rows,$d);
				array_push($ids,$data[5]);
			}
		}elseif($_GET['select']=='available'){
			if($qreserved[0]=='available'){ 
				array_push($rows,$d);
				array_push($ids,$data[5]);
			}
		}else{
			array_push($rows,$d);
			array_push($ids,$data[5]);
		}
	}
	table_output($title,$room1,$room2,$head,$width,$link,$rows,$ids,null,'room');
}
//-----------------------------------------------------------------
//	main_room_add
//-----------------------------------------------------------------
function main_room_add(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	form_header('Add New Room');
	form_back('index.php?p=room_list','Room');
	form_text('Name','name',$_POST['name'],60,255);
	form_select_db('Category','room_category','name',$_POST['room_category']);
	form_text('Price','price',$_POST['price'],40,255);
	form_textarea('Description','description',150,$_POST['description']);
	$status = array('active','inactive');
	form_select_array('Status','status',$status,$status,$_POST['status']);
	form_submit('Add','add');
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	main_room_edit
//-----------------------------------------------------------------
function main_room_edit(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	$data = mysql_fetch_array(mysql_query("SELECT * FROM room WHERE id='".$_GET['edit']."'"));
	form_header('Edit Room');
	form_back('index.php?p=room_list','Room');
	form_hidden('edit',$_GET['edit']);
	form_text('Name','name',$data['name'],60,255);
	form_select_db('Category','room_category','name',$data['room_category']);
	form_text('Price','price',$data['price'],40,255);
	form_textarea('Description','description',150,$data['description']);
	$status = array('active','inactive');
	form_select_array('Status','status',$status,$status,$data['status']);
	form_submit('Edit','edit_send');
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	room_search
//-----------------------------------------------------------------
function room_search(){
?>
	<form action="" method="GET">
	<div id="formsearch">
	<?
	form_hidden('p','room_list');
	form_hidden('select',$_GET['select']);
	form_date_search('Search From','searchfrom');
	form_date_search('Search To','searchto');
	form_submit_search('Search','search');
	?>
	</div>
	</form>
<?
}
?>
