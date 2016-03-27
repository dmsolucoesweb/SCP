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
function chamaBuscaCombo(arrayIdentificadoresDosCombos, comboDestino, objeto, metodo) {
    // I - busca o diretório da versão em uso da FSW;
    var ajax = $.ajax({
        url: "/FabricaDeSoftware/fsw/Default/buscadiretorio.php",
        type: "POST",
        data: {
            arteSigla: "FSW"
        }
    });

    ajax.done(function(resposta) {
        // II - executa o método que executará o programa para buscar os combos 
        //      e monta o combo desejado.
        chamaBuscaComboAJAX(resposta, arrayIdentificadoresDosCombos, comboDestino, objeto, metodo);
    });
    ajax.fail(function(erro) {
        alert("Erro no AJAX (função buscaDiretorioDaFSW). Contate o analista! ");
    });
}

function chamaBuscaComboAJAX(resposta, arrayIdentificadoresDosCombos, comboDestino, objeto, metodo) {
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

    // Monta a II parte dos parâmetros: identificadores do objeto e do método.
    parametros += "&";
    parametros += "objeto=" + objeto;
    parametros += "&";
    parametros += "metodo=" + metodo;

    urlDoAjax = dirFSW + "/AJAX/buscaopcoesparacombo.php" + parametros;

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

function montaOptionsParaCombo(identificadoresDosCombosDeOrigem, comboDestino, objeto, metodo) {
    var arrayIdentificadoresDosCombos = identificadoresDosCombosDeOrigem.split("|");

    // Executa a chamada do do método do AJAX para montar combo.
    chamaBuscaCombo(arrayIdentificadoresDosCombos, comboDestino, objeto, metodo);
}