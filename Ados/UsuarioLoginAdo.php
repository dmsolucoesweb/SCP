<?php

require_once 'ADO.php';
require_once '../Models/UsuarioLoginModel.php';

class UsuarioLoginAdo extends ADO {
    /* Função: consultaIdPeloEmail
     * Utilidade: Busca o Id do usuarios_login pela Email. É usado no RecuperaSenhaController.  
     */

    public function consultaIdPeloEmail($usuarioLoginEmail) {
        $query = "select usuarioLoginId from usuarios_login where usuarioLoginEmail = '{$usuarioLoginEmail}'";

        $resultado = parent::executaQuery($query);

        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaIdPeloEmail: " . parent::getBdError());
            return false;
        }

        $usuario = parent::leTabelaBD();

        return $usuario['usuarioLoginId'];
    }

    public function consultaObjetoPeloId($usuarioLoginId) {
        $query = "select * from usuarios_login where usuarioLoginId = '{$usuarioLoginId}' ";

        $resultado = parent::executaQuery($query);

        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaObjetoPeloId: " . parent::getBdError());
            return false;
        }
        $usuarioLogin = parent::leTabelaBD();
        return new UsuarioLoginModel($usuarioLogin['usuarioLoginId'], $usuarioLogin['usuarioLoginNome'], $usuarioLogin['usuarioLoginEmail'], $usuarioLogin['usuarioLoginTipo'], $usuarioLogin['usuarioLoginLogin'], $usuarioLogin['usuarioLoginSenha']);
    }

    public function consultaArrayDeObjeto() {
        $usuarioLoginModel = null;
        $query = "select * from usuarios_login order by usuarioLoginNome";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            //consulta Ok. Continua.
        } else {
            parent::setMensagem("Erro no select de consultaArrayDeObjeto: " . parent::getBdError());
            return false;
        }

        $usuariosLoginModel = null;

        while ($usuarioLogin = parent::leTabelaBD()) {
            $usuarioLoginModel = new UsuarioLoginModel($usuarioLogin['usuarioLoginId'], $usuarioLogin['usuarioLoginNome'], $usuarioLogin['usuarioLoginEmail'], $usuarioLogin['usuarioLoginTipo'], $usuarioLogin['usuarioLoginLogin'], $usuarioLogin['usuarioLoginSenha']);
            $usuariosLoginModel[] = $usuarioLoginModel;
        }

        return $usuariosLoginModel;
    }

    public function insereObjeto(\Model $UsuarioLoginModel) {
        $usuarioLoginNome = $UsuarioLoginModel->getUsuarioLoginNome();
        $usuarioLoginEmail = $UsuarioLoginModel->getUsuarioLoginEmail();
        $usuarioLoginTipo = $UsuarioLoginModel->getUsuarioLoginTipo();
        $usuarioLoginLogin = $UsuarioLoginModel->getUsuarioLoginLogin();
        $usuarioLoginSenha = $UsuarioLoginModel->getUsuarioLoginSenha();
        $usuarioLoginSenhaHash = sha1($usuarioLoginSenha);

        $query = "insert into usuarios_login (usuarioLoginId, usuarioLoginNome, usuarioLoginEmail, usuarioLoginTipo, usuarioLoginLogin, usuarioLoginSenha) values ('null', '$usuarioLoginNome', '$usuarioLoginEmail', '$usuarioLoginTipo', '$usuarioLoginLogin', '$usuarioLoginSenhaHash');";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            return true;
        } else {
            parent::setMensagem("Erro no insert de insereObjeto: " . parent::getBdError());
            return false;
        }
    }

    public function alteraObjeto(\Model $UsuarioLoginModel) {
        $usuarioLoginId = $UsuarioLoginModel->getUsuarioLoginId();
        $usuarioLoginNome = $UsuarioLoginModel->getUsuarioLoginNome();
        $usuarioLoginEmail = $UsuarioLoginModel->getUsuarioLoginEmail();
        $usuarioLoginTipo = $UsuarioLoginModel->getUsuarioLoginTipo();

        $query = "update usuarios_login set usuarioLoginNome = '{$usuarioLoginNome}',"
                . " usuarioLoginEmail = '{$usuarioLoginEmail}'"
                . " usuarioLoginTipo = '{$usuarioLoginTipo}'"
                . " where usuarioLoginId = '{$usuarioLoginId}'";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            return true;
        } else {
            parent::setMensagem("Erro no update de alteraObjeto: " . parent::getBdError());
            return false;
        }
    }

    public function excluiObjeto(\Model $UsuarioLoginModel) {
        $usuarioLoginId = $UsuarioLoginModel->getUsuarioLoginId();

        $query = "delete from usuarios_login "
                . "where usuarioLoginId = {$usuarioLoginId}";

        $resultado = parent::executaQuery($query);
        if ($resultado) {
            return true;
        } else {
            parent::setMensagem("Erro no delete de excluiObjeto: " . parent::getBdError());
            return false;
        }
    }

}
