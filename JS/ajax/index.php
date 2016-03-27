<?php
/**
 * Este é um Código da Fábrica de Software
 * 
 * Coordenador: Elymar Pereira Cabral
 * 
 * Data: 26/11/2012
 *
 * Descrição de Index:
 * 
 *
 * @autor Flayson Potenciano e Silva e Elymar Pereira Cabral
 */


require_once 'diretorios.class.php';
$diretorios =  new Diretorios();

$caminho = $diretorios->getCaminhoDoArtefatoFsw("ARTE");

header("Location:{$caminho}/Modulos/loginad.php");
?>
