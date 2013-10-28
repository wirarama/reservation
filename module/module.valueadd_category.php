<?
//-----------------------------------------------------------------
//	HEAD
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	head_valueadd_category_list
//-----------------------------------------------------------------
function head_valueadd_category_list(){
	if(isset($_GET['delete'])){
		mysql_query("DELETE FROM valueadd_category WHERE id='".$_GET['delete']."'");
		mysql_query("DELETE FROM valueadd WHERE valueadd_category='".$_GET['delete']."'");
		header('location:index.php?p=valueadd_category_list');
	}
}
//-----------------------------------------------------------------
//	head_valueadd_category_add
//-----------------------------------------------------------------
function head_valueadd_category_add(){
	if(isset($_POST['add'])){
		$no = auto_number('valueadd_category');
		mysql_query("INSERT INTO valueadd_category VALUES('".$no."','".$_POST['name']."')") 
		or die(mysql_error());
		header('location:index.php?p=valueadd_category_list');
	}
}
//-----------------------------------------------------------------
//	head_valueadd_category_edit
//-----------------------------------------------------------------
function head_valueadd_category_edit(){
	if(isset($_POST['edit_send'])){
		mysql_query("UPDATE valueadd_category SET 
		name='".$_POST['name']."' 
		WHERE id='".$_POST['edit']."'") or die(mysql_error());
		header('location:index.php?p=valueadd_category_list');
	}
}
//-----------------------------------------------------------------
//	MAIN
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	main_valueadd_category_list
//-----------------------------------------------------------------
function main_valueadd_category_list(){
	$title = 'Value Add Category List';
	$head = array('Name','Value Add');
	$width = array('75%','25%');
	$link = '<a href="index.php?p=valueadd_category_add">Add New Value Add Category &raquo;</a>';
	$valueadd1 = 'index.php?p=valueadd_category_edit&edit=';
	$valueadd2 = 'index.php?p=valueadd_category_list&delete=';
	$rows = array();
	$ids = array();
	$q = mysql_query("SELECT name,id FROM valueadd_category ORDER BY name ASC");
	while($data = mysql_fetch_row($q)){
		$valueadd = mysql_num_rows(mysql_query("SELECT id FROM valueadd WHERE valueadd_category='".$data[1]."'"));
		$d = array($data[0],$valueadd);
		array_push($rows,$d);
		array_push($ids,$data[1]);
	}
	table_output($title,$valueadd1,$valueadd2,$head,$width,$link,$rows,$ids);
}
//-----------------------------------------------------------------
//	main_valueadd_category_add
//-----------------------------------------------------------------
function main_valueadd_category_add(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	form_header('Add New Value Add Category');
	form_back('index.php?p=valueadd_category_list','Value Add Category');
	form_text('Name','name',$_POST['name'],60,255);
	form_submit('Add','add');
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	main_valueadd_category_edit
//-----------------------------------------------------------------
function main_valueadd_category_edit(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	$data = mysql_fetch_array(mysql_query("SELECT * FROM valueadd_category WHERE id='".$_GET['edit']."'"));
	form_header('Edit Value Add Category');
	form_hidden('edit',$_GET['edit']);
	form_back('index.php?p=valueadd_category_list','Value Add Category');
	form_text('Name','name',$data['name'],60,255);
	form_submit('Edit','edit_send');
	?>
	</div>
	</form>
<?
}
?>
