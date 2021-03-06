<?php
function mkfolder($path)	{
	return is_writeable($path) || mkdir($path, 0777, true);
}

function paginator($post) {
	global $site;
	$perpage = $site['config']['posts_per_page'];
	$total_pages = ceil(count($post)/$perpage);
	for($i=0;$i<$total_pages;$i++) {
		$has_next = $has_previous = true;
		if(($i+2) > $total_pages) $has_next = false;
		if($i<1) $has_previous = false; 
		$pagpost = array_slice($post, $i*$perpage, $perpage);
		$paginator[$i+1] =  array(
			'per_page' => $perpage,
			'object_list'=>$pagpost, 
			'total_pages'=> $total_pages, 
			'page' => $i+1, 
			'page_url' => $site['url'].'/page/'.($i+1),
			'previous_page' => $i,
			'pre_page' => $i, 
			'previous_page_url' => $site['url'].'/page/'.$i,
			'pre_page_url' => $site['url'].'/page/'.$i, 
			'next_page' => $i+2, 
			'next_page_url' => $site['url'].'/page/'.($i+2), 
			'has_next' => $has_next, 
			'has_previous' => $has_previous,
			'has_pre' => $has_previous
		);
	}
	return $paginator;
}


function removeDir($dirName) { 
        foreach(glob($dirName.'/*') as $dir) {
        		if(is_file($dir)) {
        			@unlink($dir);
        			continue;
        		}
                foreach(glob($dir.'/*') as $f) @unlink($f);
                rmdir($dir);
        }
}

function daily($dir) {
	$doc = array();
	foreach(glob($dir.'*') as $item) {
		if(!is_file($item)) $doc = array_merge($doc, daily($item.'/*'));
		else $doc[] = $item;
	}
	return $doc;
}
?>
