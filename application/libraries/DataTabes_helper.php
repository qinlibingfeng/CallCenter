
 <?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 class DataTabes_helper {
	
	function getPageSql($req){
		$sLimit = "";
		if ( isset( $req['iDisplayStart'] ) && $req['iDisplayLength'] != '-1' ){
			
			$sLimit = "LIMIT ".mysql_real_escape_string( $req['iDisplayStart'] ).", ".
			mysql_real_escape_string( $req['iDisplayLength'] );
		}
		return $sLimit;
	}
	
	function getFilteringSql($fiterString,$aColumns){
		$sWhere = "";
		if ($fiterString != "" ){
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ ){
				$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $fiterString )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		return $sWhere;
	}
	
	
	function getFilteringIndividualColumnSql($aColumns){
	
		for ( $i=0 ; $i<count($aColumns) ; $i++ ){
			if ( $req['bSearchable_'.$i] == "true" && $req['sSearch_'.$i] != '' ){
				if ( $sWhere == "" ){
					$sWhere = "WHERE ";
				}
				else{
					$sWhere .= " AND ";
				}
				$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
			}
		}
		return $sWhere;
	}
	
	function getSearchSql($notes){
		if($notes == null)
			return "";
		$sWhere="";
		foreach($notes as $item){		
			if($item[0] == "and"){
				if($item[1] == "varchar"){
					if($item[3] == '未填写')
						$sWhere=$sWhere."and ($item[2]='' or $item[2]='未填写' or $item[2] is null) ";
					else if($item[3] != '' && $item[3] != '-1')
						$sWhere=$sWhere."and $item[2]='$item[3]' ";
				 	
				}else if($item[1] == "int"){
					if($item[3] != '' && $item[3] != '-1')
						$sWhere=$sWhere."and $item[2]=$item[3] ";
				}else if($item[1] == "datetime"){
					$sWhere=$sWhere."and  ($item[2] between '$item[3]' and '$item[4]') ";
				}else if($item[1] == 'set'){
					if($item[2] == "like"){
						if(count($item[3])>0){
							if($item[4] != ""){
								 $sWhere.="and (";
								 $subStr="";
								 foreach($item[3] as $nitem){
								  $subStr.=" $nitem like '%$item[4]%' or";
								 }
								$sWhere.=substr_replace($subStr, "", -2);
								$sWhere.=")";		
							}
						}
					}else{
						if(count($item[3])>0){
							 $sWhere.="and (";
							 $subStr="";
							 foreach($item[3] as $nitem){
							  $subStr.=" $item[2]='$nitem' or";
							 }
							$sWhere.=substr_replace($subStr, "", -2);
							$sWhere.=")";		
						}
					}
				}
			}else if($item[0] == "or"){
				if($item[1] == "varchar"){
					if($item[3] != '' && $item[3] != '-1')
					$sWhere=$sWhere."or $item[2]='$item[3]' ";
				}else if($item[1] == "int"){
					if($item[3] != '' && $item[3] != '-1')
						$sWhere=$sWhere."or $item[2]=$item[3] ";
				}else if($item[1] == "datetime"){
					$sWhere=$sWhere."or  $item[2] between '$item[3]' and '$item[4]' ";
				}
			}else if($item[0] == "nand"){
				if($item[1] == "varchar"){
					if($item[3] != '' && $item[3] != '-1')
					$sWhere=$sWhere."and $item[2]<>'$item[3]' ";
				}		
			}else if($item[0] == "likeand"){
				if($item[1] == "varchar"){
					if($item[3] != '' && $item[3] != '-1')
					  $sWhere=$sWhere."and $item[2] like '%$item[3]%' ";
				}		
			}else if($item[0] == "likeor"){
				if($item[1] == "varchar"){
					if($item[3] != '' && $item[3] != '-1')
					$sWhere=$sWhere."or $item[2] like '%$item[3]%' ";
				}		
			}
		}
		
		//去掉where 前的and或者or
		if(substr($sWhere, 0, 2) == 'or')
			$sWhere ="where ".substr_replace($sWhere, "", 0,2);
		else if(substr($sWhere, 0, 3) == 'and')
			$sWhere ="where ".substr_replace($sWhere, "", 0,3);
		
		return $sWhere;
	}
	
	
	function getOrderSql($req,$aColumns,$defCol='',$defOrder='desc'){
		$sOrder="";
		if(isset($req['iSortCol_0'] ) ){
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $req['iSortingCols'] ) ; $i++ ){
				if ( $req[ 'bSortable_'.intval($req['iSortCol_'.$i]) ] == "true" ){
					$sOrder .= $aColumns[ intval( $req['iSortCol_'.$i] ) ]."
						".mysql_real_escape_string( $req['sSortDir_'.$i] ) .", ";
				}
			}
						
			$sOrder = substr_replace($sOrder, "", -2 );
			if ($sOrder == "ORDER BY" ){
				$sOrder = "";
				if($defCol != ''){
					$sOrder="ORDER BY $defCol $defOrder ";
				}
			}
		}
		return $sOrder;
	}
	function reverseResultBind(&$ret,&$rResult,$aColumns,$bindFields,$key="client_id"){
			
		$keysIndex=array_keys($aColumns,$key,true);
	    $keyIndex=$keysIndex[0];
		
		$bindKeysIndex=array();
		for($i=0; $i<count($aColumns); $i++){
			if(in_array($aColumns[$i],$bindFields)){
				array_push($bindKeysIndex,$i);
			}
		}
		
		$lastItemIndex=-1;
		
		foreach ($rResult as  $aRow){
			$row = array();
			for( $i=0 ; $i<count($aColumns) ; $i++ ){
				if ( $aColumns[$i] == "version" ){
					/* Special output formatting for 'version' column */
					$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
				}
				else if ( $aColumns[$i] != ' ' ){
					/* General output */
					$row[] = $aRow[ $aColumns[$i] ];
				}
			}
				
			if($lastItemIndex !=-1 && $ret[$lastItemIndex][$keyIndex] == $row[$keyIndex]){		
				//合并
				foreach($bindKeysIndex as $bindIndex){ 
					$ret[$lastItemIndex][$bindIndex].="\n".$row[$bindIndex];
				}
					
			}else{
				$ret[] = $row;	
				$lastItemIndex++;		
			}			
		}
	}
	
	function reverseResult(&$rResult,$aColumns,$idColName='client_id'){
		$ret=array();
		foreach ($rResult as  $aRow){
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] == "version" )
				{
					/* Special output formatting for 'version' column */
					$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
				}else if($aColumns[$i] == $idColName){
					$row['DT_RowId']=$aRow[$idColName];
					$row[] = $aRow[$idColName];			
				}
				else if ( $aColumns[$i] != ' ' )
				{
					/* General output */
					$row[] = $aRow[ $aColumns[$i] ];
				}
			}
			$ret[] = $row;
		}
		return $ret;
	}
}
