<?
include_once("mysql/mysql.php");
include_once("mysql/func_music.php");
include_once("mysql/func_account.php");
include_once("getaccountdetails.php");
echo "<script src=\"js/ajax.js\"></script>";
$search = "";
$calling_page = "";
$pageno = "0";		## sets default in case we are on the first listed page in pagination. (from music.php)


if(!is_user_admin($account_id) && $account_id > 0)  ## only if someone logged in.

        {
        $basket_id = get_basket_id($account_id);
        }



if(isset($_GET['search'])   && $_GET['search']!="" )  $search=$_GET['search'];


## fix up any possible weird chars

$search = addslashes($search);



if(isset($_GET['artist']))  $search_artist=$_GET['artist'];
else $search_artist="";

if(isset($_GET['genre']))  $search_genre=$_GET['genre'];
else $search_genre="";

if(isset($_GET['calling_page'])) $calling_page=$_GET['calling_page']; 	# so we know if we are here from music.php rather that index.php search by a calling page value of music



if(isset($_GET['pageno']))  $pageno=$_GET['pageno'];







#############################################################################################################################
## ## we have come here from the main index.php.. this will now show a particular set of songs on each day..
#############################################################################################################################


if($search=="featured-music")   	

	{

	$num_active_songs = 0;
	$song_index = array();		## an array to match a simple numeric list to the active song ids


	$query="  Select track_id from track where track_active = '1' ORDER BY track_id  ";
	$run=mysql_query($query);

	while($row=mysql_fetch_array($run)) 

		{
	
		$song_index[$num_active_songs] = $row[0];
		$num_active_songs++;  ## this index is used so teh randaom generator can match to an active song.	
		}



	$dotw = date('w') + 1;		## gets current day of the week for selecting songs.. 1 to 7.. not 0


	echo "<div style=\"font-size:14px;font-family:\'Comic Sans MS\', \'Comic Sans\', cursive;\"> Today's Featured Tracks</div><br /><br />";



	$number_songs_to_display_for_loop = $num_active_songs + 1;

	if($number_songs_to_display_for_loop > 4) $number_songs_to_display_for_loop = 4;  # makes sure we never look for more than three songs..



	for ($x=1; $x<$number_songs_to_display_for_loop; $x++)		## display up to three songs.. or whatever music ada yang baik

		{
	
	
		$selected = round($num_active_songs / $dotw, 1) ;

		if($selected < 1 ) $select = 1;
		elseif($selected >= $num_active_songs) $selected = $num_active_songs - 1;	# makes sure we don't go past teh end of array remaining
			
		## display the song box for the current song index
		$_GET['song_id']=$song_index[$selected];
		include('songdetails.php');	

		array_splice($song_index, $selected, 1);		## remove that value from array

		$num_active_songs--;				## reduce the size of the array index by 1

		echo"<br />";
	
		}


	}















#############################################################################################################################
## NOWwe have come from teh search area or music.php with no search entered.. show first six songs.. OR showing search query
#############################################################################################################################



elseif ($calling_page=="music" && strlen($search)==0 && strlen( $search_artist)==0 && strlen($search_genre)==0)		

	{

	$query="SELECT * from track ";


	## do some page number fun..
	if(!isset($_GET['pageno']))  $pageno=0;			## 0 is first page
	else $pageno = $_GET['pageno'];

	if(!is_user_admin($account_id))	
		{
		$query.=" WHERE track_active='1'  ";
		}
	
	

	$result_from = $pageno * 5;		## 1,6,11,15 etc
	$result_to = $pageno * 5 + 6;		## 5,11,15,19 etc


	
	$query.=" LIMIT $result_from ,$result_to ";


	$run=mysql_query($query);

	$result_number_this_page = 1;

	$last_page = 1; ## our marker looking for last pages.. gets set to zero if there is at least one more record.
	
	while($row=mysql_fetch_array($run)) 
		{


		if($result_number_this_page > 5)

			{

			$page_display = "  <div style=\"float:right;\">   ";  	# we clear this page display value each page

			if($pageno)		## if we are NOT in the fist page, show a last page link too..
				{
			
				$thispage = $pageno + 1;  ## for display only.
				$lastpage = $pageno - 1;  ## for display only.
				$page_display .= "<a href=\"javascript:void(0)\" onclick=\"nextpage($lastpage);\">Last Page</a>"; 
				}


			$page_display .= "&nbsp; | &nbsp;";

			$nextpage = $pageno+1;		## we start at 0, so display 1 at first page etc
			?>
			<a style="float:left;">Page <?=$nextpage?>...</a>
			<?
			$page_display.="<a href=\"javascript:void(0);\" onclick=\"nextpage($nextpage);\">Next Page</a> ";
			
			echo "$page_display</div>";

			$last_page = 0;	## there is at least one more record.. set this to zero

			break;		## breaks teh while loop at line 112
			
			}


		else

			{
			if(isset($basket_id))		## if we ar the admin.. there may be no basket id
				{
				$_GET['basket_id']=$basket_id;
				}
			$_GET['song_id']=$row[0];
			include('songdetails.php');
			echo"<br />";
			$result_number_this_page ++;

			}

		}		## end for each resulst raow











	if($pageno && $last_page)	## if we have been paginating.. and we are finished.. pritn the last back number with a back butt..
	
		{
			
		$thispage = $pageno + 1;  ## for display only.
		$lastpage = $pageno - 1;  ## for display only.
		?>
		<a style="float:left;">...Page <?=$thispage?></a>

		<div style="float:right;"><a href="javascript:void(0)" onclick="nextpage(<?=$lastpage?>)" >Last Page</a> &nbsp; | &nbsp;</div>
		<?
		}


	}		# end if calling from music page (might be a search from music page)






else	## if we ar running a search from searchbox	, display not hits here.

	{

	$number_of_matches = 0;	

	## first we must remove the leading underscore from teh search_genre and search_artist, put there because id fields cannot start with a numeral in TFV


	$search_genre = preg_replace("/^\_/","",$search_genre);
	$search_artist = preg_replace("/^\_/","",$search_artist);


	$query = "
	SELECT track.track_id, track.track_name, genre.genre_name, artist.artist_name
	FROM track
	INNER JOIN artist ON track.track_artist_id = artist.artist_id
	INNER JOIN genre ON track.track_genre_id = genre.genre_id
	WHERE ";

	if(strlen($search_artist)>0) {$query.= "track_artist_id = '$search_artist' "; }
	elseif(strlen($search_genre)>0) {$query.= "track_genre_id = '$search_genre' "; }
	else   {$query.= "(artist_name LIKE '%$search%' or track_name LIKE '%$search%'  or track_description LIKE '%$search%' ) ";}

	$query.=" AND track_active='1' ORDER BY track_active DESC  ";
	///echo $query;

	$run=mysql_query($query);
	$result_number_this_page = 1;
	
	while($row=mysql_fetch_array($run)) 
		{

		$number_of_matches++;

		if( $result_number_this_page > 30)

			{

			print "<a style=\"font-style:italic; text-align:center;\"> More results.. please refine search..</a> ";

			break;

			}

		else

			{
	
			$_GET['song_id']=$row[0];
			$_GET['search']=$search;

			include('songdetails.php');
			echo"<br />";
			$result_number_this_page ++;

			}

		}


	if ($number_of_matches == 0) 		print "<a style=\"font-style:italic; text-align:center;\"> No matches for <a class=\"searchMatch\">$search</a>, please try again.</a> ";




	}















