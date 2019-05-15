

var myDateTime = (new Date()).getTime();






function search() {
var string=document.getElementById("search").value;
 var xhr = new XMLHttpRequest();
 xhr.onreadystatechange = function() {
	if(xhr.readyState==4 && xhr.status==200) {
		var result=xhr.responseText;
		document.getElementById("listbox").innerHTML=result;
}
};

 xhr.open("GET", "listbox.php?ver=" + myDateTime + "&search=" + string, true);
 xhr.send(null);
}






function search_accounts() {
var string=document.getElementById("search").value;
 var xhr = new XMLHttpRequest();
 xhr.onreadystatechange = function() {
	if(xhr.readyState==4 && xhr.status==200) {
		var result=xhr.responseText;
		document.getElementById("listbox").innerHTML=result;
}
};

 xhr.open("GET", "accounts_listbox.php?ver=" + myDateTime + "&search=" + string, true);
 xhr.send(null);
}




function list_admins() {
 var xhr = new XMLHttpRequest();
 xhr.onreadystatechange = function() {
	if(xhr.readyState==4 && xhr.status==200) {
		var result=xhr.responseText;
		document.getElementById("listbox").innerHTML=result;
}
};

 xhr.open("GET", "accounts_listbox.php?ver=" + myDateTime + "&listAdmins=true", true);
 xhr.send(null);
}










function artist(name) 
	{
 	var xhr = new XMLHttpRequest();
 	xhr.onreadystatechange = function() 
		{
        	if(xhr.readyState==4 && xhr.status==200) 
			{
                	var result=xhr.responseText;
			document.getElementById("listbox").innerHTML=result;	
			}
		};
 	xhr.open("GET", "listbox.php?ver=" + myDateTime + "&artist=" + name, true);
 	xhr.send(null);
	}





function genre(name) 
	{
 	var xhr = new XMLHttpRequest();

 	xhr.onreadystatechange = function() 
		{
        	if(xhr.readyState==4 && xhr.status==200) 
			{
                	var result=xhr.responseText;
              		document.getElementById("listbox").innerHTML=result;
			}
		};

 	xhr.open("GET", "listbox.php?ver=" + myDateTime + "&genre=" + name, true);
 	xhr.send(null);
	}





function nextpage(name)
        {
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function()
                {
                if(xhr.readyState==4 && xhr.status==200)
                        {
                        var result=xhr.responseText;
                        document.getElementById("listbox").innerHTML=result;
 
                        }
                };

        xhr.open("GET", "listbox.php?calling_page=music&ver=" + myDateTime + "&pageno=" + name, true);
        xhr.send(null);
        } 




function login()
        {
        var xhr = new XMLHttpRequest();
	var username=window.document.login.email.value;
	var password=window.document.login.password.value;
        xhr.onreadystatechange = function()
                {
                if(xhr.readyState==4 && xhr.status==200)
                        {
                        var result=xhr.responseText;
                        document.getElementById("basket").innerHTML=result;
                        }
                };

        xhr.open("GET", "basket.php?email=" + username + "&password=" + password, true);
        xhr.send(null);
        }









function add_cart(songid)
        {
        var xhr = new XMLHttpRequest();

	var mylogoid = 'cartlogo' + songid;

        mylogo = document.getElementById(mylogoid);

	mylogo.style.backgroundImage = "url('./images/remove.gif')";


	mylogo.onclick = function () { remove_cart(songid); }; 


        xhr.onreadystatechange = function()
                {
                if(xhr.readyState==4 && xhr.status==200)
                        {
                        var result=xhr.responseText;
                        document.getElementById("basket").innerHTML=result;
                        }
                };

        xhr.open("GET", "basket.php?add_song=true&song_id=" + songid, true);
        xhr.send(null);
        }





function update_cart(basket_id, songid)
        {
        var xhr = new XMLHttpRequest();

	var quantityLookup = 'quantity' + songid;

	var quantity = document.getElementById(quantityLookup).value;


        xhr.onreadystatechange = function()
                {
                if(xhr.readyState==4 && xhr.status==200)
                        {
                        var result=xhr.responseText;
                        document.getElementById("basket").innerHTML=result;
                        }
                };

        xhr.open("GET", "basket.php?update_basket=true&songid=" + songid + "&quantity=" + quantity + "&basket_id=" + basket_id, true);
        xhr.send(null);
        }







function update_cart_summary(basket_id, songid)
        {
        var xhr = new XMLHttpRequest();

	var quantityLookup = 'quantity' + songid;

	var quantity = document.getElementById(quantityLookup).value;


        xhr.onreadystatechange = function()
                {
                if(xhr.readyState==4 && xhr.status==200)
                        {
                        var result=xhr.responseText;
                        document.getElementById("basket").innerHTML=result;
                        }
                };

        xhr.open("GET", "basket_summary_inner.php?update_basket=true&songid=" + songid + "&quantity=" + quantity + "&basket_id=" + basket_id, true);
        xhr.send(null);
        }





function print_invoice(basket_id)
        {
        var xhr = new XMLHttpRequest();



	iFrameID = document.getElementById("invoiceFrame");

	iFrameID.src = "./invoice/invoice.php?ver=33&basket_id=" + basket_id;

        }







function update_cart222(basket_id, songid)
        {
alert('hello');
        }





function remove_cart(songid)
        {
        var xhr = new XMLHttpRequest();

	var mylogoid = 'cartlogo' + songid;

        if( mylogo = document.getElementById(mylogoid) )

		// we HAVE to use an if here in case the song being removed from teh cart is NOT listed on teh current page.

		{

		mylogo.style.backgroundImage = "url('./images/add.gif')";

		mylogo.onclick = function () { add_cart(songid); }; 


		}

       	 xhr.onreadystatechange = function()
        	{
	
         	if(xhr.readyState==4 && xhr.status==200)
              	  	{
                      	var result=xhr.responseText;
                       	document.getElementById("basket").innerHTML=result;
                       	}
               	};
	

        xhr.open("GET", "basket.php?remove_song=true&song_id=" + songid, true);
        xhr.send(null);
        }






function delbasket(basketid,songid)
        {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function()
                {
                if(xhr.readyState==4 && xhr.status==200)
                        {
                        var result=xhr.responseText;
                        document.getElementById("basket").innerHTML=result;
                        }
                };

        xhr.open("GET", "basket.php?delete=true&deletetrack=" + songid, true);
        xhr.send(null);
        }


