<div class="songdetailsbox">
<?php

### first get the array of all song details from the function in /mysql/func_music.php

$song_details = get_song_details($_GET['song_id']);
$songid=$_GET['song_id'];
if(isset($_GET['search'])) $search = $_GET['search'];	## used for bolding serached stuff
	else {$search = "ZZZZzxcvbnmZZ";}  ## to make sure our regex matches nothing.

$song_name = $song_details[1];

$song_name = rawurlencode ($song_name);  	# as we are encoding for an audio source we cannot have an + in the string..



$file_path = "./Audio/$song_name";

## now replace the search stuff with <strong><strong>

$song_details[0] = preg_replace("/$search/i","<a class=\"searchMatch\">$0</a>",$song_details[0]);
$song_details[3] = preg_replace("/$search/i","<a class=\"searchMatch\">$0</a>",$song_details[3]);
$song_details[4] = preg_replace("/$search/i","<a class=\"searchMatch\">$0</a>",$song_details[4]);





echo '<div class="innersongdetaildiv" style="width:45%;position:relative; float:left;">';
echo "<strong>Title: </strong>$song_details[0]<br />";
echo "<strong>Genre: </strong>$song_details[2]<br />";
echo "<strong>Artist: </strong>$song_details[3]<br />";
echo "<strong>Description: </strong>$song_details[4]<br />";
echo '</div>';


echo '<div class="innersongdetaildiv"  style="width:45%;position:relative;display: inline-block;">';
echo "Preview Song";


if($song_details[5]==0) {echo ' <div style="color:red;float:right;display:inline">INACTIVE TRACK</div> ';} ## track_active set to 0


############################################################################
# The audio controls="" below is to shut tfv up.. bitches if no attributes #
############################################################################

echo "<br />";
?><audio controls="" style="height:60%;width:95%;"><source src="<?=$file_path?>" type="audio/mpeg" /></audio><br /><?
echo '</div>';


echo '<div class="innersongdetaildiv"  style="width:10%;position:relative; float:right;">';



if(!isset($account_id) || $account_id == 0 )		#if guest user

	{

	?><br /><br />Login to buy<?

	}


elseif(is_user_admin($account_id))		#admin user cannot purchase, but can edit song details..

	{

	?><br /><br /><a href="edit.php?song_id=<? echo $songid; ?>">Edit song</a><br/> <?

	}

else	#regular user can buy 

	{


	if(track_in_basket($songid,$basket_id))

		{

		 ?><script src="js/ajax.js"></script><input type="button"  class="removeButton" id="cartlogo<?=$songid?>"  onClick="remove_cart('<? echo $songid; ?>');" ><?

		}

	else

		{

		 ?><script src="js/ajax.js"></script><input type="button"  class="addButton"  id="cartlogo<?=$songid?>"  onClick="add_cart('<? echo $songid; ?>');" ><?

		}




	}

echo '</div>';
 
?> 

</div>
