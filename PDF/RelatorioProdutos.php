<?php

ini_set("memory_limit", "-1");
define('MPDF_PATH', 'class/mpdf/');
require_once 'mpdf/mpdf.php';
require_once '../Ados/ClienteAdo.php';
require_once '../Ados/ProdutoAdo.php';
include('../Config/config.php');
include('../Classes/functions.php');

class RelatorioProdutos {

    function EmitirRelatorioDeProdutos() {
        $mpdf = new mPDF('pt', 'A4', 0, 'arial', 15, 15, 35, 20, 9, 9, 'P');
        $stylesheet = file_get_contents('../PDF/pdf_sistema.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->SetHTMLHeader('<table class="header"><tbody><tr><td rowspan="3" class="logo"><img src="../IMG/logo89x50.png" /></td><td class="nopad_top">PARK VILLE INCORPORAÇÃO SPE LTDA - 23.501.469/0001-00</td></tr><tr><td class="nopad_top">Rua Francisco Soyer, nº 714, Centro, Inhumas/GO</td></tr><tr><td class="nopad_top"></td></tr><tr><td class="titulo_relatorio center" colspan="2">Apartamentos vendidos</td></tr></tbody></table>');
        $produtoAdo = new ProdutoAdo();
        $arrayDeProdutos = $produtoAdo->consultaArrayDeObjeto();
        $Html1 = "<table class='proposta center'><thead><tr><td class='secao'>Apto</td><td class='secao'>Box</td><td class='secao'>Proprietário(s)</td><td class='secao'>Venda</td><td class='secao'>Valor</td><td class='secao'>Telefone</td><td class='secao'>Vendedor</td><td class='secao'>Status</td></tr></thead><tbody>";
        $mpdf->WriteHTML($Html1);
        if (is_array($arrayDeProdutos)) {
            foreach ($arrayDeProdutos as $produtoModel) {
                $Html = null;

                $produtoId = $produtoModel->getProdutoId();
                $produtoApartamento = $produtoModel->getProdutoApartamento();
                $produtoBox = $produtoModel->getProdutoBox();
                $produtoValor = $produtoModel->getProdutoValor();
                $produtoParcelas = null;
                $produtoDataVenda = $produtoModel->getProdutoDataVenda();
                $produtoStatus = $produtoModel->getProdutoStatus();
                switch ($produtoStatus) {
                    case 1:
                        $status = "Aguardando";
                        break;
                    case 2:
                        $status = "Entregue";
                        break;
                }
                $clienteId = $produtoModel->getClienteId();
                $cliente = new ClienteAdo();
                $idCliente = $cliente->consultaObjetoPeloId($clienteId);
                $clienteNome = $idCliente->getClienteNome();
                $clienteCPF = $idCliente->getClienteCPF();
                $clienteTelefone = $idCliente->getClienteTelefone();
                $clienteCppStatus = $idCliente->getClienteCppStatus();
                $clienteCppNome = $idCliente->getClienteCppNome();
                $clienteCppCPF = $idCliente->getClienteCppCPF();
                $clienteCppTelefone = $idCliente->getClienteCppTelefone();
                $vendedorId = $produtoModel->getVendedorId();
                $vendedor = new VendedorAdo();
                $idVendedor = $vendedor->consultaObjetoPeloId($vendedorId);
                if ($vendedorId == 1) {
                    $vendedorNome = "DIRETO";
                } else {
                    $vendedorNome = $idVendedor->getVendedorNome();
                }
                if ($clienteCppStatus == "N") {
                    $Html .= "<tr><td>$produtoApartamento</td><td>$produtoBox</td><td class='esquerda'>$clienteNome - <i>" . mascara($clienteCPF, '###.###.###-##') . "</i></td><td>$produtoDataVenda</td><td>R$ " . number_format($produtoValor, 2, ',', '.') . "</td><td>$clienteTelefone</td><td>$vendedorNome</td><td>$status</td></tr>";
                } else {
                    $Html .= "<tr><td rowspan='2'>$produtoApartamento</td><td rowspan='2'>$produtoBox</td><td class='esquerda'>$clienteNome - <i>" . mascara($clienteCPF, '###.###.###-##') . "</i></td><td rowspan='2'>$produtoDataVenda</td><td rowspan='2'>R$ " . number_format($produtoValor, 2, ',', '.') . "</td><td>$clienteTelefone</td><td rowspan='2'>$vendedorNome</td><td rowspan='2'>$status</td></tr>"
                            . "<tr><td class='esquerda'>$clienteCppNome - <i>" . mascara($clienteCppCPF, '###.###.###-##') . "</i></td><td>$clienteCppTelefone</td></tr>";
                }
                $mpdf->WriteHTML($Html);
            }
        }
        $Html2 = "</tbody></table>";
        $mpdf->WriteHTML($Html2);
        $arquivo = date("d-m-Y") . "-aptos_vendidos.pdf";
        $mpdf->Output($arquivo, "I");
        exit();
    }

    function EmitirRelatorioDeProduto($produtoModel) {
        $mpdf = new mPDF('pt', 'A4', 0, 'arial', 10, 10, 30, 10, 8, 8, 'P');
        $stylesheet = file_get_contents('../PDF/pdf_sistema.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->SetHTMLHeader('<table class="header"><tbody><tr><td rowspan="3" class="logo"><img src="../IMG/logo89x50.png" /></td><td class="nopad_top">PARK VILLE INCORPORAÇÃO SPE LTDA - 23.501.469/0001-00</td></tr><tr><td class="nopad_top">Rua Francisco Soyer, nº 714, Centro, Inhumas/GO</td></tr><tr><td class="nopad_top"></td></tr><tr><td class="titulo_relatorio center" colspan="2">Carta Proposta</td></tr></tbody></table>');

        $Html = null;
        $produtoApartamento = $produtoModel->getProdutoApartamento();
        $produtoBox = $produtoModel->getProdutoBox();
        $produtoValor = $produtoModel->getProdutoValor();
        $produtoValorEntrada = null;
        $produtoParcelas = null;
        $produtoDataVenda = $produtoModel->getProdutoDataVenda();

        $vendedorId = $produtoModel->getVendedorId();
        $vendedor = new VendedorAdo();
        $idVendedor = $vendedor->consultaObjetoPeloId($vendedorId);
        $VendedorNome = $idVendedor->getVendedorNome();

        $clienteId = $produtoModel->getClienteId();
        $cliente = new ClienteAdo();
        $idCliente = $cliente->consultaObjetoPeloId($clienteId);
        $clienteNome = $idCliente->getClienteNome();

        $clienteNacionalidade = $idCliente->getClienteNacionalidade();
        $clienteDataNascimento = $idCliente->getClienteDataNascimento();
        $clienteCPF = $idCliente->getClienteCPF();
        $clienteRG = $idCliente->getClienteRG();
        $clienteOrgaoEmissor = $idCliente->getClienteOrgaoEmissor();
        $clienteEstadoOrgaoEmissor = $idCliente->getClienteEstadoOrgaoEmissor();
        $clienteSexo = $idCliente->getClienteSexo();
        $clienteEstadoCivil = $idCliente->getClienteEstadoCivil();
        $clienteRegimeComunhao = $idCliente->getClienteRegimeComunhao();
        $clienteFiliacao = $idCliente->getClienteFiliacao();
        $clienteFiliacao2 = $idCliente->getClienteFiliacao2();
        $clienteTelefone = $idCliente->getClienteTelefone();
        $clienteTelefone2 = $idCliente->getClienteTelefone2();
        $clienteEndereco = $idCliente->getClienteEndereco();
        $clienteCidade = $idCliente->getClienteCidade();
        $clienteEstado = $idCliente->getClienteEstado();
        $clienteCEP = $idCliente->getClienteCEP();
        $clienteEmail = $idCliente->getClienteEmail();
        $clienteProfissao = $idCliente->getClienteProfissao();
        $clienteRenda = $idCliente->getClienteRenda();
        $clienteEmpresa = $idCliente->getClienteEmpresa();

        if ($clienteNacionalidade == 1) {
            $clienteNacionalidade = 'Brasileiro(a)';
        } elseif ($clienteNacionalidade == 2) {
            $clienteNacionalidade = 'Internacional';
        }

        if ($clienteEstadoCivil == 1) {
            $clienteEstadoCivil = 'Solteiro(a)';
        } elseif ($clienteEstadoCivil == 2) {
            $clienteEstadoCivil = 'Casado(a)';
        } elseif ($clienteEstadoCivil == 3) {
            $clienteEstadoCivil = 'Divorciado(a)';
        } elseif ($clienteEstadoCivil == 4) {
            $clienteEstadoCivil = 'Viuvo(a)';
        } elseif ($clienteEstadoCivil == 5) {
            $clienteEstadoCivil = 'União Estável';
        }

        if ($clienteRegimeComunhao == 1) {
            $clienteRegimeComunhao = 'Comunhão Parcial de Bens';
        } elseif ($clienteRegimeComunhao == 2) {
            $clienteRegimeComunhao = 'Comunhão Universal de Bens';
        } elseif ($clienteRegimeComunhao == 3) {
            $clienteRegimeComunhao = 'Separação Total de Bens';
        } elseif ($clienteRegimeComunhao == 4) {
            $clienteRegimeComunhao = 'Participação Final de Aquestos';
        } else {
            $clienteRegimeComunhao = 'Prejudicado';
        }

        if ($clienteSexo == 'M') {
            $clienteSexo = 'Masculino';
        } else {
            $clienteSexo = 'Feminino';
        }

        $Html .= "
            <table class='proposta'>
                <tbody>
                <tr><td colspan='8' class='intro'>À <span clss='negrito'>PARK VILLE INCORPORAÇÃO SPE LTDA</span>. Através desta o(s) proponentes(s) abaixo qualificado(s), formaliza(m) uma proposta para aquisição do objeto descrito cujos termos e condições seguem para avaliação do vendedor.</td></tr>
                <tr><td colspan='8' class='secao'>DADOS DO PROPONENTE</td></tr>
                <tr><td class='titulo'>NOME</td><td colspan='7'>$clienteNome</td></tr>
                <tr><td class='titulo'>NACIONALIDADE</td><td colspan='5'>$clienteNacionalidade</td><td class='titulo'>NASCIMENTO</td><td>$clienteDataNascimento</td></tr>
                <tr><td class='titulo'>RG</td><td colspan='2'>$clienteRG</td><td class='titulo'>ÓRGÃO EMISSOR</td><td colspan='2'>$clienteOrgaoEmissor - $clienteEstadoOrgaoEmissor</td><td class='titulo'>CPF</td><td>" . mascara($clienteCPF, '###.###.###-##') . "</td></tr>
                <tr><td class='titulo'>ESTADO CIVIL</td><td colspan='2'>$clienteEstadoCivil</td><td class='titulo'>REGIME DE COMUNHÃO</td><td colspan='4'>$clienteRegimeComunhao</td></tr>
                <tr><td class='titulo'>ENDEREÇO</td><td colspan='7'>$clienteEndereco - $clienteCidade/$clienteEstado</td></tr>
                <tr><td class='titulo'>TELEFONE RESIDENCIAL</td><td colspan='3'>$clienteTelefone2</td><td class='titulo'>CELULAR</td><td colspan='3'>$clienteTelefone</td></tr>
                <tr><td class='titulo'>PROFISSÃO</td><td colspan='2'>$clienteProfissao</td><td class='titulo'>CARGO</td><td colspan='2'>CARGO</td><td class='titulo'>RENDA</td><td>R$ " . number_format($clienteRenda, 2, ',', '.') . "</td></tr>
                <tr><td class='titulo'>EMPRESA</td><td colspan='7'>$clienteEmpresa</td></tr>";

        $clienteCppStatus = $idCliente->getClienteCppStatus();

        $clienteCppNome = $idCliente->getClienteCppNome();
        $clienteCppNacionalidade = $idCliente->getClienteCppNacionalidade();
        $clienteCppDataNascimento = $idCliente->getClienteCppDataNascimento();
        $clienteCppCPF = $idCliente->getClienteCppCPF();
        $clienteCppRG = $idCliente->getClienteCppRG();
        $clienteCppOrgaoEmissor = $idCliente->getClienteCppOrgaoEmissor();
        $clienteCppEstadoOrgaoEmissor = $idCliente->getClienteCppEstadoOrgaoEmissor();
        $clienteCppSexo = $idCliente->getClienteCppSexo();
        $clienteCppEstadoCivil = $idCliente->getClienteCppEstadoCivil();
        $clienteCppRegimeComunhao = $idCliente->getClienteCppRegimeComunhao();
        $clienteCppFiliacao = $idCliente->getClienteCppFiliacao();
        $clienteCppFiliacao2 = $idCliente->getClienteCppFiliacao2();
        $clienteCppTelefone = $idCliente->getClienteCppTelefone();
        $clienteCppTelefone2 = $idCliente->getClienteCppTelefone2();
        $clienteCppEndereco = $idCliente->getClienteCppEndereco();
        $clienteCppCidade = $idCliente->getClienteCppCidade();
        $clienteCppEstado = $idCliente->getClienteCppEstado();
        $clienteCppCEP = $idCliente->getClienteCppCEP();
        $clienteCppEmail = $idCliente->getClienteCppEmail();
        $clienteCppProfissao = $idCliente->getClienteCppProfissao();
        $clienteCppRenda = $idCliente->getClienteCppRenda();
        $clienteCppEmpresa = $idCliente->getClienteCppEmpresa();
        $produtoParcelas = $produtoModel->getProdutoParcelas();
        $produtoParcelasPeriodicidade = $produtoModel->getProdutoParcelasPeriodicidade();
        $produtoParcelasDataVencimento = $produtoModel->getProdutoParcelasDataVencimento();
        $produtoParcelasValorUnitario = $produtoModel->getProdutoParcelasValorUnitario();
        $produtoParcelasValorTotal = $produtoModel->getProdutoParcelasValorTotal();
        $produtoParcelasAtualizacaoMonetaria = $produtoModel->getProdutoParcelasAtualizacaoMonetaria();
        $produtoParcelasFormaPagamento = $produtoModel->getProdutoParcelasFormaPagamento();
        $produtoParcelasObservacoes = $produtoModel->getProdutoParcelasObservacoes();
        $produtoVendedorData = $produtoModel->getVendedorDataVencimento();
        $produtoVendedorComissao = $produtoModel->getVendedorComissao();
        $produtoVendedorForma = $produtoModel->getVendedorFormaPagamento();
        $produtoVendedorObservacao = $produtoModel->getVendedorObservacao();

        if ($clienteCppNacionalidade == 1) {
            $clienteCppNacionalidade = 'Brasileiro(a)';
        } elseif ($clienteCppNacionalidade == 2) {
            $clienteCppNacionalidade = 'Internacional';
        }

        if ($clienteCppEstadoCivil == 1) {
            $clienteCppEstadoCivil = 'Solteiro(a)';
        } elseif ($clienteCppEstadoCivil == 2) {
            $clienteCppEstadoCivil = 'Casado(a)';
        } elseif ($clienteCppEstadoCivil == 3) {
            $clienteCppEstadoCivil = 'Divorciado(a)';
        } elseif ($clienteCppEstadoCivil == 4) {
            $clienteCppEstadoCivil = 'Viuvo(a)';
        } elseif ($clienteCppEstadoCivil == 5) {
            $clienteCppEstadoCivil = 'União Estável';
        }

        if ($clienteCppRegimeComunhao == 1) {
            $clienteCppRegimeComunhao = 'Comunhão Parcial de Bens';
        } elseif ($clienteCppRegimeComunhao == 2) {
            $clienteCppRegimeComunhao = 'Comunhão Universal de Bens';
        } elseif ($clienteCppRegimeComunhao == 3) {
            $clienteCppRegimeComunhao = 'Separação Total de Bens';
        } elseif ($clienteCppRegimeComunhao == 4) {
            $clienteCppRegimeComunhao = 'Participação Final de Aquestos';
        }

        if ($clienteCppSexo == 'M') {
            $clienteCppSexo = 'Masculino';
        } else {
            $clienteCppSexo = 'Feminino';
        }

        $cpp1 = $cpp2 = $cpp3 = $cpp4 = null;
        switch ($clienteCppStatus) {
            case 'C':
                $cpp1 = " checked='checked'";
                $tipocpp = "Cônjuge";
                break;
            case 'SP':
                $cpp2 = " checked='checked'";
                $tipocpp = "Segundo Proponente";
                break;
            case 'P':
                $cpp3 = " checked='checked'";
                $tipocpp = "Procurador";
                break;
            case 'N':
                $cpp4 = " checked='checked'";
                break;
        }

        $Html .= "<tr><td colspan='8' class='secao'>DADOS DO SEGUNDO PROPONENTE OU PROCURADOR</td></tr>
                    <tr><td class='noborder cpp' colspan='2'><input type='checkbox' name='clienteCppStatus' value='C' $cpp1> CONJUGE</td><td class='noborder cpp' colspan='2'><input type='checkbox' name='clienteCppStatus' value='SP' $cpp2> SEGUNDO PROPONENTE</td><td class='noborder cpp' colspan='2'><input type='checkbox' name='clienteCppStatus' value='P' $cpp3> PROCURADOR</td><td class='noborder cpp' colspan='2'><input type='checkbox' name='clienteCppStatus' value='N' $cpp4> NENHUM</td></tr>
           ";

        $html2 = "<tr><td colspan='8' class='secao'>DADOS DO " . mb_strtoupper($tipocpp) . "</td></tr>
                  <tr><td class='titulo'>NOME</td><td colspan='7'>$clienteCppNome</td></tr>
                  <tr><td class='titulo'>NACIONALIDADE</td><td colspan='5'>$clienteCppNacionalidade</td><td class='titulo'>NASCIMENTO</td><td>$clienteCppDataNascimento</td></tr>
                  <tr><td class='titulo'>RG</td><td colspan='2'>$clienteCppRG</td><td class='titulo'>ÓRGÃO EMISSOR</td><td colspan='2'>$clienteCppOrgaoEmissor - $clienteCppEstadoOrgaoEmissor</td><td class='titulo'>CPF</td><td>" . mascara($clienteCppCPF, '###.###.###-##') . "</td></tr>
                  <tr><td class='titulo'>ESTADO CIVIL</td><td colspan='2'>$clienteCppEstadoCivil</td><td class='titulo'>REGIME DE COMUNHÃO</td><td colspan='4'>$clienteCppRegimeComunhao</td></tr>
                  <tr><td class='titulo'>ENDEREÇO</td><td colspan='7'>$clienteCppEndereco - $clienteCppCidade/$clienteCppEstado</td></tr>
                  <tr><td class='titulo'>TELEFONE RESIDENCIAL</td><td colspan='3'>$clienteCppTelefone2</td><td class='titulo'>CELULAR</td><td colspan='3'>$clienteCppTelefone</td></tr>
                  <tr><td class='titulo'>PROFISSÃO</td><td colspan='2'>$clienteCppProfissao</td><td class='titulo'>CARGO</td><td colspan='2'>CARGO</td><td class='titulo'>RENDA</td><td>R$ " . number_format($clienteCppRenda, 2, ',', '.') . "</td></tr>
                  <tr><td class='titulo'>EMPRESA</td><td colspan='7'>$clienteCppEmpresa</td></tr>";

        if ($clienteCppStatus != "N") {
            $Html .= $html2;
        }
        $Parcelas = explode(";", $produtoParcelas);
        $ParcelasPeriodicidade = explode(";", $produtoParcelasPeriodicidade);
        $ParcelasDataVencimento = explode(";", $produtoParcelasDataVencimento);
        $ParcelasValorUnitario = explode(";", $produtoParcelasValorUnitario);
        $ParcelasValorTotal = explode(";", $produtoParcelasValorTotal);
        $ParcelasAtualizacaoMonetaria = explode(";", $produtoParcelasAtualizacaoMonetaria);
        $ParcelasFormaPagamento = explode(";", $produtoParcelasFormaPagamento);
        $ParcelasObservacoes = explode(";", $produtoParcelasObservacoes);
        $ultimo = count($Parcelas);
        $ultimo--;

        $Html .= "<tr><td colspan='8' class='secao'>DADOS DO PRODUTO</td></tr>
                  <tr><td rowspan='2' class='center noborder'>Empreendimento</td><td rowspan='2' colspan='2' class='negrito center noborder'>RESIDENCIAL PARK VILLE</td><td class='center noborder'>Unidade autônoma</td><td colspan='2' class='negrito center noborder'>$produtoApartamento</td><td rowspan='2' class='center noborder'>Valor</td><td rowspan='2' class='negrito center noborder'>R$ " . number_format($produtoValor, 2, ',', '.') . "</td></tr>
                  <tr><td class='center noborder'>Box</td><td colspan='2' class='negrito center noborder'>$produtoBox</td></tr>
                  <tr><td colspan='8' class='secao'>PREÇO E FORMA DE PAGAMENTO</td></tr>
                  <tr><td class='titulo center'>Número de parcelas</td><td class='titulo center'>Periodicidade</td><td class='titulo center'>Data do 1º vencimento da Série</td><td class='titulo center'>Valor Unitário Nesta Data</td><td class='titulo center'>Valor Total da Série de Parcelas</td><td class='titulo center'>Atualização Monetária</td><td class='titulo center'>Forma de Pagamento</td><td class='titulo center'>Observações</td></tr>";

        for ($i = 0; $i <= $ultimo; $i++) {
            $Parcela = $Parcelas[$i];
            $Periodicidade = $ParcelasPeriodicidade[$i];

            switch ($Periodicidade) {
                case 1:
                    $Periodicidade = "Única";
                    break;
                case 2:
                    $Periodicidade = "Mensal";
                    break;
            }

            $DataVencimento = $ParcelasDataVencimento[$i];
            $ValorUnitario = $ParcelasValorUnitario[$i];
            $ValorTotal = $ParcelasValorTotal[$i];
            $AtualizacaoMonetaria = $ParcelasAtualizacaoMonetaria[$i];
            switch ($AtualizacaoMonetaria) {
                case 1:
                    $AtualizacaoMonetaria = "Fixa e irreajustável";
                    break;
                case 2:
                    $AtualizacaoMonetaria = "Reajustável";
                    break;
            }
            $FormaPagamento = $ParcelasFormaPagamento[$i];
            switch ($FormaPagamento) {
                case 1:
                    $FormaPagamento = "À VISTA";
                    break;
                case 2:
                    $FormaPagamento = "BOLETO";
                    break;
            }
            $Observacoes = $ParcelasObservacoes[$i];
            if (empty($Observacoes)) {
                $Observacoes = "-";
            }
            $Html .= "<tr><td class='center'>$Parcela</td><td class='center'>$Periodicidade</td><td class='center'>$DataVencimento</td><td class='center'>$ValorUnitario</td><td class='center'>$ValorTotal</td><td class='center'>$AtualizacaoMonetaria</td><td class='center'>$FormaPagamento</td><td class='center'>$Observacoes</td></tr>";
        }
        $Html .= "<tr><td class='titulo'>OBSERVAÇÕES</td><td colspan='7'>Em caso de desistência de ambas as partes será cobrado uma multa de R$5.000,00 para despesas decorrentes da manutenção do contrato (comissão de corretagem e outros)</td></tr>
                  <tr><td colspan='8' class='secao'>CONSIDERAÇÕES GERAIS</td></tr>
                  <tr><td colspan='8' class='consideracoes'>1- A partir desta data, até o mês de liberação do 'HABITE-SE' pela municipalidade, os valores serão reajustados pelo INCC (Índice Nacional da Construção Civil). A partir do 1º (primeiro) dia do mês posterior à expedição do 'HABITE-SE', até a quitação final, os valores serão reajustados mensalmente pelo IGP-M (Índice Geral de Preços de Mercado), acrescido de juros de 1% (um por cento) ao mês.</td></tr>
                  <tr><td colspan='8' class='consideracoes'>2- Esta proposta será analisada pleo VENDEDOR que poderá recusá-la, ainda que imotivadamente.</td></tr>
                  <tr><td colspan='8' class='consideracoes'>3- A concessão do financiamento bancário está sujeita a análise junto aos órgãos de proteção de crédito, bem como dos critérios estabelecidos pelo banco financiador. É certa a exclusiva responsabilidade dos proponentes na aquisição dos recursos para pagamento da parcela de financiamento estipulada nesta proposta, através de crédito bancário ou recursos próprios.</td></tr>
                  <tr><td colspan='8' class='consideracoes'>4- Esta proposta poderá vir acompanhada dos cheques de sinal de negócio. Os valores devidos em razão de honorários de intermediação imobiliária serão realizados através do sinal de negócio determinado nesta proposta, no momento da assinatura do contrato. Em caso de recusa dessa proposta, ou ainda, em caso de devolução do(s) cheque(s) de sinal, essa proposta perderá qualquer eficácia jurídica, ficando o bem totalmente liberado para comercialização.</td></tr>
                  <tr><td colspan='8' class='consideracoes'>5- Os valores referentes a sinal de negócio e intermediação imobiliária deverão ser quitados no ato da assinatura desta proposta. Em caso de recusa, ou ainda, devolução do(s) cheque(s), a mesma perderá qualquer eficácia jurídica, ficando o bem totalmente liberado para comercialização.</td></tr>
                  <tr><td colspan='3' class='titulo center'>Intermediador</td><td class='titulo center'>Data de Vencimento</td><td class='titulo center'>Percentual</td><td class='titulo center'>Forma de Pagamento</td><td colspan='2' class='titulo center'>Observações</td></tr>";
        if ($vendedorId <> 1) {
             switch ($produtoVendedorForma) {
                case 1:
                    $produtoVendedorForma = "À VISTA";
                    break;
                case 2:
                    $produtoVendedorForma = "BOLETO";
                    break;
            }
            $Html .= "<tr><td colspan='3'>$VendedorNome</td><td class='center'>$produtoVendedorData</td><td class='center'>$produtoVendedorComissao %</td><td class='center'>$produtoVendedorForma</td><td colspan='2' class='center'>$produtoVendedorObservacao</td></tr>
                      <tr><td colspan='7' class='titulo negrito'>Total dos serviços</td><td class='titulo negrito'>R$ ".number_format(($produtoVendedorComissao/100) * $produtoValor, 2, ',', '.')."</td></tr>";
        } else {
            $Html .= "<tr><td colspan='3'>DIRETO</td><td class='center'> - </td><td class='center'> - </td><td class='center'> - </td><td colspan='2' class='center'> - </td></tr>
                      <tr><td colspan='7' class='titulo negrito'>Total dos serviços</td><td class='titulo negrito center'> - </td></tr>";
            
        }
        $Html .= "<tr><td colspan='8' class='secao'>LOCAL E ASSINATURAS</td></tr>".
//         <tr><td class='titulo'>Corretor</td><td colspan='7'>";
//
//        if ($vendedorId <> 1) {
//            $Html .= $VendedorNome;
//        } else {
//            $Html .= "DIRETO";
//        }
//
//        $Html .= "</td></tr>
                  "<tr><td colspan='8' class='direita noborder'>Inhumas, Estado de Goiás, $produtoDataVenda</td></tr>
                  <tr><td colspan='4' class='noborder center assinatura'>CÉSAR JOSÉ BALTAZAR</td><td colspan='4' class='noborder center assinatura'>BENEDITO INÁCIO DA SILVEIRA JÚNIOR</td></tr>
                  <tr><td colspan='4' class='noborder center cargoassinatura'>Sócio Proprietário</td><td colspan='4' class='noborder center cargoassinatura'>Sócio proprietário</td></tr>";

        if ($clienteCppStatus != "N") {
            $assinatura = "<tr><td colspan='4' class='noborder center assinatura'>$clienteNome</td><td colspan='4' class='noborder center assinatura'>$clienteCppNome</td></tr>"
                    . "<tr><td colspan='4' class='noborder center cargoassinatura'>Proponente</td><td colspan='4' class='noborder center cargoassinatura'>" . $tipocpp . "</td></tr>";
            if ($vendedorId <> 1) {
                $assinatura .= "<tr><td colspan='4' class='noborder center assinatura'>$VendedorNome</td></tr>
                       <tr><td colspan='4' class='noborder center cargoassinatura'>Intermediador</td></tr>";
            }
        } else {
            $assinatura = "<tr><td colspan='4' class='noborder center assinatura'>$clienteNome</td>";
            if ($vendedorId <> 1) {
                $assinatura .= "<td colspan='4' class='noborder center assinatura'>$VendedorNome</td></tr>";
            }
            $assinatura .= "<tr><td colspan='4' class='noborder center cargoassinatura'>Proponente</td>";
            if ($vendedorId <> 1) {
                $assinatura .= "<td colspan='4' class='noborder center cargoassinatura'>Intermediador</td></tr>";
            }
        }

        $Html .= "$assinatura</tbody></table>";
        $mpdf->WriteHTML($Html);
        $arquivo = date("d-m-Y") . "-proposta-($clienteNome-$produtoApartamento).pdf";

        $mpdf->Output($arquivo, "I");
        exit();
    }

}
