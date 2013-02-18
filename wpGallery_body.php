<?php
class wpGallery extends SpecialPage {
	function __construct() {
		parent::__construct( 'wpGallery' );
		wfLoadExtensionMessages('wpGallery');
	}
 
	function execute( $par ) {
		global $wgOut;
 		$wgOut->addModules( 'ext.wpGallery' );
		$this->setHeaders();
		# the code for the class
		$wgOut->addHTML($this->setOptionsForWpGallery());
		$wgOut->addHTML('<form id="gallerySearchForm" action="#">
                <fieldset>
                    <div class="input">
                        <input type="text" name="s" id="s" value="Enter your search" />
						<input type="submit" id="searchSubmit" value="" />
                    </div>
                </fieldset>
            </form>');
		$wgOut->addHTML('<ul id="myGallery">');
		
		// Query to get all images and files
		$dbr =& wfGetDB( DB_SLAVE );
		$imageTable = $dbr->tableName( 'image' );
		
		$res = $dbr->query(
			"SELECT DISTINCT img_name " . 
			"FROM $imageTable " .
			"ORDER BY img_timestamp DESC " .
			"LIMIT 0,15");
		
		while ($row = $dbr->fetchObject( $res ) ) 
		{
			$image = wfFindFile($row->img_name,false,false,true);
			if($image)
				$wgOut->addHTML('<li style="display:none;"><img frame="'.$image->createThumb(80,60).'" src="'.$image->createThumb(900,500).'" title="'.$image->getOriginalTitle ().'" description="'.$image->getDescriptionText().'" url="'.$image->getDescriptionUrl().'" /></li>');
		}
        $wgOut->addHTML('</ul>');
	}
	
	function setOptionsForWpGallery(){
	return <<<EOT
<style type="text/css">
	body { 
		margin: 2em; 
		font-family: Arial, Helvetica, sans-serif;
	}
</style>
EOT;
	}
}
