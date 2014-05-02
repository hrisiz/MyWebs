function show_id(id) {
	var element = document.getElementById('show_id-'+id);
	if(element.style.display == 'block')
	{
		element.style.display = 'none';
	}
	else
	{
		element.style.display = 'block';
	}
}

function price(sum, fixed_price)
{
	document.getElementById('merket_price').innerHTML = Math.ceil(sum * fixed_price);
}

function isNumber(sum)
{
	var numb = isFinite(sum.value);
	if(numb == false)
	{
		sum.value = '';
		return false;
	}
	return true;
}