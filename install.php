<?php
require_once("init.php");
//For security purposes, it is MANDATORY that this page be wrapped in the following
//if statement. This prevents remote execution of this code.
if (in_array($user->data()->id, $master_account)){


$db = DB::getInstance();
include "plugin_info.php";



//all actions should be performed here.
$check = $db->query("SELECT * FROM us_plugins WHERE plugin = ?",array($plugin_name))->count();
if($check > 0){
	err($plugin_name.' has already been installed!');
}else{
 $fields = array(
	 'plugin'=>$plugin_name,
	 'status'=>'installed',
 );
 $db->insert('us_plugins',$fields);
 if(!$db->error()) {
	 	err($plugin_name.' installed');
		logger($user->data()->id,"USPlugins",$plugin_name." installed");
 } else {
	 	err($plugin_name.' was not installed');
		logger($user->data()->id,"USPlugins","Failed to to install plugin, Error: ".$db->errorString());
 }
}

$db->query("CREATE TABLE `plg_perf_log` (
	`id` int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`ms` int(11),
	`queries` int(11),
	`p_mem` int(32),
	`c_mem` int(32),
	`page` VARCHAR(255),
	`ref` VARCHAR(255),
	`by` int(32),
	`logged` DATETIME DEFAULT CURRENT_TIMESTAMP
  
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1");

} //do not perform actions outside of this statement