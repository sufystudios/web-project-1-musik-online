<?

if(isset($_SESSION['search']))
	{$search=$_SESSION['search'];}
else  {$search="";}







## get contents of the genre and artist tables for drop down lists
$genres = get_genre_array();
$artists = get_artist_array();


if(isset($_GET['song_id'])) {  $song_id = $_GET['song_id']; }

else	{ $song_id=$_SESSION['song_id'];}



$can_activate = 1;  ## we disable this if anything is missing..
	
$song_details = get_song_details($song_id);   #returns an array of song details.

if($song_details[1] == "") { $can_activate = 0 ;}  ### no file name
if($song_details[6] == 0) { $can_activate = 0 ;}  ### no genre
if($song_details[7] == 0) { $can_activate = 0 ;}  ### no artist
if($song_details[4] == "") { $can_activate = 0 ;}  ### no description







## fix the song filename so that a red none is displayed if MT.
if($song_details[1]==""){$song_details[1] = "<a style='color:red;'>none</style>";}


if(isset($_GET['update_track']))	## if we are actually updating

	{


	if(isset($_GET['song_id']))		{$song_id = $_GET['song_id'];}
	if(isset($_GET['name']))		{$name = $_GET['name'];}
	if(isset($_GET['description']))		{$description = $_GET['description'];}



	if(isset($_GET['artist']))		{$artist = $_GET['artist'];}
	if(isset($_GET['genre']))		{$genre = $_GET['genre'];}
	if(isset($_GET['artist']))		{$artist = $_GET['artist'];}
	if(isset($_GET['track_active']))	{$track_active= $_GET['track_active'];}
		else $track_active = 0;	## this means the set active select box must be disabled..

	update_track_details($song_id, $name, $description, $artist, $genre,  $track_active);


	?>
	<script language="javascript">
	window.document.location.replace('edit.php?song_id=<?=$song_id?>');
	</script>
	<?
	}


else


	{	#if we are displaying the edit field
?>

	<div style="float:left;width:15%;">
	Name: <br /><br /><br /><br />
	Track Description: <br /><br /><br /><br />
	Active:  <br /><br /><br />
	</div>



	<div style="float:right;;width:85%;">

        	<form  method="GET"  action="edit.php" >

		<input type="hidden" name="song_id" value="<?=$song_id?>" />
		<input type="hidden" name="update_track" value="yes" />


                <label>&nbsp;<input type="text" class="textBoxEdit" name="name" id="name" value="<?=$song_details[0]; ?>" /></label>&nbsp; &nbsp; &nbsp; &nbsp;
               <label>Artist:<select name="artist" id="artist" class="selectBoxEdit">
			<?foreach (array_keys($artists) as $artist_id) { echo"<option value='$artist_id' ";
									if($song_details[7] == $artist_id) { echo " selected ";}
										echo ">$artists[$artist_id]</option>";}   ?>   
				</select></label>&nbsp; &nbsp; &nbsp; &nbsp;
		



                <label>Genre:<select name="genre" id="genre" class="selectBoxEdit">
			<?foreach (array_keys($genres) as $genre_id) { echo"<option value='$genre_id' ";
									if($song_details[6] == $genre_id) { echo " selected ";}
										echo ">$genres[$genre_id]</option>";}   ?>   
				</select></label><br /><br /><br />


 
               <label>&nbsp;<input type="text" class="textBoxEditLong" name="description" value="<?=$song_details[4]?>" /></label>
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
				SOH: <strong><?=$song_details[8]?></strong>

					<br /><br /><br />





		<label>&nbsp;<select name="track_active"  <?if($can_activate==0){echo " disabled";}?> class="selectBoxEdit">
				<option <?if($song_details[5]==0){echo " selected ";}?> value="0" >Not Active</option>
				<option <?if($song_details[5]==1){echo " selected ";}?> value="1">Active in Site</option>
				</select></label>

		
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
		<strong>Current FileName: </strong><?=$song_details[1]?>
		
		&nbsp; &nbsp; &nbsp; &nbsp; 
                <input class="clickButtonEdit" type="submit" value="Save Changes" />

	        </form>
		</div>




		<div style=" clear: both;     display: block;">
		<?if($song_details[5]==0) {echo '<a style="color:red">This song cannot be activated until all information is entered including a sound file</a>';}?>

	<br />
	<hr style="width:60%;line-color:green;" />

<br />

		<form  name="upload" enctype="multipart/form-data"  action="update_track_file.php" method="POST">
		<input type="hidden" name="song_id" value="<?= $song_id?>">
    		<label>Change File: <input type="file" name="newmp3" onchange="submit();"/></label>

		</form	



		</div>



	<?


	}	## end of else when we are displaying the edit form



       
