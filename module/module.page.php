<?
//-----------------------------------------------------------------
//	HEAD
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	head_page_list
//-----------------------------------------------------------------
function head_page_list(){
	if(isset($_GET['delete'])){
		mysql_query("DELETE FROM page WHERE id='".$_GET['delete']."'");
		header('location:index.php?p=page_list');
	}
}
//-----------------------------------------------------------------
//	head_page_add
//-----------------------------------------------------------------
function head_page_add(){
	if(isset($_POST['add'])){
		mysql_query("INSERT INTO page VALUES(null,'".$_POST['name']."')") or die(mysql_error());
		header('location:index.php?p=page_list');
	}
}
//-----------------------------------------------------------------
//	head_page_edit
//-----------------------------------------------------------------
function head_page_edit(){
	if(isset($_POST['edit_send'])){
		mysql_query("UPDATE page SET 
		name='".$_POST['name']."' 
		WHERE id='".$_POST['edit']."'") or die(mysql_error());
		header('location:index.php?p=page_list');
	}
}
//-----------------------------------------------------------------
//	MAIN
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	main_page_list
//-----------------------------------------------------------------
function main_page_list(){
	$title = 'Page List';
	$head = array('Name');
	$width = array('100%');
	$link = '<a href="index.php?p=page_add">Add New Page &raquo;</a>';
	$content1 = 'index.php?p=page_edit&edit=';
	$content2 = 'index.php?p=page_list&delete=';
	$rows = array();
	$ids = array();
	$q = mysql_query("SELECT name,id FROM page ORDER BY id DESC");
	while($data = mysql_fetch_row($q)){
		$d = array($data[0]);
		array_push($rows,$d);
		array_push($ids,$data[1]);
	}
	table_output($title,$content1,$content2,$head,$width,$link,$rows,$ids);
}
//-----------------------------------------------------------------
//	main_page_add
//-----------------------------------------------------------------
function main_page_add(){
?>
	<form action="" method="POST" enctype="multipart/form-data">
	<div id="formborder">
	<?
	form_header('Add New Page');
	form_back('index.php?p=page_list','Page');
	form_text('Name','name',$_POST['name'],60,255);
	form_submit('Add','add');
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	main_page_edit
//-----------------------------------------------------------------
function main_page_edit(){
?>
	<form action="" method="POST" enctype="multipart/form-data">
	<div id="formborder">
	<?
	$data = mysql_fetch_array(mysql_query("SELECT * FROM page WHERE id='".$_GET['edit']."'"));
	form_header('Edit Page');
	form_hidden('edit',$_GET['edit']);
	form_back('index.php?p=page_list','Page');
	form_text('Name','name',$data['name'],60,255);
	form_submit('Edit','edit_send');
	?>
	</div>
	</form>
<?
}
?>
