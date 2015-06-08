<?php

/*
 * This file is used by POSitive Commerce PCLink during the upload process
 *  to trigger a re-index of all indexes.
 */

ini_set("display_errors","On");
set_time_limit(0);
ini_set('memory_limit','1024M');
require_once './app/Mage.php';
umask( 0 );

/*****Use for single Magento store*/
//Mage :: app( "default" );
/*****Use for multiple Magento stores - Might also work for single stores*/
Mage :: app(Mage::app()->getStore()); 


//Flush Catalog Images Cache
Mage::getModel('catalog/product_image')->clearCache();
//End flush

//Clean Magento Cache
Mage::app()->cleanCache();
//End Clean Cache

//John probably found this code from here - but I have modified it below
//magento-zend.blogspot.com/2011/11/magento-indexing-through-command-line.html

if(defined('STDIN') )//if it is via command line then
{
	echo("Running from CLI \n");
	$processNo=isset($argv[1])?$argv[1] : 1;
}
else
// otherwise do non command line stuff
{
	echo("Running through Browser <br>");
	$processNo=(isset($_GET['process']))? $_GET['process'] : 1 ;
}
 
echo "\n<br>Started Indexing At:  " . date("d/m/y h:i:s");
	for ($index = 1; $index <= 8; $index++) { //added this line
	//$process = Mage::getModel('index/process')->load($processNo);
	$process = Mage::getModel('index/process')->load($index); //changed $processNo to $index
	$process->reindexAll();
	}
echo "\n<br>Indexing Completes At: ".date("d/m/y h:i:s");


?>