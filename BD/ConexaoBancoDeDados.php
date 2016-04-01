<?php

class ConexaoBancoDeDados extends PDO {

    private $usuario = "root";
    private $senha = "";
    private $bdNome = "scp";
    private $mensagem = NULL;
    private $confUTF8 = "charset=utf8";
    private $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
    private $statusDoConstrutor = TRUE;
    private $handle = NULL;
    private $pdoStatment = NULL;

    /**
     * Classe BancoDeDados, usada para fazer a conexÃ£o do sistema SCP no banco de dados Mysql.
     * Os dados: usuario, senha e bdNome sÃ£o os dados da conexÃ£o ao banco do computador local.
     */
    function __construct() {
        try {
            $this->usuario;
            $this->senha;
            $this->bdNome;
            if ($this->handle == null) {
                $this->handle = parent::__construct("mysql:host=localhost;dbname=" . $this->bdNome . ";" . $this->confUTF8, $this->usuario, $this->senha, $this->options);
                $this->configuraUTF8();
            }
        } catch (PDOException $e) {
            $this->setMensagem("Não foi possível conectar ao SGBD. Erro: " . $this->getBdError(1));
            //$this->setMensagem($e->getMessage());
            $this->setStatusDoConstrutor(FALSE);
            return;
        }
    }

    function connect_pdo() {
        try {
            $this->usuario;
            $this->senha;
            $this->bdNome;
            if ($this->handle == null) {
                $this->handle = parent::__construct("mysql:host=localhost;dbname=" . $this->bdNome . ";" . $this->confUTF8, $this->usuario, $this->senha, $this->options);
                $this->configuraUTF8();
            }
        } catch (PDOException $e) {
            $this->setMensagem("Não foi possível conectar ao SGBD. Erro: " . $this->getBdError(1));
            //$this->setMensagem($e->getMessage());
            $this->setStatusDoConstrutor(FALSE);
            return;
        }
    }

    /**
     * Este Ã© o mÃ©todo que vai destruir o construtor, vai encerrar a conexÃ£o.
     */
    function __destruct() {
        $this->handle = NULL;
    }

