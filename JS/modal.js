/**
 * Este é um Código da Fábrica de Software
 * 
 * Coordenador: Elymar Pereira Cabral
 * 
 * Data: 16/05/2014
 * @autor Giovane Citnra Alencar
 * 
 * O modo de usar esta documentado na wiki do redmine no FSW.
 */
$(document).ready(function() {

    $(".janelaModal").hide();//faz com que a div que temnha a class com este nome fique escondida  
    $(".fundoModal").hide(); //faz com que a div que temnha a class com este nome fique escondida 

    /*
     * Esde pedasso é utilisado quando se tem apenas uma janelaModal na tela. 
     */
    $("#botaoModal").click(function() {
        $(".janeModal, .fundoModal").show();
    });

    $(".btModalSair").click(function() {
        $(".janelaModal").hide( );//faz com que a div que temnha a class com este nome fique escondida 
        $(".fundoModal").hide(); //faz com que a div que temnha a class com este nome fique escondida 

    });

});
/*
 * deve ser usado quando for ter varias janelas modal em uma mesma tela 
 */
function variasJanelasModal(indici) {
    $(".fundoModal").show();
    $("#janelaModal" + indici).show( );


}
