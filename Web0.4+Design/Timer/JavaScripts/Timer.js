function timer(s,id){
	if(s != 0){
		print_d = Math.floor(s/24/60/60);
		print_h = Math.floor((s/60/60) - (print_d*24));
		print_m = Math.floor((s/60) - (print_h*60) - (print_d*24*60));
		print_s = Math.floor(s - (print_m*60) - (print_h*60*60) - (print_d*24*60*60));
		document.getElementById(id).innerHTML = print_d + " Days " +print_h+" Hours "+print_m+" Minutes "+print_s+" Seconds"
	}else{
		location.reload();
	}

}
function start_timer(){
  date=new Date();
  end_date = new Date("July 17, 2014 20:00:00 GMT+0300");
  time = new Date(end_date.getTime()-date.getTime());
  
  start_timer = parseInt(time.getTime()/1000);
  // document.getElementById("timer").innerHTML = start_timer/24/60/60
  timer(start_timer,"timer");
  setInterval(function(){timer(start_timer--,"timer");},1000);
}