<?php
//code made by Alexandr
//created at 1.11.2023
//updated at 1.11.2023
/**
 * view for form to work with crud
 * add header
 */
	require_once($_SERVER['DOCUMENT_ROOT'].'/views/header.php');
?>
<form method="POST" action="index.php?cont=<?php echo $_GET['cont'];?>&table=<?php echo $_GET['table'];?><?php if(!empty($_GET['redact'])){echo '&redact='.$_GET["redact"].'';}?>">
<?php
	foreach($query[0] as $key =>$value){
		if($key=='id'){
		}elseif(($key=='borndate')||($key=='datebegin')){
			echo '<label>'.$key.'<br><input name='.$key.''; 
			if($_GET['cont']=='update'){
				echo' value="'.$value.'"';
			} 
			echo ' type ="date"></label><br>';
		}elseif($key=='id_depart'){
			echo $key;
			echo '<br><select name='.$key.'>';
			foreach ($departments as $keys => $values) {
				echo '<option value='.$values['id'].'>'.$values['name'].'</option>';
			}
			echo '</select><br>';
		}elseif($key=='id_comp'){
			echo $key;
			echo '<br><select name='.$key.'>';
			foreach ($companyes as $keys => $values) {
				echo '<option value='.$values['id'].'>'.$values['name'].'</option>';
			}
			echo '</select><br>';
		}else{
			echo '<label>'.$key.'<br><input';
			if($_GET['cont']=='update'){
				echo' value="'.$value.'"';
			}
			echo ' type ="text" name='.$key.'></label><br>';
		}
	}
?>
<input type="submit">
</form>