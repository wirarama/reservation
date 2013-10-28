<?
//-----------------------------------------------------------------
//	HEAD
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	head_room_category_list
//-----------------------------------------------------------------
function head_room_category_list(){
	if(isset($_GET['delete'])){
		mysql_query("DELETE FROM room_category WHERE id='".$_GET['delete']."'");
		mysql_query("DELETE FROM room WHERE room_category='".$_GET['delete']."'");
		header('location:index.php?p=room_category_list');
	}
}
//-----------------------------------------------------------------
//	head_room_category_add
//-----------------------------------------------------------------
function head_room_category_add(){
	if(isset($_POST['add'])){
		$no = auto_number('room_category');
		mysql_query("INSERT INTO room_category VALUES('".$no."','".$_POST['name']."')") 
		or die(mysql_error());
		header('location:index.php?p=room_category_list');
	}
}
//-----------------------------------------------------------------
//	head_room_category_edit
//-----------------------------------------------------------------
function head_room_category_edit(){
	if(isset($_POST['edit_send'])){
		mysql_query("UPDATE room_category SET 
		name='".$_POST['name']."' 
		WHERE id='".$_POST['edit']."'") or die(mysql_error());
		header('location:index.php?p=room_category_list');
	}
}
//-----------------------------------------------------------------
//	MAIN
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	main_room_category_list
//-----------------------------------------------------------------
function main_room_category_list(){
	$title = 'Room Category List';
	$head = array('Name','Room');
	$width = array('75%','25%');
	$link = '<a href="index.php?p=room_category_add">Add New Room Category &raquo;</a>';
	$room1 = 'index.php?p=room_category_edit&edit=';
	$room2 = 'index.php?p=room_category_list&delete=';
	$rows = array();
	$ids = array();
	$q = mysql_query("SELECT name,id FROM room_category ORDER BY name ASC");
	while($data = mysql_fetch_row($q)){
		$room = mysql_num_rows(mysql_query("SELECT id FROM room WHERE room_category='".$data[1]."'"));
		$d = array($data[0],$room);
		array_push($rows,$d);
		array_push($ids,$data[1]);
	}
	table_output($title,$room1,$room2,$head,$width,$link,$rows,$ids);
}
//-----------------------------------------------------------------
//	main_room_category_add
//-----------------------------------------------------------------
function main_room_category_add(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	form_header('Add New Room Category');
	form_back('index.php?p=room_category_list','Room Category');
	form_text('Name','name',$_POST['name'],60,255);
	form_submit('Add','add');
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	main_room_category_edit
//-----------------------------------------------------------------
function main_room_category_edit(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	$data = mysql_fetch_array(mysql_query("SELECT * FROM room_category WHERE id='".$_GET['edit']."'"));
	form_header('Edit Room Category');
	form_hidden('edit',$_GET['edit']);
	form_back('index.php?p=room_category_list','Room Category');
	form_text('Name','name',$data['name'],60,255);
	form_submit('Edit','edit_send');
	?>
	</div>
	</form>
<?
}
?>
