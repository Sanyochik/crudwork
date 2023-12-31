<?php
//code made by Alexandr
//created at 31.10.2023
//updated at 1.11.2023
/**
 * file initialization controller
 */
session_start();
require_once('controllers/controller.php');
$controller = new controller();
if(!empty($_SESSION['token'])){
	if($_GET['cont']=='index'){
		if(!empty($_GET['order'])){
			$controller->index($_GET['table'],$_GET['order'],$_GET['by']);
		}else{
			$controller->index($_GET['table']);
		}
	}elseif($_GET['cont']=='update'){
		$controller->update($_GET['table'],$_GET['redact']);
	}elseif($_GET['cont']=='delete'){
		$controller->delete($_GET['table'],$_GET['delete']);
	}elseif($_GET['cont']=='insert'){
		$controller->insert($_GET['table']);
	}elseif($_GET['error']=='error'){
		$controller->login();
	}elseif($_GET['cont']=='logout'){
		$controller->logout();
	}
}else{
	$controller->login();
}
