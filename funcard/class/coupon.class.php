<?php 
include dirname(__FILE__).'/../config.php';

class Coupon_a{
	function getCoupons(){
		$db = new DB();
		$tid = $_GET['tid'];
		$wheretid = '';
		if(is_numeric($tid)){
			$wheretid = "and tn.tid=".$tid;
		}

		$sql = "select n.nid,n.title,nr.body,f.filepath,ctc.field_coupon_sort_value as weight from node n 
		left join node_revisions nr on n.nid = nr.nid 
		left join content_type_coupon ctc on ctc.nid=n.nid
		left join  term_node tn on tn.nid=n.nid 
		left join files f on f.fid = ctc.field_coupon_image_fid where n.type='coupon' and n.status = 1 ".$wheretid." order by weight desc,nid desc";
		$res = $db -> fetchAll($sql, 'nid');
		$data['res'] = $res;
		
		$nids = array();
		foreach($res as $item){
			$nids[] = $item['nid'];
		}	

		if($nids){
			
			$nids = implode(',', $nids);
			
			$sql = "select td.tid,td.name,tn.nid from term_data td inner join term_node tn on tn.tid = td.tid where tn.nid in (".$nids.")";
			
			$tagres = $db -> fetchAll($sql);	

			foreach($tagres as $tagitem){
				$data['res'][$tagitem['nid']]['tags'][] = $tagitem;
			}
		}

		return $data;
	}
	
}
?>