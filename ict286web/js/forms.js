


function checkEmailExisting()
	
	{

	var emailContent = "";

	var returnValue = false;  // set default

	emailContent = window.document.loginEmail.email.value;

	if (returnValue = validateEmailOrName(emailContent))

		{

		return true;


		}

	else

		{

		window.document.getElementById('javascriptResponseExisting').innerHTML='Please enter email and password';
		
		window.document.loginEmail.email.value='';

		window.document.loginEmail.email.focus();
	
		return false;

		}

	
	}




function updateCurrentTrackList()

	{

	 searchString = document.getElementById('trackName').value;
	 iframeLink = document.getElementById('currentSongs');
   	 iframeLink.src="listcurrenttracks.php?searchString=" + searchString;

	}





function checkEmailNew()
	
	{
	var emailContent = "";
	var returnValue = false;  // set default
	emailContent = window.document.create.email.value;
	if (returnValue = validateEmail(emailContent))
		{
		return true;
		}

	else
		{
		window.document.getElementById('javascriptResponseNew').innerHTML='Please enter valid email adress';
		window.document.create.email.value='';
		window.document.create.email.focus();
		return false;
		}
	}



function validateEmail(emailContent)
	{
	if (/\S+@\S+\.\S+/.test(emailContent))
		{
		return (true)
		}

	else
	
		{

		return false;

		}
	}









function validateEmailOrName(content)

	{


	if(content.length > 3 && content != '{username or email address}' && content != '{username or email address}' )
	
		{
		return true;
		}

	else
	
		{
		return false;
		}

	}

