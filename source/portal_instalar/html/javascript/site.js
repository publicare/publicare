	/* -----
	 FUNÇÃO PARA O MENU:  MOSTRA QUANDO CLICADO UMA VEZ, OCULTA QUANDO CLICADO A SEGUNDA VEZ
	--------- */

        function expandeAreasAtuacao(id_objeto, img_dinamica, localResult)
        {
            x = document.getElementById(id_objeto);
            img = document.getElementById(img_dinamica);
            if (x.style.display == '')
            {
                x.style.display = 'none';
                img.src = "/html/imagens/site/bullet-mais.gif";
            }else{
                x.style.display = '';
                img.src = "/html/imagens/site/bullet-menos.gif";

                // verifica se ja existe alguma coisa no menu, se existir, significa que o menu ja foi carregado,
                // portanto, nao ha necessidade de recarregar, deixando o site mais leve
                if(document.getElementById(localResult).innerHTML == ""){
                  pegaConteudoGET('/index.php/content/view/1.html?execview=menu_areas_atuacao_ajax&naoincluirheader', localResult);
                }
            }
        }


		/* -----
	 FUNÇÃO PARA O MENU:  MOSTRA QUANDO CLICADO UMA VEZ, OCULTA QUANDO CLICADO A SEGUNDA VEZ
	--------- */

	function JSMostraeOculta(id_objeto,codImagem,id_objeto_tmp){
	   
	   img = document.getElementById(codImagem);
	   
       if (id_objeto.style.display == ''){
           id_objeto.style.display = 'none';
           
           if(img){
           		img.src = "/html/imagens/site/bullet-mais.gif";
           }
           if (id_objeto_tmp){
                id_objeto_tmp.style.display = '';
           }
       }
       else{
           id_objeto.style.display = '';
           
           if(img){
           		img.src = "/html/imagens/site/bullet-menos.gif";
           }
           if (id_objeto_tmp){
                id_objeto_tmp.style.display = 'none';
           }
       }
   }

		/* -----
	 FUNÇÃO: QUE TROCA O ICONE DE MAIS POR MENOS E VICE VERSA, É NECESSÁRIO PASSAR O ID DO OBJETO 
	 		 QUE SERÁ MOSTRADO E OCULTADO PARA SINCRONIZAR COM O SINAL DE MAIS E MENOS
	--------- */

	function JSTrocaIcnMaisMenos(id_objeto,codImagem){
	   
	   img = document.getElementById(codImagem);
	   
       if (id_objeto.style.display == ''){
           
           if(img){
           		img.src = "/html/imagens/site/icn_mais.jpg";
           }
           
       }
       else{
           
           if(img){
           		img.src = "/html/imagens/site/icn_menos.jpg";
           }
       }
   }

   /*function JSMostraeOcultaFilhos(codigoDiv,codigoImagem)
	{
		//alert(codigoDIV + " e "+codigoImagem);
		if(document.getElementById(codigoDiv).style.display == "none")
		{
			document.getElementById(codigoDiv).style.display = "";
			document.getElementById(codigoImagem).innerHTML = "<a href='#lista' onclick='JSMostraeOcultaFilhos(" + codigoDiv + "," + codigoImagem +");'><img src='/html/imagens/site/bullet-menos.gif' width='13' height='13' border='0' align='absmiddle'/></a>";
                        pegaConteudoGET('/index.php/content/view/' + codigoImagem + '.html?execview=listatodos_ajax&naoincluirheader', codigoDiv);
		}
		else
		{
			document.getElementById(codigoDiv).style.display = "none";
			document.getElementById(codigoImagem).innerHTML = "<a href='#lista' onclick='JSMostraeOcultaFilhos(" + codigoDiv + "," + codigoImagem +");'><img src='/html/imagens/site/bullet-mais.gif' width='13' height='13' border='0' align='absmiddle'/></a>";
		}
	}
	
	
	
	function JSMostraeOcultaNetos(codigoSubDiv,codigoSubImagem)
	{
		//alert(codigoSubDiv);
		if(document.getElementById(codigoSubDiv).style.display == "none")
		{
			document.getElementById(codigoSubDiv).style.display = "";
			document.getElementById(codigoSubImagem).innerHTML = "<a href='#lista' onclick='JSMostraeOcultaNetos(" + codigoSubDiv + "," + codigoSubImagem +");'><img src='/html/imagens/site/bullet-menos.gif' width='13' height='13' border='0' align='absmiddle'/></a>";
                        pegaConteudoGET('/index.php/content/view/' + codigoSubImagem + '.html?execview=listanetos_ajax&naoincluirheader', codigoSubDiv);
		}
		else
		{
			document.getElementById(codigoSubDiv).style.display = "none";
			document.getElementById(codigoSubImagem).innerHTML = "<a href='#lista' onclick='JSMostraeOcultaNetos(" + codigoSubDiv + "," + codigoSubImagem +");'><img src='/html/imagens/site/bullet-mais.gif' width='13' height='13' border='0' align='absmiddle'/></a>";
		}
	}
	
	function JSMostraeOcultaEstrutura(codigoSubDiv,codigoSubImagem)
	{
		//alert(codigoSubDiv);
		if(document.getElementById(codigoSubDiv).style.display == "none")
		{
			document.getElementById(codigoSubDiv).style.display = "";
			document.getElementById(codigoSubImagem).innerHTML = "<a href='#lista' onclick='JSMostraeOcultaEstrutura(" + codigoSubDiv + "," + codigoSubImagem +");'><img src='/html/imagens/site/bullet-menos.gif' width='13' height='13' border='0' align='absmiddle'/></a>";
                        pegaConteudoGET('/index.php/content/view/' + codigoSubImagem + '.html?execview=listanetos_estrutura&naoincluirheader', codigoSubDiv);
		}
		else
		{
			document.getElementById(codigoSubDiv).style.display = "none";
			document.getElementById(codigoSubImagem).innerHTML = "<a href='#lista' onclick='JSMostraeOcultaEstrutura(" + codigoSubDiv + "," + codigoSubImagem +");'><img src='/html/imagens/site/bullet-mais.gif' width='13' height='13' border='0' align='absmiddle'/></a>";
		}
	}
	*/
   /*
	function JSMostraeOcultaNova(codigoSubDiv,codigoSubImagem,execview)
	{
		//alert(codigoSubDiv);
		
		if(document.getElementById(codigoSubDiv).style.display == "none")
		{
			document.getElementById(codigoSubDiv).style.display = "";
			//document.getElementById(codigoSubImagem).innerHTML = "<a href='#lista' onclick=JSMostraeOcultaNova(" + codigoSubDiv + "," + codigoSubImagem + ",'" +  execview + "');><img src='/html/imagens/site/bullet-menos.gif' width='13' height='13' border='0' align='absmiddle'/></a>";
			document.getElementById(codigoSubImagem).src = "/html/imagens/site/bullet-menos.gif";
      		pegaConteudoGET('/index.php/content/view/' + codigoSubImagem + '.html?execview=' + execview + '&naoincluirheader', codigoSubDiv);
		}
		else
		{
			document.getElementById(codigoSubDiv).style.display = "none";
			//document.getElementById(codigoSubImagem).innerHTML = "<a href='#lista' onclick=JSMostraeOcultaNova(" + codigoSubDiv + "," + codigoSubImagem + "," + "'" + execview + "'" + ");><img src='/html/imagens/site/bullet-mais.gif' width='13' height='13' border='0' align='absmiddle'/></a>";
			document.getElementById(codigoSubImagem).src = "/html/imagens/site/bullet-mais.gif";
		}
	}
	*/
	/* -----
	 FUNÇÃO QUE MOSTRA A TD QUE ESCONDE OS FILHOS DO OBJETO E TROCA A IMG MAIS PELA IMG MENOS QUANDO CLICADO UMA VEZ, OCULTA QUANDO CLICADO A SEGUNDA VEZ
	 E DESTROCA A IMAGEM MENOS PARA MAIS
	--------- */
	function JSMostraFilhosComAjax(idDivResultado,codObjeto,execview)
	{
		if(document.getElementById(idDivResultado).style.display == "none")
		{
			document.getElementById(idDivResultado).style.display = "";
			document.getElementById(codObjeto).src = "/html/imagens/site/bullet-menos.gif";
			
			//Verifica se o conteúdo da DIV já foi carregado clicando uma vez no sinal de MAIS
			//se já estiver sido carregado ele não busca de novo o conteudo pelo ajax	
            if(document.getElementById(idDivResultado).innerHTML == ""){
      			pegaConteudoGET('/index.php/content/view/' + codObjeto + '.html?execview=' + execview + '&naoincluirheader', idDivResultado);
            }
		}
		else
		{
			document.getElementById(idDivResultado).style.display = "none";
			document.getElementById(codObjeto).src = "/html/imagens/site/bullet-mais.gif";
		}
	}

	function JSMostraeOcultaNovo(id_objeto)
	{
	if (document.getElementById(id_objeto).style.display == ''){
		document.getElementById(id_objeto).style.display = 'none';
	}
	else{
		document.getElementById(id_objeto).style.display = '';
	}
	}

	function JSMostraeOcultaEditais(codigoDiv,codigoImagem,execView,ano,agencia,fundo,eixo,programa)
	{
		//alert(programa);
		if(document.getElementById(codigoDiv).style.display == "none")
		{
			document.getElementById(codigoDiv).style.display = "";
			/*document.getElementById(codigoImagem).innerHTML = "<a href='#lista' onclick='JSMostraeOcultaEditais(" + codigoDiv + "," + codigoImagem +");'><img src='/html/imagens/site/bullet-menos.gif' width='13' height='13' border='0' align='absmiddle'/></a>";*/
                        pegaConteudoGET('/index.php/content/view/' + codigoImagem + '.html?execview=' + execView + '&naoincluirheader&ano=' + ano + '&agencia=' + agencia + '&fundo=' + fundo + '&eixo=' + eixo + '&programa=' + programa, codigoDiv);
		}
		else
		{
			document.getElementById(codigoDiv).style.display = "none";
			/*document.getElementById(codigoImagem).innerHTML = "<a href='#lista' onclick='JSMostraeOcultaFilhos(" + codigoDiv + "," + codigoImagem +");'><img src='/html/imagens/site/bullet-mais.gif' width='13' height='13' border='0' align='absmiddle'/></a>";*/
		}
	}

	/* -----
	FUNÇÃO QUE FAZ A TROCA (VISUAL) DE UM OBJETO NA TELA
	CASO ID_STATUS SEJA UM, O OBJETO ANTERIOR NÃO SERÁ RETIRADO DA TELA
	--------- */
	var tblAcao;
    function JSSwapObject(id_tbl,id_status){
    	//alert(id_tbl);
    	if (tblAcao && id_status != 1){
    		document.getElementById(tblAcao).style.display = 'none';
    	}
    	document.getElementById(id_tbl).style.display = '';
    	tblAcao = id_tbl;

    }
    
	var tblAcao;
    function JSSwapObject_v2(id_tbl,id_status,id_objeto_tmp,id_objeto_tmp2,id_objeto_tmp3){
    	
    	if (tblAcao && id_status != 1)
    		tblAcao.style.display = 'none';
    	
    	id_tbl.style.display = '';
    	
		if (id_objeto_tmp)
           	id_objeto_tmp.style.display = 'none';
           	
		if (id_objeto_tmp2)
        	id_objeto_tmp2.style.display = 'none';
        	
        if (id_objeto_tmp3)
            id_objeto_tmp3.style.display = 'none';
	
    	tblAcao = id_tbl;

    } 


		/* -----
	 FUNÇÃO PARA ABRIR UM LINK DE OBJETO - POR DENTRO DO PORTAL (OBJETO,NECESSARIAMENTE)
	--------- */

	function JSJanelaAncoraObjeto(id_objeto,w,h,scroll,popup){
		if (popup)
			window.open("/index.php/content/view/"+id_objeto+".html","JanelaAncoraObjeto","menubar=no,width="+w+",heigth="+h+",statuds=no,scrollbars="+scroll);
		else
			window.open("/index.php/content/view/"+id_objeto+".html","JanelaAncoraObjeto");
		window.focus;
	}




		/* -----
	FUNCÃO PARA ABRIR JANELAS DE LINKS EXTERNOS (i.e: http://google.com)
	--------- */

	function JSJanelaAncoraURL(url,w,h,scroll,popup){
		if (popup)
				window.open(url,"JanelaAncoraURL","menubar=no,width="+w+",heigth="+h+",statuds=no,scrollbars="+scroll);
			else
				window.open(url,"JanelaAncora");
	}


		/* -----
	innerHTML: ESCREVE QUALQUER TEXTO EM QUALQUER OBJETO
	i.e: JSWriteOnObject(id do objeto,'conteúdo de texto entre aspas',staus);
	status: define se o texto anterior será mantido ou sobreposto (1 - sobreposto, 0 - mantido)
	--------- */

	function JSWriteOnObject(id_object,hol_text,tynSelect){
		if (tynSelect)
			id_object.innerHTML = hol_text;
		else
			id_object.innerHTML += hol_text;
	}



		/* -----
	Função para mudança de página dentro de uma mesma janela do Browser.
	--------- */

	function JSChangePage(CURL,AURL){
		if (AURL)
			top.window.location.href = CURL+'?'+AURL;
		else
			top.window.location.href = CURL;
	}


	function JsTrocaMenu(menu)
	{
                document.getElementById('menuAreasAtuacao').style.dislpay='';
                if(menu == 'pa')
                {
                        document.getElementById('menuPlanoAcao').style.display = '';
                        document.getElementById('menuAreasAtuacao').style.display = 'none';
                        document.getElementById('abaLeft').className = 'vertPlanoAcaoSelect linkMenuVrt';
                        document.getElementById('abaRight').className = 'vertAreasAtuacao linkMenuVrt';
                }
                else if(menu == 'aa')
                {
                        document.getElementById('menuPlanoAcao').style.display = 'none';
                        document.getElementById('menuAreasAtuacao').style.display = '';
                        document.getElementById('abaRight').className = 'vertAreasAtuacaoSelect linkMenuVrt';
                        document.getElementById('abaLeft').className = 'vertPlanoAcao linkMenuVrt';

                        // verifica se ja existe alguma coisa no menu, se existir, significa que o menu ja foi carregado,
                        // portanto, nao ha necessidade de recarregar, deixando o site mais leve
                        if(document.getElementById('menuAreasAtuacao').innerHTML == ""){
                          pegaConteudoGET('/index.php/content/view/1.html?execview=menu_areas_atuacao_ajax&naoincluirheader', 'menuAreasAtuacao');
                        }
                }

                url = "/html/objects/gravaSessaoMenu.php?navSess="+menu;
                rs = pegaConteudoGETSemRetorno(url);
	}

  function MM_findObj(n, d)
  { //v4.01
    var p,i,x;
    if(!d)
      d=document;

    if((p=n.indexOf("?"))>0 && parent.frames.length)
    {
      d=parent.frames[n.substring(p+1)].document;
      n=n.substring(0,p);
    }

    if(!(x=d[n]) && d.all)
      x=d.all[n];

    for (i=0;!x&&i<d.forms.length;i++)
      x=d.forms[i][n];

    for(i=0;!x&&d.layers && i<d.layers.length;i++)
      x=MM_findObj(n,d.layers[i].document);

    if(!x && d.getElementById)
      x=d.getElementById(n);

    return x;
  }

  function MM_changeProp(objName,x,theProp,theValue)
  { //v6.0
      var obj = MM_findObj(objName);

      if (obj && (theProp.indexOf("style.")==-1 || obj.style))
      {
          if (theValue == true || theValue == false)
              eval("obj."+theProp+"="+theValue);
          else
              eval("obj."+theProp+"='"+theValue+"'");
      }
  }

  /*------
  FUNÇÃO UTILIZADA PARA TROCAR AS CLASSES DAS ABAS SELECIONADAS E DESCELECIONADAS
  -------*/
  function JSTrocaAbaGef(idTabela)
  {
		if(idTabela.id == "tbl_caract_projetos")
		{
			JSSwapObject(idTabela);

			document.getElementById("caracteristicaProjeto").className = "fundoAbas linkAbaHomeTitulo";
			document.getElementById("caracteristicaProjetoL").className = "abaLeft";
			document.getElementById("caracteristicaProjetoR").className = "abaRight";
			document.getElementById("caracteristicaProjetoC").className = "paddingAbaHome";

			document.getElementById("dadosGerais").className = "linkAbaHomeTitulo paddingAbaHome";
			document.getElementById("dadosGeraisL").className = "";
			document.getElementById("dadosGeraisR").className = "";
			document.getElementById("dadosGeraisC").className = "";

			document.getElementById("tramitacaoProjeto").className = "linkAbaHomeTitulo paddingAbaHome";
			document.getElementById("tramitacaoProjetoL").className = "";
			document.getElementById("tramitacaoProjetoR").className = "";
			document.getElementById("tramitacaoProjetoC").className = "";
		}

		if(idTabela.id == "tbl_tramit_projeto")
		{
			JSSwapObject(idTabela);

			document.getElementById("tramitacaoProjeto").className = "fundoAbas linkAbaHomeTitulo";
			document.getElementById("tramitacaoProjetoL").className = "abaLeft";
			document.getElementById("tramitacaoProjetoR").className = "abaRight";
			document.getElementById("tramitacaoProjetoC").className = "paddingAbaHome";

			document.getElementById("dadosGerais").className = "linkAbaHomeTitulo paddingAbaHome";
			document.getElementById("dadosGeraisL").className = "";
			document.getElementById("dadosGeraisR").className = "";
			document.getElementById("dadosGeraisC").className = "";

			document.getElementById("caracteristicaProjeto").className = "linkAbaHomeTitulo paddingAbaHome";
			document.getElementById("caracteristicaProjetoL").className = "";
			document.getElementById("caracteristicaProjetoR").className = "";
			document.getElementById("caracteristicaProjetoC").className = "";
		}

		if(idTabela.id == "tbl_dados_gerais")
		{
			JSSwapObject(idTabela);

			document.getElementById("dadosGerais").className = "fundoAbas linkAbaHomeTitulo";
			document.getElementById("dadosGeraisL").className = "abaLeft";
			document.getElementById("dadosGeraisR").className = "abaRight";
			document.getElementById("dadosGeraisC").className = "paddingAbaHome";

			document.getElementById("caracteristicaProjeto").className = "linkAbaHomeTitulo paddingAbaHome";
			document.getElementById("caracteristicaProjetoL").className = "";
			document.getElementById("caracteristicaProjetoR").className = "";
			document.getElementById("caracteristicaProjetoC").className = "";

			document.getElementById("tramitacaoProjeto").className = "linkAbaHomeTitulo paddingAbaHome";
			document.getElementById("tramitacaoProjetoL").className = "";
			document.getElementById("tramitacaoProjetoR").className = "";
			document.getElementById("tramitacaoProjetoC").className = "";
		}
	}
	
	/*------
	FUNÇÃO UTILIZADA PARA APAGAR O CONTEÚDO DO OBJETO ENVIADO
	-------*/
	function JSApagaConteudo(id_objeto){
		document.getElementById(id_objeto).innerHTML = "";
	}
	
	function JsTrocaBanner(banner)
	{
		if(banner == 'de')
		{
			document.getElementById('emDestaques').style.display = '';
			document.getElementById('editais').style.display = 'none';
			document.getElementById('fndct').style.display = 'none';
			document.getElementById('eventos').style.display = 'none';
			document.getElementById('links').style.display = 'none';
		}
		else if(banner == 'ee')
		{
			document.getElementById('editais').style.display = '';
			document.getElementById('emDestaques').style.display = 'none';
			document.getElementById('fndct').style.display = 'none';
			document.getElementById('eventos').style.display = 'none';
			document.getElementById('links').style.display = 'none';
		}
		else if(banner == 'fn')
		{
			document.getElementById('fndct').style.display = '';
			document.getElementById('editais').style.display = 'none';
			document.getElementById('emDestaques').style.display = 'none';
			document.getElementById('eventos').style.display = 'none';
			document.getElementById('links').style.display = 'none';
		}
		else if(banner == 'ev')
		{
			document.getElementById('eventos').style.display = '';
			document.getElementById('editais').style.display = 'none';
			document.getElementById('emDestaques').style.display = 'none';
			document.getElementById('fndct').style.display = 'none';
			document.getElementById('links').style.display = 'none';
		}
		else if(banner == 'lk')
		{
			document.getElementById('links').style.display = '';
			document.getElementById('editais').style.display = 'none';
			document.getElementById('emDestaques').style.display = 'none';
			document.getElementById('eventos').style.display = 'none';
			document.getElementById('fndct').style.display = 'none';
		}
	}
	
	function JsTrocaAbaFontes(banner)
	{
		if(banner == 'de')
		{
			document.getElementById('emDestaques').style.display = '';
			document.getElementById('editais').style.display = 'none';
			document.getElementById('fndct').style.display = 'none';
			document.getElementById('eventos').style.display = 'none';
			document.getElementById('links').style.display = 'none';
			document.getElementById('fundos_ct').style.display = 'none';
		}
		else if(banner == 'ee')
		{
			document.getElementById('editais').style.display = '';
			document.getElementById('emDestaques').style.display = 'none';
			document.getElementById('fndct').style.display = 'none';
			document.getElementById('eventos').style.display = 'none';
			document.getElementById('links').style.display = 'none';
			document.getElementById('fundos_ct').style.display = 'none';
		}
		else if(banner == 'fn')
		{
			document.getElementById('fndct').style.display = '';
			document.getElementById('editais').style.display = 'none';
			document.getElementById('emDestaques').style.display = 'none';
			document.getElementById('eventos').style.display = 'none';
			document.getElementById('links').style.display = 'none';
			document.getElementById('fundos_ct').style.display = 'none';
		}
		else if(banner == 'ev')
		{
			document.getElementById('eventos').style.display = '';
			document.getElementById('editais').style.display = 'none';
			document.getElementById('emDestaques').style.display = 'none';
			document.getElementById('fndct').style.display = 'none';
			document.getElementById('links').style.display = 'none';
			document.getElementById('fundos_ct').style.display = 'none';
		}
		else if(banner == 'lk')
		{
			document.getElementById('links').style.display = '';
			document.getElementById('editais').style.display = 'none';
			document.getElementById('emDestaques').style.display = 'none';
			document.getElementById('eventos').style.display = 'none';
			document.getElementById('fndct').style.display = 'none';
			document.getElementById('fundos_ct').style.display = 'none';
		}
		else if(banner == 'fc')
		{
			document.getElementById('links').style.display = 'none';
			document.getElementById('editais').style.display = 'none';
			document.getElementById('emDestaques').style.display = 'none';
			document.getElementById('eventos').style.display = 'none';
			document.getElementById('fndct').style.display = 'none';
			document.getElementById('fundos_ct').style.display = '';
		}
	}
	
	function JsTrocaBannerAreas(banner)
	{
		if(banner == 'dt')
		{
			document.getElementById('emDestaques').style.display = '';
			document.getElementById('eventos').style.display = 'none';
			document.getElementById('noticias').style.display = 'none';
		}
		else if(banner == 'ev')
		{
			document.getElementById('eventos').style.display = '';
			document.getElementById('emDestaques').style.display = 'none';
			document.getElementById('noticias').style.display = 'none';
		}
		else if(banner == 'nt')
		{
			document.getElementById('noticias').style.display = '';
			document.getElementById('eventos').style.display = 'none';
			document.getElementById('emDestaques').style.display = 'none';
		}
	}
	
	function JsTrocaBannerPlano(banner)
	{
		if(banner == 'dt')
		{
			document.getElementById('emDestaques').style.display = '';
			document.getElementById('eventos').style.display = 'none';
			document.getElementById('noticias').style.display = 'none';
			document.getElementById('editais').style.display = 'none';
			document.getElementById('ficha_tecnica').style.display = 'none';
			document.getElementById('principais_resultados').style.display = 'none';
		}
		else if(banner == 'ev')
		{
			document.getElementById('eventos').style.display = '';
			document.getElementById('emDestaques').style.display = 'none';
			document.getElementById('noticias').style.display = 'none';
			document.getElementById('editais').style.display = 'none';
			document.getElementById('ficha_tecnica').style.display = 'none';
			document.getElementById('principais_resultados').style.display = 'none';
		}
		else if(banner == 'nt')
		{
			document.getElementById('noticias').style.display = '';
			document.getElementById('eventos').style.display = 'none';
			document.getElementById('emDestaques').style.display = 'none';
			document.getElementById('editais').style.display = 'none';
			document.getElementById('ficha_tecnica').style.display = 'none';
			document.getElementById('principais_resultados').style.display = 'none';
		}
		else if(banner == 'ed')
		{
			document.getElementById('editais').style.display = '';
			document.getElementById('eventos').style.display = 'none';
			document.getElementById('emDestaques').style.display = 'none';
			document.getElementById('noticias').style.display = 'none';
			document.getElementById('ficha_tecnica').style.display = 'none';
			document.getElementById('principais_resultados').style.display = 'none';
		}
		else if(banner == 'ft')
		{
			document.getElementById('editais').style.display = 'none';
			document.getElementById('eventos').style.display = 'none';
			document.getElementById('emDestaques').style.display = 'none';
			document.getElementById('noticias').style.display = 'none';
			document.getElementById('principais_resultados').style.display = 'none';
			document.getElementById('ficha_tecnica').style.display = '';
		}
		else if(banner == 'pr')
		{
			document.getElementById('editais').style.display = 'none';
			document.getElementById('eventos').style.display = 'none';
			document.getElementById('emDestaques').style.display = 'none';
			document.getElementById('noticias').style.display = 'none';
			document.getElementById('ficha_tecnica').style.display = 'none';
			document.getElementById('principais_resultados').style.display = '';
		}
	}
	
	function JsTrocaBannerEditais(banner)
	{
		if(banner == 'ed')
		{
			document.getElementById('editais').style.display = '';
			document.getElementById('resultados').style.display = 'none';
		}
		else if(banner == 're')
		{
			document.getElementById('resultados').style.display = '';
			document.getElementById('editais').style.display = 'none';
		}
	}
	

	/*------
	FUNÇÃO UTILIZADA TROCAR ABAS,
	-------*/
	function JsTrocaAbas(id,qtdeAbas,nomeAba)
	{
		for (var i=0; i < qtdeAbas; i++)
		{
			if(id == nomeAba+i)	
			{				
				var idTabelaConteudo = "conteudo_"+id;
								
				JSSwapObject(idTabelaConteudo);
				
				document.getElementById(nomeAba+i).className = "fundoAbas linkAbaHomeTitulo";
				document.getElementById(nomeAba+i+"L").className = "abaLeft";
				document.getElementById(nomeAba+i+"R").className = "abaRight";
				document.getElementById(nomeAba+i+"C").className = "paddingAbaHome";
			}
			else
			{
				//verifica se aba existe antes de tentar aplicar o class
				if(document.getElementById(nomeAba+i))
				{
					document.getElementById(nomeAba+i).className = "linkAbaHomeTitulo paddingAbaHome";
					document.getElementById(nomeAba+i+"L").className = "";
					document.getElementById(nomeAba+i+"R").className = "";
					document.getElementById(nomeAba+i+"C").className = "";
				}
			}
		}
	}
	

	/*------
	FUNÇÃO UTILIZADA PARA ABRIR POP-UP'S
	-------*/
	function abrirPopUp(endereco) {
		var width = 400;
		var height = 100;
		var left = 40
		var top = 50
		window.open(endereco,'diretoria','width='+width+' , height='+height+', top='+top+', left='+left+', scrollbars=yes,fullscreen=no');
	}	
	
	function janelafloat(nome){ 
		var startX = 200, 
		startY = 200; 
		var ns = (navigator.appName.indexOf("Netscape") != -1); 
		var d = document; 
	
		function ml(id){ 
   			var el=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id]; 
   			if(d.layers)el.style=el; 
      		el.sP = function(x,y){this.style.left=x;this.style.top=y;}; 
      		el.x = startX; 
  			el.y = ns ? pageYOffset + innerHeight : document.body.scrollTop + document.body.clientHeight; 
   			el.y -= startY; 
   			return el; 
		} 
	
		window.stayTopLeft=function(){ 
   			var pY = ns ? pageYOffset : document.body.scrollTop; 
   			ftlObj.y += (pY + startY - ftlObj.y)/2; 
      		ftlObj.sP(ftlObj.x, ftlObj.y); 
      		setTimeout("stayTopLeft()", 10); 
   		} 
    
		ftlObj = ml(nome); 
    	stayTopLeft(); 
	}

	function sleep(milliseconds) {
	  var start = new Date().getTime();
	  for (var i = 0; i < 1e7; i++) {
	    if ((new Date().getTime() - start) > milliseconds){
	      break;
	    }
	  }
	}