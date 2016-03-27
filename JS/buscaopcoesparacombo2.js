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
function chamaBuscaCombo(arrayIdentificadoresDosCombos,
        comboDestino,
        objeto,
        metodo,
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
        chamaBuscaComboAJAX(resposta, arrayIdentificadoresDosCombos, comboDestino, objeto, metodo, arrayParametrosExtras);
    });
    ajax.fail(function(erro) {
        alert("Erro no AJAX (função buscaDiretorioDaFSW). Contate o analista! ");
    });
}

function chamaBuscaComboAJAX(resposta, arrayIdentificadoresDosCombos, comboDestino, objeto, metodo, arrayParametrosExtras) {
    var dirFSW = resposta;

    var parametros = "?";
    var tamanho = arrayIdentificadoresDosCombos.length;

    // Monta a I parte dos parâmetros: identificadores dos combos. Podem ser vários.
    for (var i = 0; i < tamanho; i++) {
        if (i > 0) {
            parametros += "&";
        }
        parametros += arrayIdentificadoresDosCombos[i] + "=" + $('#' + arrayIdentificadoresDosCombos[i]).val();
    }

    // Monta a II parte dos parâmetros: parâmetros a serem usados pelo método 
    // informado. Não é obrigatório existir parâmetros extras.
    if (arrayParametrosExtras !== null) {
        tamanho = arrayParametrosExtras.length;
        parametros += "&tamanho=" + tamanho;
        for (var i = 0; i < tamanho; i++) {
            parametros += "&par" + (i + 1) + "=" + arrayParametrosExtras[i];
        }
    }

    // Monta a III parte dos parâmetros: identificadores do objeto e do método.
    parametros += "&";
    parametros += "objeto=" + objeto;
    parametros += "&";
    parametros += "metodo=" + metodo;

    urlDoAjax = dirFSW + "/AJAX/buscaopcoesparacombo02.php" + parametros;

    var ajax = $.ajax({
        url: urlDoAjax,
        type: "GET"
    });

    ajax.done(function(resposta) {
        var linhas = resposta.split("|"); // Recupera as linhas de opções do objeto.
        var comboObjeto = document.getElementById(comboDestino);

        if (comboObjeto === null) {
            alert("Erro no AJAX: elemento não encontrado. Contate o analista responsável.");
            return;
        }

        // Reinicia o combo
        while (comboObjeto.options.length) {
            comboObjeto.remove(0);
        }

        // Caso o PHP/AJAX retorne vazio, então deve-se montar uma mensagem de
        // aviso para o usuário.
        if (linhas.length === 1 && linhas [0] === "") {
            var value = "-1";
            var text = "Não encontrou nenhuma opção.";
            var opcao = new Option(text, value);
            comboObjeto.options.add(opcao); //Adiciona mais uma option ao combo
            return;
        }

        // Monta a primeira opção padrão do combo
        var value = "-1";
        var text = "Escolha uma opção abaixo...";
        var opcao = new Option(text, value);
        comboObjeto.options.add(opcao); //Adiciona mais uma option ao combo
        // Varre o array para montar as opções do combo
        for (var i = 0; i < linhas.length; i++) {
            var linha = linhas[i].split(":"); // Recupera um objeto do cojunto de linhas do objeto.

            value = linha [0]; //Id do artesão;
            text = linha [1]; //Sigla e nome do linha;
            opcao = new Option(text, value);

            comboObjeto.options.add(opcao); //Adiciona mais uma option ao combo
        }
    });

    ajax.fail(function(erro) {
        alert("Erro no AJAX. Contate o analista! ");
    });
}

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
function montaOptionsParaCombo(identificadoresDosCombosDeOrigem, comboDestino, objeto, metodo, parametrosExtras) {
    var arrayIdentificadoresDosCombos = identificadoresDosCombosDeOrigem.split("|");

    var arrayParametrosExtras = null;
    if (parametrosExtras == '') {
        //não precisa fazer nada quando os parâmetros extras vierem vazios
    } else {
        if (parametrosExtras !== null && parametrosExtras !== undefined) {
            arrayParametrosExtras = parametrosExtras.split("|");
        }
    }

    // Executa a chamada do do método do AJAX para montar combo.
    chamaBuscaCombo(arrayIdentificadoresDosCombos, comboDestino, objeto, metodo, arrayParametrosExtras);
}