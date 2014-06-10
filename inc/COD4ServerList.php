<?php
/*
Project: COD4ServerList.php
Initial author: Fuyuneko / Vulcania
*/

/* List of cod4 master servers:

set sv_master1 "cod4master.activision.com"
set sv_master2 "cod4authorize.activision.com"
set sv_master3 "cod4master.infinityward.com"
set sv_master3 "cod4update.activision.com"
set sv_master4 "master.gamespy.com:28960"
set sv_master5 "master0.gamespy.com"
set sv_master6 "master1.gamespy.com"
set sv_master7 "clanservers.net"
*/
	error_reporting(E_ALL ^ E_NOTICE);
	
	// Attempts to connect to cod4 master server
	$host = 'cod4master.activision.com';
	$port = '20810';
    $status = fsockopen("udp://" . $host, $port, $errno, $errstr, 10);
	if (!$status) {
    die ($errno.": ".$errstr); }

	socket_set_timeout ($status, 1);
	$send = "\xFF\xFF\xFF\xFFgetservers full";

	fwrite ($status, $send);
	$output = fread ($status, 5000);
		
	if (! empty ($output)) { 
		do { 
			$status_pre = socket_get_status ($status); 
			$output = $output . fread ($status, 1); 
			$status_post = socket_get_status ($status); 
	  } while ($status_pre[unread_bytes] != $status_post[unread_bytes]); 
	}; 

	fclose($status); 
	
	// Select the variables from the $output array: 
	$output = explode ("\\", $output); 

/*	$max_index = array_search("sv_hostname", $output); 
	$hostname = $output[$max_index+1]; 
	
	$max_index = array_search("sv_maxclients", $output); 
	$max_clients = $output[$max_index+1]; 

	$max_index = array_search("mapname", $output); 
	$mapname = $output[$max_index+1]; 
	
	$max_index = array_search("shortversion", $output);
	$version = $output[$max_index+1];
	
	$max_index = array_search("fs_game", $output);
	$mods = $output[$max_index+1];
	
	$max_index = array_search("g_gametype", $output); 
	$gametype = $output[$max_index+1]; 
	
	// color code
	$patterns = array();
	for ($i = 0; $i <= 9; $i++) {
		$patterns[$i] = '/\^' . $i . '/';
	}

	$replacements = array();
	$replacements[0] = 'black';
	$replacements[1] = 'red';
	$replacements[2] = 'green';
	$replacements[3] = 'yellow';
	$replacements[4] = 'blue';
	$replacements[5] = 'lightblue';
	$replacements[6] = 'purple';
	$replacements[7] = 'white';
	$replacements[8] = 'darkred';
	$replacements[9] = 'grey';
	foreach ($replacements as $key => $val) {
		$replacements[$key] = '</span><span style="color: ' . $replacements[$key] . '">';
	}

	$hostname = "<span>" . preg_replace($patterns, $replacements, $hostname) . "</span>";

	// getting server list
	$last_value    = count($output) - 1;	
	$server_string = $output[$last_value]; 

	$serverDebug = $server_string;
	
	$server_string = array_map('trim', explode("\n",$server_string));

	// removing unnecessary offset (first and last as they don't contain servers)
	unset($server_string[0]);
	unset($server_string[count($server_string)]);

	$serverList = array();
	foreach ($server_string as $server) {
		$server = explode (' ', $server, 3);
		$serverList[] = array(
			'hostname' 		=> "<span>" . preg_replace($patterns, $replacements, htmlspecialchars(trim($server[2], '\"'))) . "</span>",
			'ipport'		=> $server[0],
			'clients'		=> $server[1]
		);
	}
*/
	include('inc/template.php');
?>