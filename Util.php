<?php
class Custom_Util {
	
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