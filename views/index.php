<?php
//code made by Alexandr
//created at 31.10.2023
//updated at 31.10.2023
/**
 * view for table
 * add header
 */
	require_once($_SERVER['DOCUMENT_ROOT'].'/views/header.php');
?>
<table>
	<tr>
<?php
	foreach($columns[0] as $key =>$value){
		if(($key == "borndate")||($key == "datebegin")){
			if(!empty($_GET['by'])){
				if(($_GET['by']==$key)&&($_GET['order']=='DESC')){
					echo '<th><a href="?cont='.$_GET['cont'].'&table='.$_GET['table'].'&order=ASC&by='.$key.'">'.$key.'</a></th>';
				}else{
					echo '<th><a href="?cont='.$_GET['cont'].'&table='.$_GET['table'].'&order=DESC&by='.$key.'">'.$key.'</a></th>';
				}
			}else{
				echo '<th><a href="?cont='.$_GET['cont'].'&table='.$_GET['table'].'&order=DESC&by='.$key.'">'.$key.'</a></th>';
			}

		}else{
			echo '<th>'.$key.'</th>';
		}
		array_push($namesarray, $key);
	}
	if($_GET['table']=='users'){
		$companyes=$model->select("SELECT * FROM company");
		echo '<th>';
		echo '<form method="POST" action="index.php?cont=index&table=users"><select name=company>';
		echo'<option value="">Все</option>';
		foreach ($companyes as $key => $value) {
			echo'<option value="'.$value['id'].'">'.$value['name'].'</option>';
		}
		echo'</select>';
		echo '<input type="submit"></form>';
		echo'</th>';
	}
	echo '<tr>';
	foreach ($query as $key => $value) {
		echo '<tr>';
		foreach ($namesarray as $keys => $values) {
			if(($values == "borndate")||($values == "datebegin")){
				$value[$values]=$transformmodel->getyears($value[$values]).' Лет';
			}
			if($values == "id_depart"){
				$company=$model->select("SELECT company.name FROM departments LEFT JOIN company on departments.id_comp = company.id where departments.id = ".$value[$values]."");
				if(!empty($model->select("SELECT name FROM departments where id = ".$value[$values]."")[0]['name'])){
					$value[$values]=$model->select("SELECT name FROM departments where id = ".$value[$values]."")[0]['name'];
				}else{
					$value[$values]='deleted';
				}
			}
			if($values == "id_comp"){
				if(!empty($model->select("SELECT name FROM company where id = ".$value[$values]."")[0]['name'])){
					$value[$values]=$model->select("SELECT name FROM company where id = ".$value[$values]."")[0]['name'];
				}else{
					$value[$values]='deleted';
				}
			}
			echo '<td>'.$value[$values].'</td>';
		}
		if(!empty($company[0]['name'])){
			echo '<td>'.$company[0]['name'].'</td>';
		}
		echo '<td><a href="?cont=update&redact='.$value['id'].'&table='.$_GET["table"].'">изменить</td>';
		echo '<td><a href="?cont=delete&delete='.$value['id'].'&table='.$_GET["table"].'">удалить</td>';
		echo '</tr>';
	}
?>
</table>
<?php
$i=0;
for ($countofpages; $countofpages > 0 ; $countofpages--) {
	$i+=1;
	echo '<a href="?cont=index&table='.$_GET["table"].'&page='.$i.'';
	if(!empty($_GET['by'])){
		echo '&by='.$_GET['by'].'&order='.$_GET['order'].'';
	}
	echo'"><button>'.$i.'</button></a>';
}
?>
<br><br>
<a href="?cont=index&export=true&table=<?php echo $_GET["table"]?>"><button>Экспортировать в Excel</button></a>
<br>
<a href="?cont=insert&table=<?php echo $_GET["table"]?>"><button>Добавить</button></a>