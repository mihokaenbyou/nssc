<div class="container">
<div style="margin:20px; margin-top:5px">
    <div class="quotetitle">
        <b>Debug:</b>
        <input type="button" value="Afficher" style="width:45px;font-size:10px;margin:0px;padding:0px;" onclick="if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = '';        this.innerText = ''; this.value = 'Cacher'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerText = ''; this.value = 'Afficher'; }" />
</div>
    <div class="quotecontent">
        <div style="display: none;">
            <?php 
                echo "<pre>";
                print_r($output);
                echo "</pre>";
            ?>
        </div>
    </div>
</div>

<?php /* <table class="table table-striped">
    <tr>
		<th>Server name</th>
		<th>IP:Port</th>
        <th>Nb Players</th>
    </tr>
	<tr>
		<td><?php echo $hostname; ?></td>
		<td>IP:Port</td>
		<td><?php echo $max_clients; ?></td>
	</tr>
</table>
*/ ?>