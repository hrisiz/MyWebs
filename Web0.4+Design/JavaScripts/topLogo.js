function startLoading(){
  x=document.getElementById("loading");
  x.innerHTML = "<p>Server is</p><h1>Loading...</h1><p>Please wait.</p><p>Click to stop.</p>";
  x.style.display="block";
  x=document.getElementById("loading");
  x.onclick = function() { backToGrizisMuLogo(); };
  n=-15;
  if(typeof refreshIntervalId != 'undefined'){
    clearInterval(refreshIntervalId);
  }
  refreshIntervalId = setInterval(function(){changeLoading()},50);
}
function successLoading(error,hover,onclick)
{
  x=document.getElementById("loading");
  if(typeof refreshIntervalId != 'undefined'){
    clearInterval(refreshIntervalId);
  }
  x=document.getElementById("loading");
  x.innerHTML = "<p>Server is</p><h1>Ready</h1><p>"+error+"</p><p>"+hover+"</p>";
  x.style.background="-webkit-linear-gradient(0deg,black,green,black)"
  x.style.background="-o-linear-gradient(0deg,black,green,black)"
  x.style.background="-moz-linear-gradient(0deg,black,green,black)"
  x.style.background="linear-gradient(0deg,black,green,black)" 
  x.onclick = function() {window.location = onclick};
  setTimeout( function() { backToGrizisMuLogo(); },10000);
}
function failLoading(error,hover,onclick)
{
  x=document.getElementById("loading");
  if(typeof refreshIntervalId != 'undefined'){
    clearInterval(refreshIntervalId);
  }
  x=document.getElementById("loading");
  x.innerHTML = "<p>Sorry your request</p><h1>Fail</h1><p>"+error+"</p><p>"+hover+"</p>";
  x.style.background="-webkit-linear-gradient(0deg,black,red,black)"
  x.style.background="-o-linear-gradient(0deg,black,red,black)"
  x.style.background="-moz-linear-gradient(0deg,black,red,black)"
  x.style.background="linear-gradient(0deg,black,red,black)" 
  x.onclick = function() {window.location = onclick};
  setTimeout( function() { backToGrizisMuLogo(); },10000);
}
function backToGrizisMuLogo(){
  if(typeof refreshIntervalId != 'undefined'){
    clearInterval(refreshIntervalId);
  }
  document.getElementById("loading").style.display="none"
  document.getElementById("logo").style.display="block"
}
function changeLoading(){ 
  x=document.getElementById("loading");
  n = n + 5
  x.style.background="-webkit-linear-gradient("+n+"deg,black,red,black)"
  x.style.background="-o-linear-gradient("+n+"deg,black,red,black)"
  x.style.background="-moz-linear-gradient("+n+"deg,black,red,black)"
  x.style.background="linear-gradient("+n+"deg,black,red,black)"
}