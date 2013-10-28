<?
//-----------------------------------------------------------------
//		admin header
//-----------------------------------------------------------------
function admin_header(){
	global $valid,$member;
?>
	<div id="Header">
	<h1>Reservation System</h1>
	<?
	if($valid==true){
	?>
	<ul id="jsddm">
	<li><a href="index.php?p=reservation_list">Reservation</a></li>
	<li><a href="index.php?p=room_list">Room</a>
		<ul>
		<li><a href="index.php?p=room_list">Room</a></li>
		<li><a href="index.php?p=room_category_list">Room Category</a></li>
		</ul>
	</li>
	<li><a href="index.php?p=valueadd_list">Value Add</a>
		<ul>
		<li><a href="index.php?p=valueadd_list">Value Add</a></li>
		<li><a href="index.php?p=valueadd_category_list">Value Add Category</a></li>
		</ul>
	</li>
	<li><a href="index.php?p=client_list">Client</a></li>
	<li><a href="index.php?p=admin_list">Admin</a></li>
	<li><a href="index.php?p=login_list">Login List</a></li>
	<li><a href="#" onClick="confirm('Are You Sure to Logout?',function(){ window.location.href = 'index.php?p=logout'; })">Logout</a></li>
	</ul>
	<? } ?>
	</div>
<?
}
//-----------------------------------------------------------------
//		admin content
//-----------------------------------------------------------------
function admin_content(){
?>
	<div id="general">
		<? page_structure('main'); ?>
		<div style="clear:both;"></div>
	</div>
<?
}
//-----------------------------------------------------------------
//		admin footer
//-----------------------------------------------------------------
function admin_footer(){
}
?>
