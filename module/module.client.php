<?
//-----------------------------------------------------------------
//	HEAD
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	head_client_list
//-----------------------------------------------------------------
function head_client_list(){
	if(isset($_GET['delete'])){
		mysql_query("DELETE FROM client WHERE id='".$_GET['delete']."'");
		header('location:index.php?p=client_list');
	}
}
//-----------------------------------------------------------------
//	head_client_add
//-----------------------------------------------------------------
function head_client_add(){
	if(isset($_POST['add'])){
		mysql_query("INSERT INTO client VALUES(null,'".$_POST['name']."',
		'".$_POST['telp']."','".$_POST['address']."','".$_POST['description']."')") or die(mysql_error());
		header('location:index.php?p=client_list');
	}
}
//-----------------------------------------------------------------
//	head_client_edit
//-----------------------------------------------------------------
function head_client_edit(){
	if(isset($_POST['edit_send'])){
		mysql_query("UPDATE room SET 
		name='".$_POST['name']."',
		telp='".$_POST['telp']."',
		address='".$_POST['address']."',
		description='".$_POST['description']."' 
		WHERE id='".$_POST['edit']."'") or die(mysql_error());
		header('location:index.php?p=client_list');
	}
}
//-----------------------------------------------------------------
//	MAIN
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	main_client_list
//-----------------------------------------------------------------
function main_client_list(){
	$title = 'Client List';
	$head = array('Name','Telp','Address','Description');
	$width = array('20%','15%','30%','35%');
	$link = '<a href="index.php?p=client_add">Add New Client &raquo;</a>';
	$client1 = 'index.php?p=client_edit&edit=';
	$client2 = 'index.php?p=client_list&delete=';
	$q = mysql_query("SELECT name,telp,address,description,id 
	FROM client ORDER BY name ASC");
	$rows = array();
	$ids = array();
	while($data = mysql_fetch_row($q)){
		$d = array($data[0],$data[1],$data[2],$data[3]);
		array_push($rows,$d);
		array_push($ids,$data[4]);
	}
	table_output($title,$client1,$client2,$head,$width,$link,$rows,$ids);
}
//-----------------------------------------------------------------
//	main_client_add
//-----------------------------------------------------------------
function main_client_add(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	form_header('Add New Client');
	form_back('index.php?p=client_list','Client');
	form_text('Name','name',$_POST['name'],60,255);
	form_text('Telp','telp',$_POST['telp'],50,255);
	form_text('Address','address',$_POST['address'],60,255);
	form_textarea('Description','description',150,$_POST['description']);
	form_submit('Add','add');
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	main_client_edit
//-----------------------------------------------------------------
function main_client_edit(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	$data = mysql_fetch_array(mysql_query("SELECT * FROM client WHERE id='".$_GET['edit']."'"));
	form_header('Edit Client');
	form_back('index.php?p=client_list','Client');
	form_hidden('edit',$_GET['edit']);
	form_text('Name','name',$data['name'],60,255);
	form_text('Telp','telp',$data['telp'],50,255);
	form_text('Address','address',$data['address'],60,255);
	form_textarea('Description','description',150,$data['description']);
	form_submit('Edit','edit_send');
	?>
	</div>
	</form>
<?
}
?>
