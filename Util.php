<?php
class Custom_Util {

	public function dataHoraToDb($data){
		$date = new Zend_Date($data, "dd/MM/YYYY HH:mm:ss");

		return $date->toString('YYYY-MM-dd HH:mm:ss');
	}

	public function dataToDb($data){
		$date = new Zend_Date($data, "dd/MM/YYYY");

		return $date->toString('YYYY-MM-dd');
	}

	public function dataHoraToSite($data){
		$date = new Zend_Date($data, "YYYY-MM-dd HH:mm:ss");

		return $date->toString('dd/MM/YYYY HH:mm:ss');
	}

	public function dataToSite($data){

		$date = new Zend_Date($data, "YYYY-MM-dd");

		return $date->toString('dd/MM/YYYY');
	}

	public static function paginator($db, $limit, $page, $vDados, $order = null, $where = array()){
		$total = $db->countTotal();

		$numberOfPages = $total/$limit;

		$offset = $page*$limit;

		if ($vDados){
			$vo = $db->busca($vDados, $order, $limit, $offset);
		}else{
			$vo = $db->fetchAll($where, $order, $limit, $offset);
		}

		$arrPaginator = array('data' => $vo);
		$oPaginator = self::ArrayToObject($arrPaginator);

		return $oPaginator;
	}

	public static function ArrayToObject(Array $array){
		$object = new StdClass;

		foreach ($array as $key => $value){
			$object->$key = $value;
		}

		return $object;
	}

}