    function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }

    function getMensagem() {
        return $this->mensagem;
    }

    /**
     * Este mÃ©todo retornarÃ¡ erros do SGBD.
     * @return array
     */

    /**
     * 
     * @param inteiro $tipo Identifica se o erro foi de uma execuÃ§Ã£o num objeto 
     *                      do tipo statment (0) ou diretamente no BD (1).
     * @return String Mensagem do erro
     */
    function getBdError($tipo = 0) {
        $erro = null;
        if ($tipo === 0) {
            $erro = $this->pdoStatment->errorInfo();
        } else {
            $erro = parent::errorInfo();
        }

        return $erro[2];
    }

    /**
     * Este mÃ©todo mostrarÃ¡ os status do construtor.
     * @return String
     */
    public function getStatusDoConstrutor() {
        return $this->statusDoConstrutor;
    }

    /**
     * Este mÃ©todo serÃ¡ montado o status do construtor
     * @param type $statusDoConstrutor
     */
    public function setStatusDoConstrutor($statusDoConstrutor) {
        $this->statusDoConstrutor = $statusDoConstrutor;
    }

    /**
     * Este Ã© o mÃ©todo que vai encerrar a conexÃ£o com banco de dados.
     */
    function desconectaDoBD() {
        if ($this->handle) {
            $this->handle = NULL;
        }
    }

    function setConexao($handle) {
        $this->handle = $handle;
    }

    function getConexao() {
        return $this->handle;
    }

    /**
     * Este Ã© o mÃ©todo aonde serÃ¡ feito uma preparaÃ§Ã£o de uma query, 
     * e logo em seguida seÅ•a executado pela pdoStatment, 
     * e essa execuÃ§Ã£o ser retornado.
     * @param type $query
     * @return type
     */
    function executaQuery($query) {
        $this->pdoStatment = parent::prepare($query);
        return $this->pdoStatment->execute();
    }

    /**
     * Este mÃ©todo serÃ¡ retornado o nÃºmero de linhas afetadas em uma consulta sql.
     * OBS: Segundo o php.net o comportamento do rowCount de retornar o nÃºmero de
     *      linhas, nÃ£o serÃ¡ garantido para todos bancos de dados.
     * @param type $resultado
     * @return rowCount
     */
    function qtdeLinhas($resultado) {
        return $this->pdoStatment->rowCount();
    }

    /**
     * Este mÃ©todo irÃ¡ retorna a quantidade de linhas afetadas por Updates, Deletes...
     * @return rowCount
     */
    function linhasAfetadas() {
        return $this->pdoStatment->rowCount();
    }

    public function getAtributoArquivo($linha, $nomeDoAtributo) {
        return $linha[$nomeDoAtributo];
    }

    /**
     * Este mÃ©todo permite que se leia o resultado de um select sem se montar o objeto.
     * Retorna cada linha com uma matriz indexada pelo nome da coluna.
     * Se o conjunto de resultados contÃ©m vÃ¡rias colunas com o mesmo nome,
     * retorna apenas um Ãºnico valor por nome da coluna.
     * @return type
     */
    function leTabelaBD() {
        return $this->pdoStatment->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Este mÃ©todo configura o tipo dos caracteres para UTF-8
     */
    function configuraUTF8() {
        parent::exec("SET NAMES utf8");
        parent::exec("SET character_set='utf8'");
        parent::exec("SET collation_connection='utf8_general_ci'");
        parent::exec("SET character_set_connection=utf8");
        parent::exec("SET character_set_client=utf8");
        parent::exec("SET character_set_results=utf8");
    }

    /**
     * Recupera o Ãºltimo id inserido numa tabela.
     * @return boolean retorna o id da Ãºltima tupla inserida ou false se ocorrer erro
     */
    function recuperaId() {
        return parent::lastInsertId();
    }

    /**
     * Executa uma ou mais querys dentro de uma transaÃ§Ã£o finalizando com commit
     * se executou todas com sucesso ou rollback se houve algum problema.
     * 
     * @param type $arrayQuerys Matriz onde cada linha deve conter na primeira 
     *                          coluna (de nome query) uma query e na segunda 
     *                          coluna (de nome alteraTupla) deve conter True 
     *                          para querys do tipo Update, Delete e Insert, ou 
     *                          False para querys do tipo Select, Set, etc.
     * @return boolean True se executou todos as querys e False se ocorreu algum 
     *                 erro ou nÃ£o executou uma tupla.
     */
    function executaArrayDeQuerysComTransacao(Array $arrayQuerys) {
        $this->iniciaTransacao();

        foreach ($arrayQuerys as $query) {
            $executouQuery = $this->executaQuery($query["query"]);
            if ($executouQuery) {
                //continua
            } else {
                $this->setMensagem("Erro na query: " . $query["query"]);
                $this->descartaTransacaoViaRollback();
                return false;
            }
            if ($query["alteraTupla"]) {
                if ($this->linhasAfetadas() == 0) {
                    $this->descartaTransacaoViaRollback();
                    return false;
                }
            }
        }

        $this->validaTransacaoViaCommit();
        return true;
    }

    /**
     * EPC - 24/06/2015
     * ATENÃ‡ÃƒO!!!
     * 
     * EU TRANSFORMEI OS MÃ‰TODOS iniciaTransacao(), commit() e rollback() PARA 
     * PRIVATE PORQUE O ROLLBACK NÃƒO ESTÃ FUNCIONANDO QUANDO SE IMPLEMENTA A 
     * ROTINA DE DENTTRO DA CONTROLLER. ACREDITO QUE SEJA ALGUMA COISA 
     * RELACIONADA COM TODAS AS TRANSAÃ‡Ã•ES DEVEM USAR O MESMO HANDLE. PRECISO 
     * INVESTIGAR MELHOR. 
     * 
     * ATÃ‰ RESOLVER ESSE PROBLEMA O MAIS PRUDENTE Ã‰ USAR EXCLUSIVAMENTE O MÃ‰TODO
     * executaArrayDeQuerysComTransacao().
     */

    /**
     * Este mÃ©tedo Ã© para iniciar a transaÃ§Ã£o com o banco de dados.
     * Aviso: sÃ³ utilize-a com a certeza de encrerrar a transaÃ§Ã£o com commit ou 
     * rollback.
     */
    private function iniciaTransacao() {
        return parent::beginTransaction();
    }

    /**
     * Este mÃ©todo irÃ¡ executar uma aÃ§Ã£o, se estiver correta e nÃ£o sofre alguma alteraÃ§Ã£o.
     * @return boolean
     */
    private function validaTransacaoViaCommit() {
        return parent::commit();
    }

    /**
     * Este mÃ©todo irÃ¡ voltar ao estado que estava antes de executar uma aÃ§Ã£o, se ocorrer alguma falha.
     * @return boolean
     */
    private function descartaTransacaoViaRollback() {
        return parent::rollback();
    }

}
