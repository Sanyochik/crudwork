<?php
//code made by Alexandr
//created at 1.11.2023
//updated at 1.11.2023
/**
 * controller class
 * connect models
 */
require_once($_SERVER['DOCUMENT_ROOT'].'/models/db.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/models/transformer.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/models/auth.php');
/**
* create controller class
*/
class controller {
	/**
	* create redirect function
	*/
	public function Redirect($url){
		header('Location:'.$url.'');
	}
	/**
	* create function for display index page
	*/
	public function Index($table,$order='',$by=''){
		$model= new db();
		$transformmodel= new transformer();
		$namesarray=array();
		if(!empty($_GET['page'])){
			$page= $_GET['page']*5;
			$pagestart=$page-5;
		}else{
			$page=5;
			$pagestart=0;
		}
		$columns=$model->select("SELECT * FROM ".$table."");
		if(!empty($_POST['company'])){
			if($_POST['company']!=''){
				$departs='';
				$first=0;
				$corecter=$model->select("SELECT * FROM departments where id_comp = ".$_POST['company']."");
				foreach ($corecter as $key => $value) {
					if($first == 0){
						$departs.=''.$value['id'].'';
						$first=1;
					}else{
						$departs.=','.$value['id'].'';
					}
				}
				$query=$model->select("SELECT * FROM ".$table." where id_depart IN($departs) LIMIT $pagestart,$page");
				$countofpages=$model->select("SELECT * FROM ".$table." where id_depart IN($departs)");
			}
		}
		if($order!=''){
			if(!empty($departs)){
				$query=$model->select("SELECT * FROM ".$table." ORDER BY ".$by." ".$order." where id_depart IN($departs) LIMIT $pagestart,$page");
				$countofpages=$model->select("SELECT * FROM ".$table." ORDER BY ".$by." ".$order." where id_depart IN($departs)");
			}else{
				$query=$model->select("SELECT * FROM ".$table." ORDER BY ".$by." ".$order." LIMIT $pagestart,$page");
				$countofpages=$model->select("SELECT * FROM ".$table." ORDER BY ".$by." ".$order."");
			}
		}else{
			if(!empty($departs)){
				$query=$model->select("SELECT * FROM ".$table." where id_depart IN($departs) LIMIT $pagestart,$page");
				$countofpages=$model->select("SELECT * FROM ".$table." where id_depart IN($departs)");
			}else{
				$query=$model->select("SELECT * FROM ".$table." LIMIT $pagestart,$page");
				$countofpages=$model->select("SELECT * FROM ".$table."");
			}
		}
		$countofpages=count($countofpages)/5;
		$countofpages=ceil($countofpages);
		if(!empty($_GET['export'])){
			$forexcel=$query;
			array_unshift($forexcel, array_keys($columns[0]));
			$transformmodel->makeexcel($forexcel);
		}else{
			require_once($_SERVER['DOCUMENT_ROOT'].'/views/index.php');
		}
	}
	/**
	* create function for update info
	*/
	public function Update($table,$redact){
		$model= new db();
		$transformmodel= new transformer();
		if(!empty($_POST)){
			$replace=$transformmodel->makeupdate();
			$model->atherActions("UPDATE $table SET ".$replace." where id=$redact");
			$this->Redirect('index.php?cont=index&table='.$table.'');
		}else{
			$query=$model->select("SELECT * FROM ".$table." where id = ".$_GET['redact']." LIMIT 1");
			$companyes=$model->select("SELECT * FROM company");
			$departments=$model->select("SELECT * FROM departments");
			require_once($_SERVER['DOCUMENT_ROOT'].'/views/form.php');
		}
	}
	/**
	* create function for delete info
	*/
	public function Delete($table,$delete){
		$model= new db();
		$model->atherActions("DELETE from ".$table." where id = $delete ");
		$this->Redirect('index.php?cont=index&table='.$table.'');
	}
	/**
	* create function for authentification
	*/
	public function Login(){
		$model= new auth();
		if(!empty($_POST)){
			$model->hashpassword($_POST['password'],$_POST['username']);
		}else{
			require_once($_SERVER['DOCUMENT_ROOT'].'/views/login.php');
		}
	}
	/**
	* create function for logout
	*/
	public function Logout(){
		$model= new auth();
		$model->logout();
	}
	/**
	* create function for insert new row
	*/
	public function Insert($table){
		$model= new db();
		$transformmodel= new transformer();
		if(!empty($_POST)){
			$result=$transformmodel->makeinsert();
			$model->atherActions("INSERT into ".$table." ".$result[0]." VALUES $result[1]");
			$this->Redirect('index.php?cont=index&table='.$table.'');
		}else{
			$query=$model->select("SELECT * FROM ".$table." LIMIT 1");
			$companyes=$model->select("SELECT * FROM company");
			$departments=$model->select("SELECT * FROM departments");
			require_once($_SERVER['DOCUMENT_ROOT'].'/views/form.php');
		}
	}
}