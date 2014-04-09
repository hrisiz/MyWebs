function timer(s,id){
	if(s != 0){
		print_h = Math.floor(s/60/60);
		print_m = Math.floor((s/60) - (print_h*60));
		print_s = Math.floor(s - (print_m*60) - (print_h*60*60));
		document.getElementById(id).innerHTML = print_h+" Hours "+print_m+" Minutes "+print_s+" Seconds"
	}else{
		location.reload();
	}
					
}

function timer_start(seconds,id){
	setInterval(function(){timer(--seconds,id)},1000);
}

function update_info(id,new_value){
	document.getElementById(id).innerHTML=new_value;
}

function get_file(id,file){
	var xmlhttp;
	if (file.length==0)
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
		}
		if (xmlhttp.readyState==4 && xmlhttp.status==403)
		{
			document.getElementById(id).innerHTML="<p>Page not found</p>";
		}
	}
	xmlhttp.open("POST","ajex.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("file="+file);
}