<?

if(isset($_SESSION['search']))
	{$search=$_SESSION['search'];}
else  {$search="";}


if(!isset($_GET['track_name']))


	{
	?>

	<div style="float:left;width:50%">
	<br /><br />
        <form  method="GET" name="addTrack" action="add.php" >

               <label>New Track Name: <input type="text" class="textBox" name="track_name" id="trackName" value="" onKeyUp="updateCurrentTrackList();"/></label>
		<br />
		<br />
	<input type='submit' class="clickButtonEdit" value="Add Song">
       </form>
	</div>





	<div style="float:right">
	<br /><br />

	<div id="matchedSongs">

	<iframe style="width:300px;height:300px;overflow:hidden;border:none;" seamless="seamless" scrolling="no"  src="listcurrenttracks.php" id="currentSongs"></iframe>

	</div>
	</div>

	<?
	}   ## end section for the form to add a new file name






       
else			## add teh song to teh db adn redirect to teh edit song form


	{


	
	$track_id = add_track_to_database($_GET['track_name']);


	?>
	<script language='javascript'>
	window.document.location.replace('edit.php?new_track=yes&song_id=<?=$track_id?>');
	</script>

	<?
	}   ## end section for the form to add a new file name


       
