<?
//-----------------------------------------------------------------
//	HEAD
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	head_valueadd_list
//-----------------------------------------------------------------
function head_valueadd_list(){
	if(isset($_GET['delete'])){
		mysql_query("DELETE FROM valueadd WHERE id='".$_GET['delete']."'");
		header('location:index.php?p=valueadd_list');
	}
}
//-----------------------------------------------------------------
//	head_valueadd_add
//-----------------------------------------------------------------
function head_valueadd_add(){
	if(isset($_POST['add'])){
		mysql_query("INSERT INTO valueadd VALUES(null,'".$_POST['name']."',
		'".$_POST['valueadd_category']."','".$_POST['price']."',
		'".$_POST['description']."',null)") or die(mysql_error());
		header('location:index.php?p=valueadd_list');
	}
}
//-----------------------------------------------------------------
//	head_valueadd_edit
//-----------------------------------------------------------------
function head_valueadd_edit(){
	if(isset($_POST['edit_send'])){
		mysql_query("UPDATE valueadd SET 
		name='".$_POST['name']."',
		valueadd_category='".$_POST['valueadd_category']."',
		price='".$_POST['price']."',
		description='".$_POST['description']."' 
		WHERE id='".$_POST['edit']."'") or die(mysql_error());
		header('location:index.php?p=valueadd_list');
	}
}
//-----------------------------------------------------------------
//	MAIN
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	main_valueadd_list
//-----------------------------------------------------------------
function main_valueadd_list(){
	$title = 'Value Add List';
	$head = array('Name','Category','Price','Description');
	$width = array('30%','20%','20%','30%');
	$link = '<a href="index.php?p=valueadd_add">Add New Value Add &raquo;</a>';
	$valueadd1 = 'index.php?p=valueadd_edit&edit=';
	$valueadd2 = 'index.php?p=valueadd_list&delete=';
	$q = mysql_query("SELECT a.name,b.name,a.price,a.description,a.id 
	FROM valueadd AS a,valueadd_category AS b WHERE a.valueadd_category=b.id ORDER BY b.name ASC,a.name ASC") or die(mysql_error());
	$rows = array();
	$ids = array();
	while($data = mysql_fetch_row($q)){
		$d = array($data[0],$data[1],$data[2],$data[3]);
		array_push($rows,$d);
		array_push($ids,$data[4]);
	}
	table_output($title,$valueadd1,$valueadd2,$head,$width,$link,$rows,$ids);
}
//-----------------------------------------------------------------
//	main_valueadd_add
//-----------------------------------------------------------------
function main_valueadd_add(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	form_header('Add New Value Add');
	form_back('index.php?p=valueadd_list','Value Add');
	form_text('Name','name',$_POST['name'],60,255);
	form_select_db('Category','valueadd_category','name',$_POST['valueadd_category']);
	form_text('Price','price',$_POST['price'],40,255);
	form_textarea('Description','description',150,$_POST['description']);
	form_submit('Add','add');
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	main_valueadd_edit
//-----------------------------------------------------------------
function main_valueadd_edit(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	$data = mysql_fetch_array(mysql_query("SELECT * FROM valueadd WHERE id='".$_GET['edit']."'"));
	form_header('Edit Value Add');
	form_back('index.php?p=valueadd_list','Value Add');
	form_hidden('edit',$_GET['edit']);
	form_text('Name','name',$data['name'],60,255);
	form_select_db('Category','valueadd_category','name',$data['valueadd_category']);
	form_text('Price','price',$data['price'],40,255);
	form_textarea('Description','description',150,$data['description']);
	form_submit('Edit','edit_send');
	?>
	</div>
	</form>
<?
}
?>
