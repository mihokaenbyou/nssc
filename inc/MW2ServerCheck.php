<?php
/*
Project: MW2ServerCheck.php
Initial author: Vulcania
Credits: Matonyan for helping me find the bugs, clarify the code and add some functions.
*/
	include('inc/config.php');

	error_reporting(E_ALL ^ E_NOTICE);
	$req = $bdd->query('SELECT * FROM iw4m');
	while ($donnees = $req->fetch()) {
	
    $status = fsockopen("udp://" . $donnees['host'], $donnees['port'], $errno, $errstr, 30);
	if (!$status) {
    die ($errno.": ".$errstr); }

	socket_set_timeout ($status, 1);
	$send = "\xFF\xFF\xFF\xFFgetstatus\x00";

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

	$max_index = array_search ("sv_maxclients", $output); 
	$max_clients = $output[$max_index+1]; 

	$max_index = array_search ("mapname", $output); 
	$mapname = $output[$max_index+1];     

	$max_index = array_search ("sv_hostname", $output); 
	$hostname = $output[$max_index+1]; 
	
	$max_index = array_search ("shortversion", $output);
	$version = $output[$max_index+1];
	
	$max_index = array_search ("fs_game", $output);
	$mods = $output[$max_index+1];

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

	$max_index = array_search ("g_gametype", $output); 
	$gametype = $output[$max_index+1]; 

	// getting players informations
	$last_value     = count($output) - 1; 
	$players_string = $output[$last_value]; 

	$playersDebug = $players_string;
	
	$players_string = array_map('trim', explode("\n",$players_string));

	// removing unnecessary offset (first and last as they don't contain players)
	unset($players_string[0]);
	unset($players_string[count($players_string)]);

	$playersList = array();
	foreach ($players_string as $player) {
		$player = explode (' ', $player, 3);
		$playersList[] = array(
			'username' => "<span>" . preg_replace($patterns, $replacements, htmlspecialchars(trim($player[2], '\"'))) . "</span>",
			'score'		=> $player[0],
			'ping'		=> $player[1]
		);
	}

	$score = array();
	foreach ($playersList as $key => $row) {
	    $score[$key] = $row['score'];
	}
	
	// sorting players by their scores
	array_multisort($score, SORT_DESC, $playersList);
	$nbPlayers = count($playersList);

	$picture_src = "images/maps/" . $mapname . ".jpg"; 

	$mapname = substr($mapname, 3); 
	$mapname = ucwords($mapname);
	
	// replaces the codename of some maps by their real names
	if ($mapname == "Checkpoint"){$mapname = "Karachi";}
	elseif ($mapname == "Boneyard"){$mapname = "Scrapyard";}
	elseif ($mapname == "Nightshift"){$mapname = "Skidrow";}
	elseif ($mapname == "Subbase"){$mapname = "Sub Base";}
	elseif ($mapname == "Complex"){$mapname = "Bailout";}
	elseif ($mapname == "Compact"){$mapname = "Salvage";}
	elseif ($mapname == "Abandon"){$mapname = "Carnival";}
	elseif ($mapname == "Trailerpark"){$mapname = "Trailer Park";}
	elseif ($mapname == "Fuel2"){$mapname = "Fuel";}
	elseif ($mapname == "Brecourt"){$mapname = "Wasteland";}
	elseif ($mapname == "Cargoship"){$mapname = "Wet Work";}
	elseif ($mapname == "Cross_fire"){$mapname = "Crossfire";}
	
	// replaces the diminutive gametypes by their full names	
	if ($gametype == "war"){$gametype = "Team Deathmatch";}
	elseif ($gametype == "dm"){$gametype = "Free For All";}
	elseif ($gametype == "dom"){$gametype = "Domination";}
	elseif ($gametype == "koth"){$gametype = "Headquarters";}
	elseif ($gametype == "sab"){$gametype = "Sabotage";}
	elseif ($gametype == "sd"){$gametype = "Search & Destroy";}
	elseif ($gametype == "arena"){$gametype = "Arena";}
	elseif ($gametype == "dd"){$gametype = "Demolition";}
	elseif ($gametype == "ctf"){$gametype = "Capture the Flag";}
	elseif ($gametype == "oneflag"){$gametype = "One-Flag CTF";}
	elseif ($gametype == "gtnw"){$gametype = "Global Thermo-Nuclear War";}
	elseif ($gametype == "oitc"){$gametype = "One in the Chamber";}
	elseif ($gametype == "gg"){$gametype = "Gun Game";}
	elseif ($gametype == "ss"){$gametype = "Sharpshooter";}

	include('inc/server_template.php');
	echo '<hr />';
?>
<?php
}
$req->closeCursor();
?>