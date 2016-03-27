/**
 * Este é um Código da Fábrica de Software
 * 
 * Coordenador: Elymar Pereira Cabral
 * 
 * Data: 29/05/2014
 * 
 * Este JS permite montar as opções de combo boxes.
 *
 * @autor Elymar Pereira Cabral
 */

/**
 * Busca as opções para um combo (combo destino) e as monta nele.
 * @param String identificadoresDosCombosDeOrigem Nomes do combos que serão usado para montar a chave de busca. 
 * Cada nome de cobo deve ser separado por "|".
 * @param String comboDestino Nome do combo que receberá as opções.
 * @param String objeto Nome do objeto que contém o método de busca.
 * @param String metodo Método que realiza a busca.
 * @param String parametrosExtras Parâmetros além daqueles obtido via combos e necessários para a consulta. Não é obrigatório.
 * Osparâmetros devem vir separados por "|".
 * @returns {undefined} Não tem retorno.
 */
function montaOptionsParaCombo(identificadoresDosCombosDeOrigem,
        comboDestino,
        objeto,
        metodo,
        parametrosExtras) {
    var arrayIdentificadoresDosCombosDeOrigem = identificadoresDosCombosDeOrigem.split("|");

    var arrayIdentificadoresDosCombosDeDestino = [];
    arrayIdentificadoresDosCombosDeDestino[0] = comboDestino;

    var arrayDeObjetos = [];
    arrayDeObjetos[0] = objeto;

    var arrayDeMetodos = [];
    arrayDeMetodos[0] = metodo;

    var arrayParametrosExtras = null;
    if (parametrosExtras == '') {
        //não precisa fazer nada quando os parâmetros extras vierem vazios
    } else {
        if (parametrosExtras !== null && parametrosExtras !== undefined) {
            arrayParametrosExtras = parametrosExtras.split("|");
        }
    }

    // Executa a chamada do do método do AJAX para montar combo.
    chamaBuscaCombo(arrayIdentificadoresDosCombosDeOrigem,
            arrayIdentificadoresDosCombosDeDestino,
            arrayDeObjetos,
            arrayDeMetodos,
            arrayParametrosExtras);
}

/**
 * Busca as opções para um ou mais combos de destino e as monta nele.
 * @param String identificadoresDosCombosDeOrigem Nomes do combos que serão usado para montar a chave de busca. 
 * Cada nome de cobo deve ser separado por "|".
 * @param String identificadoresDosCombosDeDestino Nomes dos combos que receberão as opções.
 * @param String objetos Nomes dos objetos que contêm os métodos de buscas das opções para cada combo de destino.
 * Têm que ser informados na mesma ordem dos identificadores dos combos.
 * @param String metodos Nomes dos Métodos que realizam as buscas. Um para cada objeto e na mesma ordem.
 * @param String parametrosExtras Parâmetros além daqueles obtido via combos e necessários para a consulta. 
 * Não é obrigatório. POR ENQUANTO SE REPETE PARA TODOS OS MÉTODOS DE BUSCA.
 * @returns {unresolved} Não tem retorno.
 */
function montaOptionsParaCombos(identificadoresDosCombosDeOrigem,
        identificadoresDosCombosDeDestino,
        objetos,
        metodos,
        parametrosExtras) {
    var arrayIdentificadoresDosCombosDeOrigem = identificadoresDosCombosDeOrigem.split("|");
    var arrayIdentificadoresDosCombosDeDestino = identificadoresDosCombosDeDestino.split("|");
    var arrayDeObjetos = objetos.split("|");
    var arrayDeMetodos = metodos.split("|");

    if (arrayIdentificadoresDosCombosDeDestino.length === arrayDeObjetos.length
    &&  arrayDeObjetos.length === arrayDeMetodos.length) {
        //se todos os arrays têm o mesmo tamanho OK.
    } else {
        alert("A quantidade de combos de destino tem que ser igual a de objetos e métodos. Contate o analista! ");
        return;
    }

    var arrayParametrosExtras = null;
    if (parametrosExtras === '') {
        //não precisa fazer nada quando os parâmetros extras vierem vazios
    } else {
        if (parametrosExtras !== null && parametrosExtras !== undefined) {
            arrayParametrosExtras = parametrosExtras.split("|");
        }
    }

    // Executa a chamada do do método do AJAX para montar combo.
    chamaBuscaCombo(arrayIdentificadoresDosCombosDeOrigem,
            arrayIdentificadoresDosCombosDeDestino,
            arrayDeObjetos,
            arrayDeMetodos,
            arrayParametrosExtras);
}

