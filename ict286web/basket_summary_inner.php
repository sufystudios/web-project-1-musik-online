<?
$num_items_in_basket = 0;

if(session_id() == '') {

session_start();
}
include_once("mysql/func_account.php");
include_once("mysql/func_music.php");
include_once("getaccountdetails.php");
## now run a fuction from func_account to return a basket id for the user (if not an admin).. the function will find an unfinished basket or create a new basket.

$basket_id = 0 ;   ##for guest users or admin users there is no basket.

if(!is_user_admin($account_id))

        {

        $basket_id = get_basket_id($account_id);

        }





if(isset($_GET['basket_id'])) {$basket_id = $_GET['basket_id'];} else{ $basket_id = 0;}




if(isset($_GET['update_basket']) && $basket_id > 0)  #this means we are have chagned a quantity on one of the tracks

        {
        update_basket_quantities($basket_id, $_GET['songid'], $_GET['quantity']);
        }

$cart_value = 0;   ## we use this to stop the finalization of an orderif there is NO value..

$cart_value = print_basket_details_for_checkout($basket_id);


### now display a form to finalize this..

?>

<form method="GET" action ="account_details.php">
<input type="hidden" name="finalize_cart" value="yes">
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
&nbsp; &nbsp; &nbsp; &nbsp; 
<input type="button" class="clickButtonBuyNow" <?if($cart_value == "" || $cart_value == 0){print " disabled " ;}?> value="Buy Now !" onClick="submit();">
</form>