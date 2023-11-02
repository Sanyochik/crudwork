<?php
//code made by Alexandr
//created at 31.10.2023
//updated at 31.10.2023
/**
 * create class for transform geting info
 */

class transformer
{
	/**
	 * function for get age or work expirience
	 */
	public function getyears($date){
		$birthDate = explode("-", $date);
  		$result = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md")
    	? ((date("Y") - $birthDate[0]) - 1)
    	: (date("Y") - $birthDate[0]));
    	return $result;
	}
	/**
	 * function for make correct insert request
	 */
	public function makeinsert(){
		$rows='(';
		$values='(';
		$first=0;
		foreach ($_POST as $key => $value) {
			if($first==0){
				$rows.=$key;
				$values.='"'.$value.'"';
				$first=1;
			}else{
				$values.=',"'.$value.'"';
				$rows.=','.$key.'';
			}
		}
		$rows.=')';
		$values.=')';
		return array($rows,$values);
	}
	/**
	 * function for export excel
	 */
	public function makeexcel($array){
		header("Content-Disposition: attachment; filename=\"export.csv\"");
		header("Content-Type: application/vnd.ms-excel;");
		header("Pragma: no-cache");
		header("Expires: 0");
		$out = fopen("php://output", 'w');
		fputs( $out, $bom = chr(0xEF) . chr(0xBB) . chr(0xBF) );
		foreach ($array as $data)
		{
		    fputcsv($out, $data,";");
		}
		fclose($out);
	}
	/**
	 * function for make correct update request
	 */
	public function makeupdate(){
		$replace='';
		$first=0;
		foreach ($_POST as $key => $value) {
			if($first==0){
				$first=1;
				$replace.=''.$key.' = "'.$value.'"';
			}else{
				$replace.=', '.$key.' = "'.$value.'"';
			}
		}
		return $replace;
	}
}