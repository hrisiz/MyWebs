function loadAjexPage(page,id){
  startLoading()
	var xmlhttp;
	if (page.length==0)
	{ 
		document.getElementById(id).innerHTML="";
		return;
	}
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById(id).innerHTML=xmlhttp.responseText;
			  window.history.pushState("state","title", "?page="+page) ;
			  successLoading("Page was successfully load.","Everything is OK","#")
		}
		if (xmlhttp.readyState==4 && xmlhttp.status==403)
		{
			failLoading("Page not found","Click to refresh","");
		}
    if (xmlhttp.readyState==4 && xmlhttp.status==404)
		{
			failLoading("Server Problem.","Click to refresh","");
		}
	}
	xmlhttp.open("POST","ajax.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("page="+page);
}