<!doctype html>
<head id="www-sitename-com" data-template-set="html5-reset">
	<meta charset="utf-8">	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">	
	<title>New Server Status Checker</title>	
	<link rel="stylesheet" href="css/bootstrap.css" />
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
	<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
</head>
<body>
<div class="wrapper"><!-- not needed? up to you: http://camendesign.com/code/developpeurs_sans_frontieres -->
	<header>		
		<h1><a href="/">New Server Status Checker</a></h1>		
		<nav>		
			<ol>
				<li><a href="">Accueil</a></li>
				<li><a href="mw2_servers.php">MW2 Servers</a></li>
				<li><a href="">Nav Link 3</a></li>
			</ol>		
		</nav>	
	</header>	
	<article>		
		<h2>Websites</h2>		
		<p><?php
	// Server Status Checker r3 by Fuyuneko - Websites
		try {
		$bdd = new PDO('mysql:host=localhost;dbname=fuyuneko', 'root', 'c3tn!k60');
	  }
		catch (Exception $e) {
        die('Error: ' . $e->getMessage());
	  }
		$timestart=microtime(true);
		$reponse = $bdd->query('SELECT * FROM ssc ORDER BY name');
 
		while ($donnees = $reponse->fetch()) {
        echo "<strong>Server name: </strong>" . $donnees['name'] . "<br>";
        echo "<strong>Server IP: </strong>" . $donnees['host'] . "<br>";
        $status = @fsockopen($donnees['host'], $donnees['port'], $errno, $errstr, 1);
        echo "<strong>Status: </strong>";
        if($status) {
		echo 'ONLINE';
	  } else {
		echo 'OFFLINE';
	  }
		?></p>
<?php
}
$reponse->closeCursor();
?>
					
	</article>
	
	<aside>
	
		<h2>Sidebar Content</h2>
	
	</aside>
	
	<footer>
		
		<p><small>&copy; Copyright Fuyuneko 2013. All Rights Reserved. - <?php
$timeend=microtime(true);
$time=$timeend-$timestart;
$page_load_time = number_format($time, 3);
echo 'Generated on ' . $page_load_time . ' seconds';
?></small></p>
		
	</footer>

</div>

<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
		 http://chromium.org/developers/how-tos/chrome-frame-getting-started -->
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->

<!-- Grab Google CDN's jQuery. fall back to local if necessary -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>window.jQuery || document.write("<script src='_/js/jquery-1.9.1.min.js'>\x3C/script>")</script>

<!-- this is where we put our custom functions -->
<!-- don't forget to concatenate and minify if needed -->
<script src="_/js/functions.js"></script>

<!-- Asynchronous google analytics; this is the official snippet.
	 Replace UA-XXXXXX-XX with your site's ID and uncomment to enable.
	 
<script>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-XXXXXX-XX']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
-->
  
</body>
</html>
