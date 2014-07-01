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

function showNews(number){
  x=document.getElementById("news"+number);
  if(x.style.display == "block"){
    x.style.display="none";
  }
  else{
    x.style.display="block";
  }
}

function make_to_button(item,page){
  function get_nextsibling(n)
  {
    x=n.nextSibling;
    while (x.nodeType!=1){
      x=x.nextSibling;
    }
    return x;
  }
  change = get_nextsibling(item);
  accname = document.URL.split("&").pop();
  accname = accname.split("=").pop();
  if(change.childNodes[0].tagName == "INPUT"){
    new_value = change.childNodes[0].value
    change.innerHTML=new_value
    loadAjaxPage(page+"&acc="+accname+"&valueType="+item.childNodes[0].nodeValue+"&newValue="+new_value,"success_edit");
  }else{
    change.innerHTML="<input size='10' value='"+change.childNodes[0].nodeValue+"'/>"
  }
}