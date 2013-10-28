<?
//-----------------------------------------------------------------
//		page
//-----------------------------------------------------------------
function page(){
	global $valid;
	//define
	if($valid==true){
		$c = 'admin';
	}else{
		$c = 'user';
	}
	//function string
	$header = $c.'_header';
	$content = $c.'_content';
	$footer = $c.'_footer';
	//execute function
	$header();
	$content();
	$footer();
	confirm_box();
}
//-----------------------------------------------------------------
//		page structure
//-----------------------------------------------------------------
function page_structure($content){
	global $valid;
	if($valid==true){
		switch($_GET['p']){ //page list for admin
			//room_category
			case ('room_category_list'):
				$function_name = $content.'_room_category_list';
				break;
			case ('room_category_add'):
				$function_name = $content.'_room_category_add';
				break;
			case ('room_category_edit'):
				$function_name = $content.'_room_category_edit';
				break;
			//room
			case ('room_list'):
				$function_name = $content.'_room_list';
				break;
			case ('room_add'):
				$function_name = $content.'_room_add';
				break;
			case ('room_edit'):
				$function_name = $content.'_room_edit';
				break;
			//client
			case ('client_list'):
				$function_name = $content.'_client_list';
				break;
			case ('client_add'):
				$function_name = $content.'_client_add';
				break;
			case ('client_edit'):
				$function_name = $content.'_client_edit';
				break;
			//reservation
			case ('reservation_list'):
				$function_name = $content.'_reservation_list';
				break;
			case ('reservation_add'):
				$function_name = $content.'_reservation_add';
				break;
			case ('reservation_edit'):
				$function_name = $content.'_reservation_edit';
				break;
			//admin
			case ('admin_list'):
				$function_name = $content.'_admin_list';
				break;
			case ('admin_add'):
				$function_name = $content.'_admin_add';
				break;
			case ('admin_edit'):
				$function_name = $content.'_admin_edit';
				break;
			//valueadd_category
			case ('valueadd_category_list'):
				$function_name = $content.'_valueadd_category_list';
				break;
			case ('valueadd_category_add'):
				$function_name = $content.'_valueadd_category_add';
				break;
			case ('valueadd_category_edit'):
				$function_name = $content.'_valueadd_category_edit';
				break;
			//valueadd
			case ('valueadd_list'):
				$function_name = $content.'_valueadd_list';
				break;
			case ('valueadd_add'):
				$function_name = $content.'_valueadd_add';
				break;
			case ('valueadd_edit'):
				$function_name = $content.'_valueadd_edit';
				break;
			//reservation_valueadd
			case ('reservation_valueadd_list'):
				$function_name = $content.'_reservation_valueadd_list';
				break;
			//logout
			case ('logout'):
				$function_name = $content.'_logout';
				break;
			case ('login_list'):
				$function_name = $content.'_login_list';
				break;
			default:
				$function_name = $content.'_home';
				break;
		}
	}else{
		$function_name = $content.'_login';
	}
	$out = $function_name();
	return $out;
}
?>
