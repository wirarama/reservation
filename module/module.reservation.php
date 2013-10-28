<?
//-----------------------------------------------------------------
//	HEAD
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	head_reservation_list
//-----------------------------------------------------------------
function head_reservation_list(){
	if(isset($_GET['delete'])){
		mysql_query("DELETE FROM reservation WHERE id='".$_GET['delete']."'");
		header('location:index.php?p=reservation_list');
	}
}
//-----------------------------------------------------------------
//	head_reservation_valueadd_list
//-----------------------------------------------------------------
function head_reservation_valueadd_list(){
	if(isset($_GET['delete'])){
		mysql_query("DELETE FROM reservation_valueadd WHERE id='".$_GET['delete']."'");
		header('location:index.php?p=reservation_valueadd_list&reservation='.$_GET['reservation']);
	}
	if(!empty($_POST['valueadd'])){
		$price = mysql_fetch_row(mysql_query("SELECT price FROM valueadd WHERE id='".$_POST['valueadd']."'"));
		mysql_query("INSERT INTO reservation_valueadd VALUE(null,'".$_POST['reservation']."',
		'".$_POST['valueadd']."','".$price[0]."')") or die(mysql_error());
		header('location:index.php?p=reservation_valueadd_list&reservation='.$_POST['reservation']);
	}
}
//-----------------------------------------------------------------
//	head_reservation_add
//-----------------------------------------------------------------
function head_reservation_add(){
	if(isset($_POST['add'])){
		$datefrom = $_POST['ydatefrom'].'-'.$_POST['mdatefrom'].'-'.$_POST['ddatefrom'];
		$dateto = $_POST['ydateto'].'-'.$_POST['mdateto'].'-'.$_POST['ddateto'];
		list($amount,$unixfrom,$unixto) = reservation_amount();
		$roomdata = mysql_fetch_row(mysql_query("SELECT price FROM room WHERE id='".$_POST['room']."'"));
		$price_total = $roomdata[0]*$amount;
		mysql_query("INSERT INTO reservation VALUES(null,'".$_POST['room']."',
		'".$_POST['client']."','".$roomdata[0]."','".$price_total."','".$datefrom."','".$dateto."',
		'".$unixfrom."','".$unixto."','".$amount."','".$_POST['description']."','".$_POST['status']."')") 
		or die(mysql_error());
		header('location:index.php?p=reservation_list');
	}
}
//-----------------------------------------------------------------
//	head_reservation_edit
//-----------------------------------------------------------------
function head_reservation_edit(){
	if(isset($_POST['edit_send'])){
		$datefrom = $_POST['ydatefrom'].'-'.$_POST['mdatefrom'].'-'.$_POST['ddatefrom'];
		$dateto = $_POST['ydateto'].'-'.$_POST['mdateto'].'-'.$_POST['ddateto'];
		list($amount,$unixfrom,$unixto) = reservation_amount();
		$roomdata = mysql_fetch_row(mysql_query("SELECT price FROM room WHERE id='".$_POST['room']."'"));
		$price_total = $roomdata[0]*$amount;
		mysql_query("UPDATE reservation SET 
		room='".$_POST['room']."',
		client='".$_POST['client']."',
		price='".$roomdata[0]."',
		price_total='".$price_total."',
		datefrom='".$datefrom."',
		dateto='".$dateto."',
		unixfrom='".$unixfrom."',
		unixto='".$unixto."',
		amount='".$amount."',
		status='".$_POST['status']."',
		description='".$_POST['description']."' 
		WHERE id='".$_POST['edit']."'") or die(mysql_error());
		header('location:index.php?p=reservation_list');
	}
}
//-----------------------------------------------------------------
//	MAIN
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	main_reservation_list
//-----------------------------------------------------------------
function main_reservation_list(){
	$title = 'Reservation List';
	$head = array('Room','Client','Price','Amount','Price Total','From','To','Status');
	$width = array('15%','15%','10%','7%','10%','15%','15%','7%');
	$link = '<a href="index.php?p=reservation_add">Add New Reservation &raquo;</a>';
	$datelink = '&ysearchfrom='.$_GET['ysearchfrom'].'&ysearchto='.$_GET['ysearchto'];
	$datelink .= '&msearchfrom='.$_GET['msearchfrom'].'&msearchto='.$_GET['msearchto'];
	$datelink .= '&dsearchfrom='.$_GET['dsearchfrom'].'&dsearchto='.$_GET['dsearchto'];
	$button1 = color_button('index.php?p=reservation_list&select=reserved'.$datelink,'#ff8f8f','reserved');
	$button2 = color_button('index.php?p=reservation_list&select=booked'.$datelink,'#fff478','booked');
	$button = array($button1,$button2,$button3);
	$link .= color_button_box($button);
	$add_link = array(array('index.php?t=inventory&p=reservation_valueadd_list&reservation=','ValueAdd','reservation_valueadd','reservation'));
	$reservation1 = 'index.php?p=reservation_edit&edit=';
	$reservation2 = 'index.php?p=reservation_list&delete=';
	//-----------------------------------------------------------------
	//	search string
	//-----------------------------------------------------------------
	$where = '';
	if(!empty($_GET['ysearchfrom']) && !empty($_GET['msearchfrom']) && !empty($_GET['dsearchfrom']))
		$searchfrom = mktime(0,0,0,$_GET['msearchfrom'],$_GET['dsearchfrom'],$_GET['ysearchfrom']);
	if(!empty($_GET['ysearchto']) && !empty($_GET['msearchto']) && !empty($_GET['dsearchto']))
		$searchto = mktime(23,50,50,$_GET['msearchto'],$_GET['dsearchto'],$_GET['ysearchto']);
	if(!empty($searchfrom) && !empty($searchto)) $where .= " AND (a.unixfrom<='".$searchfrom."' OR a.unixto>='".$searchto."')";
	if(!empty($_GET['select'])) $where .= " AND a.status='".$_GET['select']."'";
	if(!empty($_GET['room'])) $where .= " AND a.room='".$_GET['room']."'";
	//-----------------------------------------------------------------
	$q = mysql_query("SELECT b.name,c.name,a.price,a.price_total,a.datefrom,a.dateto,a.amount,a.status,a.id 
	FROM reservation AS a,room AS b,client AS c WHERE a.room=b.id AND a.client=c.id ".$where." ORDER BY a.datefrom DESC");
	$rows = array();
	$ids = array();
	while($data = mysql_fetch_row($q)){
		$d = array($data[0],$data[1],$data[2],$data[6].' days',$data[3],$data[4],$data[5],$data[7]);
		array_push($rows,$d);
		array_push($ids,$data[8]);
	}
	table_output($title,$reservation1,$reservation2,$head,$width,$link,$rows,$ids,$add_link,'reservation');
}
//-----------------------------------------------------------------
//	main_reservation_valueadd_list
//-----------------------------------------------------------------
function main_reservation_valueadd_list(){
	$title = 'Reservation Value Add List';
	$head = array('Value Add','Category','Price');
	$width = array('35%','35%','30%');
	$dreservation = mysql_fetch_row(mysql_query("SELECT b.name,c.name,a.datefrom,a.dateto,a.price,a.amount,a.price_total,a.status 
	FROM reservation AS a,room AS b,client AS c WHERE a.room=b.id AND a.client=c.id AND a.id='".$_GET['reservation']."'"));
	$link = sub_info_list('Room',$dreservation[0]);
	$link .= sub_info_list('Client',$dreservation[1]);
	$link .= sub_info_list('Periode','From '.$dreservation[2].' to '.$dreservation[3]);
	$link .= sub_info_list('Reservation Price',$dreservation[4].' x '.$dreservation[5].' = '.$dreservation[6]);
	$link .= sub_info_list('Status',$dreservation[7]);
	$link .= '<form action="" method="POST"><div id="formsearch">';
	$form_valueadd = form_select_value_add();
	$form_valueadd .= '<input type="hidden" name="reservation" value="'.$_GET['reservation'].'">';
	$link .= sub_info_list('+ Value Add',$form_valueadd.'&nbsp;<input type="submit" name="addvalueadd" value="Add">');
	$link .= '</div></form>';
	$reservation1 = null;
	$reservation2 = 'index.php?t=inventory&p=reservation_valueadd_list&reservation='.$_GET['reservation'].'&delete=';
	$q = mysql_query("SELECT c.name,d.name,a.price,a.id 
	FROM reservation_valueadd AS a,reservation AS b,valueadd AS c,valueadd_category AS d 
	WHERE a.reservation=b.id AND a.valueadd=c.id AND c.valueadd_category=d.id 
	ORDER BY d.name ASC,c.name ASC") or die(mysql_error());
	$rows = array();
	$ids = array();
	while($data = mysql_fetch_row($q)){
		$d = array($data[0],$data[1],$data[2]);
		array_push($rows,$d);
		array_push($ids,$data[3]);
	}
	table_output($title,$reservation1,$reservation2,$head,$width,$link,$rows,$ids);
}
//-----------------------------------------------------------------
//	main_reservation_add
//-----------------------------------------------------------------
function main_reservation_add(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	form_header('Add New Reservation');
	form_back('index.php?p=reservation_list','Reservation');
	form_date('From','datefrom',$_POST['datefrom']);
	form_date('To','dateto',$_POST['dateto']);
	list($amount,$unixfrom,$unixto) = reservation_amount();
	form_text_only('Amount',$amount.' Days');
	form_select_db_room($_POST['room']);
	$price = get_price($amount);
	form_text_only('Price',$price);
	form_select_db('Client','client','name',$_POST['client']);
	$status = array('booked','reserved');
	form_select_array('Status','status',$status,$status,$_POST['status']);
	form_textarea('Note','description',150,$_POST['description']);
	form_submit('Add','add');
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	main_reservation_edit
//-----------------------------------------------------------------
function main_reservation_edit(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	$data = mysql_fetch_array(mysql_query("SELECT * FROM reservation WHERE id='".$_GET['edit']."'"));
	form_header('Edit Reservation');
	form_back('index.php?p=reservation_list','Reservation');
	form_hidden('edit',$_GET['edit']);
	form_date('From','datefrom',$data['datefrom']);
	form_date('To','dateto',$data['dateto']);
	list($amount,$unixfrom,$unixto) = reservation_amount();
	form_text_only('Amount',$amount.' Days');
	form_select_db_room($data['room']);
	form_select_db('Client','client','name',$data['client']);
	$status = array('booked','reserved');
	form_select_array('Status','status',$status,$status,$data['status']);
	form_textarea('Note','description',150,$_POST['description']);
	form_submit('Edit','edit_send');
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	reservation_search
//-----------------------------------------------------------------
function reservation_search(){
?>
	<form action="" method="GET">
	<div id="formsearch">
	<?
	form_hidden('p','reservation_list');
	form_hidden('select',$_GET['select']);
	form_select_db_room_search($_GET['room']);
	form_date_search('Search From','searchfrom');
	form_date_search('Search To','searchto');
	form_submit_search('Search','search');
	?>
	</div>
	</form>
<?
}
?>
