<?php
function retrieveResultsWhileTyping($param)
{
	global $wgContLang, $wgOut;
	$ns = NS_CATEGORY;
	$db =& wfGetDB( DB_SLAVE );
		
	// Query to get all images and files
	$dbr =& wfGetDB( DB_SLAVE );
	$imageTable = $dbr->tableName( 'image' );
	$query = "SELECT * FROM $imageTable WHERE LOWER($imageTable.img_name) LIKE LOWER('%$param%') ORDER BY img_timestamp DESC LIMIT 0,20";
	
	$res = $dbr->query($query);
    //build string of results (CSV)
	$response = "";
    while ($row = $dbr->fetchObject( $res ) ) 
	{ 
        $response .= str_replace('_', ' ', substr($row->img_name, 0, strrpos($row->img_name,'.'))) . ','; // Remove file extension and replace underscores with spaces, add comma at the end
    }  
    return $response;  
}

function searchImageGallery($param)
{
	global $wgContLang, $wgOut;
	$ns = NS_CATEGORY;
	$db =& wfGetDB( DB_SLAVE );
	$param = strtolower(str_replace(' ', '_', $param));
	// Query to get all images and files
	$dbr =& wfGetDB( DB_SLAVE );
	$imageTable = $dbr->tableName( 'image' );
	$query = "SELECT DISTINCT img_name " . 
		"FROM $imageTable " .
		"WHERE LOWER($imageTable.img_name) " . 
		"LIKE LOWER('%$param%') " .
		"ORDER BY img_timestamp DESC " .
		"LIMIT 0,20";
	$res = $dbr->query($query);
	
	/*$res = $dbr->select(
        $imageTable,                                   // $table
        "img_name" ,            // $vars (columns of the table)
        "LOWER($imageTable.img_name) LIKE LOWER('%$param%')",                              // $conds
        __METHOD__,                                   // $fname = 'Database::select',
        array( 'ORDER BY' => 'img_timestamp DESC', 'LIMIT' => 5,'OFFSET' => 0 )        // $options = array()
	);*/
	
	$ret = "";
	foreach ($res as $row) 
	{
		$image = wfFindFile($row->img_name,false,false,true);
		if($image){
			$ret .= '<li ><img frame="'.$image->createThumb(80,60).'" src="'.$image->createThumb(900,500).'" title="'.$image->getOriginalTitle().'" description="'.$image->getDescriptionText().'" url="'.$image->getDescriptionUrl().'" /></li>';
			$ret .= '-EOI-'; // End of Image sign - see Settings.js listImages function
		}
	}
	
	return $ret;
}
?>