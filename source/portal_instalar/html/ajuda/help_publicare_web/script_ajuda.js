/* ***** Functions made by */
/* ©2006 Helca Batista Gonzaga */
/* hgonzaga@mct.gov.br */

		/* -----
	 FUNÇÃO PARA TÓPICOS ESCONDIDOS:  MOSTRA QUANDO CLICADO UMA VEZ, OCULTA QUANDO CLICADO A SEGUNDA VEZ
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


		/* -----
	 FUNÇÃO PARA AS DICAS:  MOSTRA QUANDO CLICADO UMA VEZ, OCULTA QUANDO CLICADO A SEGUNDA VEZ
	--------- */

   function JSClicouOuNaoClicou(objeto) {
   		if (objeto.className == 'dcontexto')
			objeto.className='dcontexto dcontexto2';
		else
			objeto.className='dcontexto';
	}
	