function chamaBuscaCombo(arrayIdentificadoresDosCombosDeOrigem,
        arrayIdentificadoresDosCombosDeDestino,
        arrayDeObjetos,
        arrayDeMetodos,
        arrayParametrosExtras) {
    // I - busca o diretório da versão em uso da FSW;
    var ajax = $.ajax({
        url: "/FabricaDeSoftware/fsw/Default/buscadiretorio.php",
        type: "POST",
        data: {
            arteSigla: "FSW"
        }
    });

    ajax.done(function(resposta) {
        // II - executa o método do JS que executará o programa para buscar os 
        //      combos e monta o combo desejado.
        chamaBuscaComboAJAX(resposta,
                arrayIdentificadoresDosCombosDeOrigem,
                arrayIdentificadoresDosCombosDeDestino,
                arrayDeObjetos,
                arrayDeMetodos,
                arrayParametrosExtras);
    });
    ajax.fail(function(erro) {
        alert("Erro no AJAX (função buscaDiretorioDaFSW). Contate o analista! ");
    });
}

function chamaBuscaComboAJAX(resposta,
        arrayIdentificadoresDosCombosDeOrigem,
        arrayIdentificadoresDosCombosDeDestino,
        arrayDeObjetos,
        arrayDeMetodos,
        arrayParametrosExtras) {
    var dirFSW = resposta;

    var parametros1 = "?";
    var parametros2;

    var tamanhoOrigem = arrayIdentificadoresDosCombosDeOrigem.length;
    var tamanhoDestino = arrayIdentificadoresDosCombosDeDestino.length;

    // Monta a I parte dos parâmetros: identificadores dos combos. Podem ser vários.
    for (var i = 0; i < tamanhoOrigem; i++) {
        if (i > 0) {
            parametros1 += "&";
        }
        parametros1 += arrayIdentificadoresDosCombosDeOrigem[i]
                + "=" + $('#' + arrayIdentificadoresDosCombosDeOrigem[i]).val();
    }

    // Monta a II parte dos parâmetros: parâmetros a serem usados pelo método 
    // informado. Não é obrigatório existir parâmetros extras.
    // @todo Ainda é preciso rever o lance dos parâmetros extras com a nova 
    //       versão desta rotina. Com a possibilidade da montagem de múltiplos 
    //       combos de destino como ficam os parâmetros extras? Seriam apra a 
    //       montagem de todos os comobos de destino? Se não, para qual ou 
    //       quais? Ou seria melhor não tê-los? 
    //       Do jeito que está eles serão enviados a todos.
    if (arrayParametrosExtras !== null) {
        tamanhoOrigem = arrayParametrosExtras.length;
        parametros1 += "&tamanho=" + tamanhoOrigem;
        for (var i = 0; i < tamanhoOrigem; i++) {
            parametros1 += "&par" + (i + 1) + "=" + arrayParametrosExtras[i];
        }
    }

    // Monta a III parte dos parâmetros: identificadores do objeto e do método.
    // Para atender a montagem de múltiplos combos de destinos um array de objetos
    // e um array de métodos devem ser tratado montando um array de urls a serem
    // executadas.
    for (var ident1 = 0; ident1 < tamanhoDestino; ident1++) {
        parametros2 = "&";
        parametros2 += "objeto=" + arrayDeObjetos[ident1];
        
        parametros2 += "&";
        parametros2 += "metodo=" + arrayDeMetodos[ident1];

        urlDoAjax = dirFSW + "/AJAX/buscaopcoesparacombo02.php" + parametros1 + parametros2;
        
        // retirar o comentário abaixo para debugar.
        //alert ("url: " + urlDoAjax);

        var ajax = $.ajax({
            url: urlDoAjax,
            type: "GET"
        });

        //nomeDoComboDeDestino deve ser global para ser acessível dentro do 
        //método done.
        nomeDoComboDeDestino = arrayIdentificadoresDosCombosDeDestino[ident1];

        ajax.done(function(resposta) {
            var linhas = resposta.split("|"); // Recupera as linhas de opções do objeto.

            var comboDestino = document.getElementById(nomeDoComboDeDestino);           

            if (comboDestino === null) {
                alert("Erro no AJAX: elemento não encontrado: " + comboDestino + ". Contate o analista responsável.");
                return;
            }

            // Reinicia o combo
            while (comboDestino.options.length) {
                comboDestino.remove(0);
            }

            // Caso o PHP/AJAX retorne vazio, então deve-se montar uma mensagem de
            // aviso para o usuário.
            if (linhas.length === 1 && linhas [0] === "") {
                var value = "-1";
                var text = "Não encontrou nenhuma opção.";
                var opcao = new Option(text, value);
                comboDestino.options.add(opcao); //Adiciona mais uma option ao combo
                return;
            }

            // Monta a primeira opção padrão do combo
            var value = "-1";
            var text = "Escolha uma opção abaixo...";
            var opcao = new Option(text, value);
            comboDestino.options.add(opcao); //Adiciona mais uma option ao combo
            // Varre o array para montar as opções do combo
            for (var ident2 = 0; ident2 < linhas.length; ident2++) {
                var linha = linhas[ident2].split(":"); // Recupera um objeto do cojunto de linhas do objeto.

                value = linha [0]; //Id do artesão;
                text = linha [1]; //Sigla e nome do linha;
                opcao = new Option(text, value);

                comboDestino.options.add(opcao); //Adiciona mais uma option ao combo
            }
        });

        ajax.fail(function(erro) {
            alert("Erro no AJAX. Contate o analista! ");
        });
    }
}
