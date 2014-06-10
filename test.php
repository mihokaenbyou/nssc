<head>
        <title>CoD4 Server List</title>
</head>
 
<?php
 
        echo "CoD 4 Server Queryier<br />";
 
        //$QUERY = "ffffffff6765747365727665727320495734203134322066756c6c20656d70747900";
        //$QUERY = "ÿÿÿÿgetservers 3 full empty";
        $QUERY = "\xFF\xFF\xFF\xFFgetservers full\x00";
 
        $SOCK = @fsockopen("udp://cod4master.activision.com", 20810, $ERR, $ERR_STR, 3);
       
        if( !$SOCK )
        {
                echo "Could not connect to CoD 4 master server<br />";
        }else{
                echo "Connected to CoD 4 master server<br />";
               
                fwrite($SOCK, $QUERY);
                echo "Sent query to CoD 4 master server<br /><br />";
               
                $numServers = 0;
                $maxServers = 1500;
               
                if( isset($_GET['max']) )
                {
                        $maxServers = ((int) $_GET['max']);
                }
               
                if( $maxServers > 1500 )
                {
                        $maxServers = 1500;
                        echo "Reset max servers to 1500...<br />";
                }
               
                while(true)
                {
                        $contents = fread($SOCK, 64000);
                       
                        $contents = explode("\\", $contents);
                       
                        for($i=1; $i < count($contents); $i++)
                        {
                                $good = true;
                                $parsed = $contents[$i];
                                $ip = "";
                                $port = "";
                               
                                for($ii=0;$ii<4;$ii++)
                                {
                                        if( isset($parsed[$ii]) == false )
                                        {
                                                $good = false;
                                        }else{
                                                $ip .= ((int) ord($parsed[$ii]));
                                        }
                                       
                                        if($ii != 3)
                                        {
                                                $ip .= ".";
                                        }
                                }
                                if( isset($parsed[4]) == false || isset($parsed[5]) == false )
                                {
                                        $good = false;
                                }else{
                                        $port = 256 * ((int) ord($parsed[4])) + ((int) ord($parsed[5]));
                                }
                               
                                if( $good )
                                {
                                        echo $ip . ":" . $port;
                                        echo "<br />";
                                        $numServers++;
                                }
                               
                                if($numServers >= $maxServers)
                                {
                                        break;
                                }
                        }
                       
                        if($numServers >= $maxServers)
                        {
                                break;
                        }
                }
               
                fclose($SOCK);
                echo "<br /><br />Disconnected from CoD 4 master server<br />";
                echo "We found [" . $numServers . "] servers";
        }
       
?>
<div class="container">

<div style="margin:20px; margin-top:5px">
    <div class="quotetitle">
        <b>Server List Debug:</b>
        <input type="button" value="Afficher" style="width:45px;font-size:10px;margin:0px;padding:0px;" onclick="if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = '';        this.innerText = ''; this.value = 'Cacher'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerText = ''; this.value = 'Afficher'; }" />
    </div>
    <div class="quotecontent">
        <div style="display: none;">
            <?php 
                echo "<pre>";
                print_r($contents);
                echo "</pre>";
            ?>
        </div>
    </div>
</div>