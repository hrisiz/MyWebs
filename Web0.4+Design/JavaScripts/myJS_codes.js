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