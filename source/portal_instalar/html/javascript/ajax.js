	var obj = new Array();// variável global para o objeto XMLHttp
	var num_ajax = 0;

/*-------
FUNÇÃO QUE CRIA O OBJETO XMLHttp, VERIFICANDO SE O BROWSER SUPORTA A CRIAÇÃO DESSE OBJETO
--------*/
function criaObjetoXMLHttp(){

        var objXMLHttp;
        try {

                // CRIA A PARTIR DE UM OBJETO NATIVO XMLHttpRequest -> Mozila, Safari
                if (window.XMLHttpRequest) {
                        objXMLHttp = new XMLHttpRequest();

                        if (objXMLHttp.readyState == null) {
                                objXMLHttp.readyState = 1;

                                objXMLHttp.addEventListener("load", function () {
                                        objXMLHttp.readyState = 4;

                                        if (typeof objXMLHttp.onreadystatechange == "function")
                                                objXMLHttp.onreadystatechange();
                                }, false);
                        }

                        return objXMLHttp;
                }

                // CRIA O OBJETO APARTIR DO ActiveXObject -> IE Microsoft
                if (window.ActiveXObject) {
                         var prefixes = ["MSXML3", "MSXML2", "MSXML", "Microsoft"];

                        for (var i = 0; i < prefixes.length; i++) {
                                try {
                                        objXMLHttp = new ActiveXObject(prefixes[i] + ".XmlHttp");
                                        //alert('criou' + prefixes[i]);
                                        return objXMLHttp;
                                } catch (ex) {}
                        }
                }
        } catch (ex) {}
   alert('O seu Browser não suporta XmlHttp Objects\n Portanto a sua rotina AJAX não pode funcionar.');
   // throw new Error("O seu Browser não suporta XmlHttp Objects");

}

/*-------
FUNÇÃO QUE MANDA OS DADOS PARA O SERVIDOR via GET
--------*/
function pegaConteudoGET(url, local){

        obj[local] = criaObjetoXMLHttp();

        if (obj[local]){
                obj[local].open("GET",url,true);
                obj[local].setRequestHeader('Content-Type','text/xml');
                obj[local].setRequestHeader('encoding','ISO-8859-1');
                obj[local].onreadystatechange = function processadorMudancaEstado(to) {
                        if (obj[local].readyState == 4) {
                                if (obj[local].status == 200) {
                                        texto = extraiScript(obj[local].responseText);
                                        document.getElementById(local).innerHTML = obj[local].responseText;
                                }else{
                                        alert('Ocorreu um problema ao recber os dados:\n' + obj[local].statusText);
                                }
                        }else{
                                document.getElementById(local).innerHTML = '<p align=\"center\"><img src="/html/imagens/site/loading.gif" align="absmiddle"> &nbsp;Carregando dados...&nbsp;</p>';
                        }
                }
                obj[local].send(null);
        }
}

/*-------
FUNÇÃO QUE MANDA OS DADOS PARA O SERVIDOR via GET
--------*/
function pegaConteudoGETSemRetorno(url){

        obj['vazio'] = criaObjetoXMLHttp();

        if (obj['vazio']){
                obj['vazio'].open("GET",url,true);
                obj['vazio'].setRequestHeader('Content-Type','text/xml');
                obj['vazio'].setRequestHeader('encoding','ISO-8859-1');
                obj['vazio'].onreadystatechange = function processadorMudancaEstado(to) {
                        if (obj['vazio'].readyState == 4) {
                                if (obj['vazio'].status == 200) {
                                        x = obj['vazio'].responseText;
                                }else{
                                        alert('Ocorreu um problema ao recber os dados:\n' + obj['vazio'].statusText);
                                }
                        }
                }
                obj['vazio'].send(null);
        }
}

/*-------
FUNÇÃO QUE MANDA OS DADOS PARA O SERVIDOR via GET e nao retorna nada
--------*/
function pegaConteudoGETsemPrint(url, local){
      obj[local] = criaObjetoXMLHttp();
      if (obj[local]){
              obj[local].open("GET",url,true);
              obj[local].setRequestHeader('Content-Type','text/html');
              obj[local].setRequestHeader('encoding','ISO-8859-1');
              obj[local].onreadystatechange = function processadorMudancaEstado(to) {
                      if (obj[local].readyState == 4) {
                              if (obj[local].status == 200) {
                                      resposta = obj[local].responseText;
//						alert(resposta);
                                      return resposta;
                              }else{
                                      alert('Ocorreu um problema ao receber os dados:\n' + obj[local].statusText);
                              }
                      }
              }
              obj[local].send(null);
      }
}

/*-------
FUNÇÃO QUE MANDA OS DADOS PARA O SERVIDOR via POST
--------*/
function pegaConteudoPOST(url,par,local){

        obj = criaObjetoXMLHttp();
        strData = par;
        //alert("Essa é a url "+url);
        //alert("Esse são os dados "+strData);
        if (obj){
                obj.open("POST",url,true);
                obj.setRequestHeader('Content-Type','text/xml');
                obj.setRequestHeader('encoding','ISO-8859-1');
                obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                obj.setRequestHeader('Content-length', strData.length);
                obj.onreadystatechange = function processadorMudancaEstado(to) {
                        if (obj.readyState == 4) {
                                if (obj.status == 200) {
                                        document.getElementById(local).innerHTML = obj.responseText;
                                }else{
                                        alert('Ocorreu um problema ao recber os dados:\n' + obj.statusText);
                                }
                        }else{
                                document.getElementById(local).innerHTML = '<br><p align=\"center\">Carregando dados...<br><img src="/html/imagens/site/loading.gif" align="absmiddle">&nbsp;</p>';
                        }
                }
                obj.send(strData);
        }
}

/*-------
FUNÇÃO RESPONSÁVEL POR PERMITIR A EXECUÇÃO DE UM SCRIPT NUMA SOLICITAÇÃO VIA AJAX
--------*/
function extraiScript(texto){
   var ini = 0;
   while (ini!=-1){
       ini = texto.indexOf('<script', ini);
       if (ini >=0){
           ini = texto.indexOf('>', ini) + 1;
           var fim = (texto.indexOf('/script>', ini) - 1);
           codigo = texto.substring(ini,fim);
           novo = document.createElement("script")
           novo.text = codigo;
           document.body.appendChild(novo);
       }
   }
}

