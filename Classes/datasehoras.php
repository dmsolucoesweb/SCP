<?php

Class DatasEHoras {

    private static $data = NULL;
    private static $horas = NULL;

    /*
     * Método __construct()
     * O construtor inicia o atributo $data e $horas.
     */

    function __construct($data = NULL, $horas = NULL) {
        $this->setData($data);
        $this->setHoras($horas);
    }

    /**
     * Método setData
     * Atribui um valor (via parâmetro) ao atribuo $data
     * @param $data = a data a ser guardada. A data deve estar no formato aaaammdd.
     */
    function setData($data) {
        self::$data = $data;
    }

    /*
     * Método getData()
     * Retorna o valor da data.
     */

    public function getData() {
        return self::$data;
    }

    /**
     * Método setHoras
     * Atribui um valor (via parâmetro) ao atribuo $horas
     * @param $horas = a hora a ser guardada. A hora deve estar no formato hh:mm:ss.
     */
    function setHoras($horas) {
        self::$horas = $horas;
    }

    /*
     * Método getHoras()
     * Retorna o valor da hora.
     */

    public function getHoras() {
        return self::$horas;
    }

    /**
     * Método limpaSeparadores()
     * Retira espaços em branco, barras ('/') e traços ('-').
     * @param $data = data que deseja-se limpar.
     */
    public function limpaSeparadores($data) {
        /*
         * EPC - 17/06/2013
         * Comentei a linha abaixo pq ela não estava retirando o '-';
          return trim($data, "/- ");
         */
        return $data = trim(str_replace('/', '', trim(str_replace('-', '', $data))));
    }

    /**
     * Método checaData()
     * Verifica se o valor da data é válido.
     * Retorna FALSO para datas inválidas, nulas ou com tamanho menor do que 8
     * caracteres.
     * 
     * @param $data = valor de data a ser checado no formato "aaaammdd" ou "aaaa-mm-dd". 
     *                Pode ser informado ou não. Caso não seja informado usa-se 
     *                o valor do atributo $data da classe.
     * @return boolean True se data Ok ou false se data com erro.
     */
    public function checaData($data = NULL) {
        if (is_null($data)) {
            $data = self::$data;
        }
        if (is_null($data)) {
            return FALSE;
        } else {
            if (strlen($data) < 8) {
                return FALSE;
            }
        }
        $data = self::limpaSeparadores($data);

        $dia = substr($data, 6, 2);
        $mes = substr($data, 4, 2);
        $ano = substr($data, 0, 4);
        return checkdate($mes, $dia, $ano);
    }

    public function checaHora($horas = NULL) {
        if (is_null($horas)) {
            $horas = self::$horas;
        }
        if (is_null($horas)) {
            return FALSE;
        }
        if (strlen($horas) < 8) {
            return FALSE;
        }

        $segundos = substr($horas, 4, 2);
        $minutos = substr($horas, 2, 2);
        $horas = substr($horas, 0, 2);

        if (segundos > 59) {
            return FALSE;
        }

        if (minutos > 59) {
            return FALSE;
        }

        if (horas > 23) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Método getDataInvertida()
     * Retorna uma data invertida (aaaammdd) com ano, mês e dia sem separadores.
     * 
     * A data a ser invertida pode estar com o separador '/' entre dia, mês e ano.
     *
     * Retorna FALSO se não receber a data e nem o atributo da classe estiver iniciado.
     * 
     * Retorna FALSO se data estiver com menos do que 8 caracteres.
     * 
     * @param $data = valor de data a ser invertido. Pode vir no formato "ddmmaaaa"
     *                ou "dd/mm/aaa". Pode ser informado ou não. Caso não seja informado 
     *                usa-se o valor do atributo $data da classe.
     */
    public function getDataInvertida($data = NULL) {
        if (is_null($data)) {
            $data = self::$data;
        }
        if (is_null($data)) {
            return FALSE;
        } else {
            if (strlen($data) < 8) {
                return FALSE;
            }
        }
        $data = trim(str_replace('/', '', $data));

        return substr($data, 4, 4) . substr($data, 2, 2) . substr($data, 0, 2);
    }

    public function getDataEHorasInvertida($data = NULL) {
        if (is_null($data)) {
            $data = self::$data;
        }
        if (is_null($data)) {
            return FALSE;
        } else {
            if (strlen($data) < 8) {
                return FALSE;
            }
        }
        $data = trim(str_replace('/', '', $data));

        return substr($data, 4, 4) . substr($data, 2, 2) . substr($data, 0, 2) . substr($data, 8, 9);
    }

    /**
     * Método getDataInvertidaComTracos()
     * Retorna uma data invertida (aaaammdd) com ano, mês e dia separados com traço
     * pronto para gravar no BD.
     *
     * Retorna FALSO se não receber a data e nem o atributo da classe estiver iniciado.
     * 
     * Retorna FALSO se data estiver com menos do que 8 caracteres.
     * 
     * @param $data = valor de data a ser invertido. Pode vir ou no formato "ddmmaaaa"
     *                ou "dd/mm/aaaa". Pode ser informado ou não. Caso não seja informado 
     *                usa-se o valor do atributo $data da classe.
     */
    public function getDataInvertidaComTracos($data = NULL) {
        $data = self::getDataInvertida($data);

        return substr($data, 0, 4) . '-' . substr($data, 4, 2) . '-' . substr($data, 6, 2);
    }

    public function getDataEHorasInvertidaComTracos($data = NULL) {
        $data = self::getDataEHorasInvertida($data);
        return substr($data, 0, 4) . '-' . substr($data, 4, 2) . '-' . substr($data, 6, 2) . substr($data, 8, 9);
    }

    /**
     * Método getDataComBarras()
     * Retorna uma data com as barras ("dd/mm/aaaa") .
     *
     * Retorna FALSO se não receber a data e nem o atributo da classe estiver iniciado.
     * 
     * Retorna FALSO se data estiver com menos do que 8 caracteres.
     * 
     * @param $data = valor de data a ser invertido. Deve vir no formato "ddmmaaaa"
     *                ou "dd-mm-aaaa". Pode ser informado ou não. Caso não seja informado 
     *                usa-se o valor do atributo $data da classe.
     */
    public function getDataComBarras($data = NULL) {
        if (is_null($data)) {
            $data = self::$data;
        }
        if (is_null($data)) {
            return FALSE;
        } else {
            if (strlen($data) < 8) {
                return FALSE;
            }
        }
        $data = trim(str_replace('-', '', $data));

        return substr($data, 0, 2) . '/' . substr($data, 2, 2) . '/' . substr($data, 4, 4);
    }

    public function getDataEHorasComBarras($data = NULL) {
        if (is_null($data)) {
            $data = self::$data;
        }
        if (is_null($data)) {
            return FALSE;
        } else {
            if (strlen($data) < 8) {
                return FALSE;
            }
        }
        $data = trim(str_replace('-', '', $data));

        return substr($data, 0, 2) . '/' . substr($data, 2, 2) . '/' . substr($data, 4, 4) . substr($data, 8, 9);
    }

    /**
     * Método getDataDesinvertida()
     * Retorna uma data não invertida (ddmmaaaa) com dia, mês e ano sem separadores.
     * 
     * A data a ser desinvertida pode estar com o separador '-' entre dia, mês e ano.
     *
     * Retorna FALSO se não receber a data e nem o atributo da classe estiver iniciado.
     * 
     * Retorna FALSO se data estiver com menos do que 8 caracteres.
     * 
     * @param $data = data a ser desinvertida. Pode vir no formato "aaaammdd" ou 
     *                "aaaa-mm-dd". Pode ser informado ou não. Caso não seja informado 
     *                usa-se o valor do atributo $data da classe.
     */
    public function getDataDesinvertida($data = NULL) {
        if (is_null($data)) {
            $data = self::$data;
        }
        if (is_null($data)) {
            return FALSE;
        } else {
            if (strlen($data) < 8) {
                return FALSE;
            }
        }
        $data = trim(str_replace('-', '', $data));

        return substr($data, 6, 2) . substr($data, 4, 2) . substr($data, 0, 4);
    }

    public function getDataEHorasDesinvertida($data = NULL) {
        if (is_null($data)) {
            $data = self::$data;
        }
        if (is_null($data)) {
            return FALSE;
        } else {
            if (strlen($data) < 8) {
                return FALSE;
            }
        }
        $data = trim(str_replace('-', '', $data));

        return substr($data, 6, 2) . substr($data, 4, 2) . substr($data, 0, 4) . substr($data, 8, 9);
    }

    /**
     * Método getDataDesinvertidaComBarras()
     * Retorna uma data não invertida (ddmmaaaa) com dia, mês e ano sem separadores.
     * 
     * A data a ser desinvertida pode estar com o separador '/' entre dia, mês e ano.
     *
     * Retorna FALSO se não receber a data e nem o atributo da classe estiver iniciado.
     * 
     * Retorna FALSO se data estiver com menos do que 8 caracteres.
     * 
     * @param $data = data a ser desinvertida. Pode vir no formato "aaaammdd" ou 
     *                "aaaa-mm-dd". Pode ser informado ou não. Caso não seja informado 
     *                usa-se o valor do atributo $data da classe.
     */
    public function getDataDesinvertidaComBarras($data = NULL) {
        if (is_null($data)) {
            $data = self::$data;
        }
        if (is_null($data)) {
            return FALSE;
        } else {
            if (strlen($data) < 8) {
                return FALSE;
            }
        }

        return self::getDataComBarras(self::getDataDesinvertida($data));
    }

    public function getDataEHorasDesinvertidaComBarras($data = NULL) {
        if (is_null($data)) {
            $data = self::$data;
        }
        if (is_null($data)) {
            return FALSE;
        } else {
            if (strlen($data) < 8) {
                return FALSE;
            }
        }

        return self::getDataEHorasComBarras(self::getDataEHorasDesinvertida($data));
    }

    /**
     * Retorna a data do sistema no formato aaaammdd.
     * 
     * @return data data do sistema no formato aaammdd
     */
    public function getDataDoSistemaInvertida() {
        return date('Ymd');
    }

    public function getDataEHorasDoSistemaInvertida() {
        return date('Ymd - H:i:s');
    }

    /**
     * Retorna a data do sistema no formato ddmmaaa.
     * 
     * @return data data do sistema no formato ddmmaaaa
     */
    public function getDataDoSistemaDesinvertida() {
        return date('dmY');
    }

    public function getDataEHorasDoSistemaDesinvertida() {
        return date('dmY - H:i:s');
    }

    /**
     * Retorna a data do sistema no formato aaaa-mm-dd.
     * 
     * @return data data do sistema no formato aaaa-mm-dd
     */
    public function getDataDoSistemaInvertidaComTraco() {
        return self::getDataInvertidaComTracos(self::getDataDoSistemaDesinvertida());
    }

    public function getDataEHorasDoSistemaInvertidaComTraco() {
        return self::getDataEHorasInvertidaComTracos(self::getDataEHorasDoSistemaDesinvertida());
    }

    /**
     * Retorna a data do sistema no formato dd/mm/aaaa.
     * 
     * @return data data do sistema no formato dd/mm/aaaa
     */
    public function getDataDoSistemaDesinvertidaComBarras() {
        return self::getDataDesinvertidaComBarras(date('Ymd'));
    }

    public function getDataEHorasDoSistemaDesinvertidaComBarras() {
        return self::getDataEHorasDesinvertidaComBarras(date('Ymd H:i:s'));
    }

    /**
     * Retorna o ano do sistema no formato aaaa.
     * 
     * @return data ano do sistema no formato aaaa
     */
    public function getAnoDoSistema() {
        return date('Y');
    }

    public function getAnoEHorasDoSistema() {
        return date('Y - H:i:s');
    }

}

?>