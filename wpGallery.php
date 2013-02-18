<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/wpGallery/wpGallery.php" );
EOT;
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'File Gallery',
	'author' => 'Isaac CONTRERAS',
	'url' => '',
	'description' => 'File Gallery extension',
	'descriptionmsg' => 'File Gallery extension for Wikiprogress and Wikigender',
	'version' => '0.1',
);

$wgResourceModules['ext.wpGallery'] = array(
        // JavaScript and CSS styles. To combine multiple file, just list them as an array.
        'scripts' => array( 'js/jquery.easing.1.3.js', 'js/jquery.galleryview-3.0-dev.js', 'js/jquery.timers-1.2.js', 'js/settings.js','js/jquery.color.js','js/script.js', 'js/jquery.blockUI.js'),
        'styles' => array('css/jquery.galleryview-3.0-dev.css','css/searchbarstyle.css'),

		// If your scripts need code from other modules, list their identifiers as dependencies
        // and ResourceLoader will make sure they're loaded before you.
        // You don't need to manually list 'mediawiki' or 'jquery', which are always loaded.
         'dependencies' => array( 'jquery.ui.autocomplete' ),
 
        // ResourceLoader needs to know where your files are; specify your
        // subdir relative to "/extensions" (or $wgExtensionAssetsPath)
        'localBasePath' => dirname( __FILE__ ),
        'remoteExtPath' => 'wpGallery'
);

$dir = dirname(__FILE__) . '/';
 
/* Ajax Configuration */
require_once $dir . "searchImageGallery.php";
$wgUseAjax = true;
$wgAjaxExportList[] = 'searchImageGallery';
$wgAjaxExportList[] = 'retrieveResultsWhileTyping';

/* Load Classes */
$wgAutoloadClasses['wpGallery'] = $dir . 'wpGallery_body.php'; # Location of the wpGallery class (Tell MediaWiki to load this file)
$wgExtensionMessagesFiles['wpGallery'] = $dir . 'wpGallery.i18n.php'; # Location of a messages file (Tell MediaWiki to load this file)
$wgExtensionAliasesFiles['wpGallery'] = $dir . 'wpGallery.alias.php'; # Location of an alias file (Tell MediaWiki to load this file)
$wgSpecialPages['wpGallery'] = 'wpGallery'; # Tell MediaWiki about the new special page and its class name
$wgSpecialPageGroups['wpGallery'] = 'media';