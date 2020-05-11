<?php 

include '../../config/settings.inc.php';
include '../../config/defines.inc.php';
include_once(dirname(__FILE__).'/../../config/config.inc.php');		

if ($_POST['type'] == 'add') {
	Db::getInstance()->insert('testimonial',[
		'name' => $_POST['name'],
		'affillation' => $_POST['affiliation'],
		'testimony' => $_POST['testimonial_content']
	]);
}

if ($_POST['type'] == 'edit') {
	$id_for_edit = $_POST['id'];
	Db::getInstance()->update('testimonial',[
		'name' => $_POST['name'],
		'affillation' => $_POST['affiliation'],
		'testimony' => $_POST['testimonial_content']
	], "id = '$id_for_edit'");
}

if ($_POST['type'] == 'delete') {
	$id = $_POST['id'];
	$sql = "DELETE FROM "._DB_PREFIX_."testimonial WHERE id = '$id'";
	if (!Db::getInstance()->execute($sql)) {

    	echo 'error';
	} else {
		echo $id;
	}
}

if ($_POST['type'] == 'save_ajax') {
	$id_for_edit = $_POST['id'];
	$res = Db::getInstance()->update('testimonial',[
		'position_id' => $_POST['position']
	], "id = '$id_for_edit'");
	if ($res) {
		echo "check";
	}
}