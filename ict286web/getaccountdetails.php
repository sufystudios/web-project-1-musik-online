<?
### this file should be included at the top of any primary php file, not in included files.


if (!isset($_SESSION)) { session_start(); }


$account_id='';


if(isset($_GET['logoutUser']) && $_GET['logoutUser']=='yes' ) { $_SESSION['accountid'] = 0; $_GET['password'] = "";}



if(isset($_SESSION['accountid'])  && $_SESSION['accountid'] > 0 ) 
	{ 
	$account_id=$_SESSION['accountid']; 
	}



elseif(isset($_GET['email']) && isset($_GET['password'])   ) 

	{
	$account_id = check_login($_GET['email'],$_GET['password']);
	if(check_admin($account_id)) {
		$_SESSION['admin']=1;
	}
	if($account_id)		## above returns 0 on fail
		{
		$_SESSION['accountid']=$account_id;
		}

	}
else
	{ 
	$account_id=0; 	
	}


$username = get_user_name($account_id);
$fullname = get_full_name($account_id);



if(isset($_GET['password'])) $password = $_GET['password'];
else{$password="";}
