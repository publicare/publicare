/* JS***** Functions made by Daniel von Paraski */
/* �2006 Daniel von Paraski */
/* http://vonparaski.com */

		/* -----
	Fun��o de coleta de informa��es dos Checkboxes dispon�veis na tela de Admiinstra��o de Log de Acesso
	--------- */

	function JSCalendarioChangeData(url, ano, mes, dia){
		var iporigem = "";
		var state = "";
		var obj1 = document.getElementById('state_1');
		var obj2 = document.getElementById('state_2');
		var obj3 = document.getElementById('iporigem_2');
		var obj4 = document.getElementById('iporigem_3');
		//alert(obj1.checked);
		if (!mes)
			mes = "";
		if (!dia)
			dia = "";
		
		if ((obj1.checked) && (obj2.checked))
			state = 4;
		else {
			if ((!obj1.checked) && (!obj2.checked))
				state = 1;
			else {
				if (obj1.checked)
					state = 2;
				else
					state = 3;
			}
		}
		
		if ((obj3.checked) && (obj4.checked))
			iporigem = 4;
		else {
			if ((!obj3.checked) && (!obj4.checked))
				iporigem = 1;	
			else {
				if (obj3.checked)
					iporigem = 2;
				else
					iporigem = 3;
			}
		}
		top.window.location.href = url + "?year=" + ano + "&month=" + mes + "&day=" + dia+ "&state=" + state+ "&iporigem=" + iporigem;
	}

		/* -----
	Fun��o que faz a sele��o (ou desele��o) das caixas de marca��o (checkboxes) em v�rias telas do sitema
	--------- */	
		
	function toggle(formName)
	{		
		for (f=0;f<document.getElementById(formName).length;f++)
		{
			
			document.forms[formName][f].checked = !document.forms[formName][f].checked;
		}
 	}

		/* -----
	 FUN��O  MOSTRA OBJETO QUANDO CLICADO UMA VEZ, OCULTA QUANDO CLICADO A SEGUNDA VEZ
	 	ATEN��O: existe a repeti��o desta fun��o no website, por�m, h� necessidade da mesma quando no menu interno do sistema
	--------- */

	function JSMostraeOculta(id_objeto,id_objeto_tmp){
       if (id_objeto.style.display == ''){
           id_objeto.style.display = 'none';
            if (id_objeto_tmp)
                id_objeto_tmp.style.display = '';
       }
       else{
           id_objeto.style.display = '';
            if (id_objeto_tmp)
                id_objeto_tmp.style.display = 'none';
       }
   } 		
