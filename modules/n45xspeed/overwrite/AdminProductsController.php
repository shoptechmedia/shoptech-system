<?php

if(isset($_POST['id_product']) && class_exists('n45xspeed')) {
	$n45xspeed = new n45xspeed();
	$n45xspeed->refreshEntityCache('product', $_POST['id_product']);
}