<?php

require_once '../BD/ConexaoBancoDeDados.php';

/* Classe ADO abstract, usada para facilitar e padronizar a criação de classes Ados 
 */

abstract class ADO extends ConexaoBancoDeDados {

    abstract public function consultaObjetoPeloId($id);

    abstract public function consultaArrayDeObjeto();

    abstract public function insereObjeto(Model $objetoModelo);

    abstract public function alteraObjeto(Model $objetoModelo);

    abstract public function excluiObjeto(Model $objetoModelo);
}
