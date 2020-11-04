// JavaScript Document
function JSMostraeOculta(id_objeto,id_objeto_tmp){ 
	//alert(id_objeto+'--'+id_objeto_tmp);
 	if (document.getElementById(id_objeto).style.display == ''){ 
	document.getElementById(id_objeto).style.display = 'none';
	if (!id_objeto_tmp) document.getElementById(id_objeto_tmp).style.display = ''; }
	else  {
	document.getElementById(id_objeto).style.display = '';
	if (!id_objeto_tmp) document.getElementById(id_objeto_tmp).style.display = 'none'; }
	}
	 
