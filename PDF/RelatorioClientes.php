<?php

ini_set("memory_limit", "-1");
define('MPDF_PATH', 'class/mpdf/');
require_once 'mpdf/mpdf.php';
require_once '../Ados/ClienteAdo.php';
require_once '../Ados/ProdutoAdo.php';

class RelatorioClientes {

    function EmitirRelatorioDeClientes() {
        $mpdf = new mPDF('pt', 'A4', 0, 'arial', 20, 20, 35, 20, 9, 9, 'P');
        $stylesheet = file_get_contents('../PDF/pdf_sistema.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->SetHTMLHeader('<table class="header"><tbody><tr><td rowspan="3" class="logo"><img src="../IMG/logo89x50.png" /></td><td class="nopad_top">PARK VILLE INCORPORAÇÃO SPE LTDA - 23.501.469/0001-00</td></tr><tr><td class="nopad_top">Rua Francisco Soyer, nº 714, Centro, Inhumas/GO</td></tr><tr><td class="nopad_top"></td></tr><tr><td class="titulo_relatorio center" colspan="2">Ficha do Cliente</td></tr></tbody></table>');

        $clienteAdo = new ClienteAdo();
        $arrayDeClientes = $clienteAdo->consultaArrayDeObjeto();

        if (is_array($arrayDeClientes)) {
            $a = count($arrayDeClientes);
            foreach ($arrayDeClientes as $clienteModel) {
                $Html = null;
                $clienteId = $clienteModel->getClienteId();
                $clienteNome = $clienteModel->getClienteNome();
                $clienteNacionalidade = $clienteModel->getClienteNacionalidade();
                $clienteDataNascimento = $clienteModel->getClienteDataNascimento();
                $clienteCPF = $clienteModel->getClienteCPF();
                $clienteRG = $clienteModel->getClienteRG();
                $clienteOrgaoEmissor = $clienteModel->getClienteOrgaoEmissor();
                $clienteEstadoOrgaoEmissor = $clienteModel->getClienteEstadoOrgaoEmissor();
                $clienteSexo = $clienteModel->getClienteSexo();
                $clienteEstadoCivil = $clienteModel->getClienteEstadoCivil();
                $clienteRegimeComunhao = $clienteModel->getClienteRegimeComunhao();
                $clienteFiliacao = $clienteModel->getClienteFiliacao();
                $clienteFiliacao2 = $clienteModel->getClienteFiliacao2();
                $clienteTelefone = $clienteModel->getClienteTelefone();
                $clienteTelefone2 = $clienteModel->getClienteTelefone2();
                $clienteEndereco = $clienteModel->getClienteEndereco();
                $clienteCidade = $clienteModel->getClienteCidade();
                $clienteEstado = $clienteModel->getClienteEstado();
                $clienteCEP = $clienteModel->getClienteCEP();
                $clienteEmail = $clienteModel->getClienteEmail();
                $clienteProfissao = $clienteModel->getClienteProfissao();
                $clienteRenda = $clienteModel->getClienteRenda();
                $clienteEmpresa = $clienteModel->getClienteEmpresa();
                $clienteCargo = $clienteModel->getClienteCargo();

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
                <tr><td colspan='8' class='secao'>DADOS DO CLIENTE</td></tr>
                <tr><td class='titulo'>NOME</td><td colspan='7'>$clienteNome</td></tr>
                <tr><td class='titulo'>NACIONALIDADE</td><td colspan='5'>$clienteNacionalidade</td><td class='titulo'>NASCIMENTO</td><td>$clienteDataNascimento</td></tr>
                <tr><td class='titulo'>RG</td><td colspan='2'>$clienteRG</td><td class='titulo'>ÓRGÃO EMISSOR</td><td colspan='2'>$clienteOrgaoEmissor - $clienteEstadoOrgaoEmissor</td><td class='titulo'>CPF</td><td>" . mascara($clienteCPF, '###.###.###-##') . "</td></tr>
                <tr><td class='titulo'>ESTADO CIVIL</td><td colspan='2'>$clienteEstadoCivil</td><td class='titulo'>REGIME DE COMUNHÃO</td><td colspan='4'>$clienteRegimeComunhao</td></tr>
                <tr><td class='titulo'>ENDEREÇO</td><td colspan='7'>$clienteEndereco - $clienteCidade/$clienteEstado</td></tr>
                <tr><td class='titulo'>TELEFONE RESIDENCIAL</td><td colspan='3'>$clienteTelefone2</td><td class='titulo'>CELULAR</td><td colspan='3'>$clienteTelefone</td></tr>
                <tr><td class='titulo'>PROFISSÃO</td><td colspan='2'>$clienteProfissao</td><td class='titulo'>CARGO</td><td colspan='2'>$clienteCargo</td><td class='titulo'>RENDA</td><td>R$ " . number_format($clienteRenda, 2, ',', '.') . "</td></tr>
                <tr><td class='titulo'>EMPRESA</td><td colspan='7'>$clienteEmpresa</td></tr>";

                $clienteCppStatus = $clienteModel->getClienteCppStatus();

                $clienteCppNome = $clienteModel->getClienteCppNome();
                $clienteCppNacionalidade = $clienteModel->getClienteCppNacionalidade();
                $clienteCppDataNascimento = $clienteModel->getClienteCppDataNascimento();
                $clienteCppCPF = $clienteModel->getClienteCppCPF();
                $clienteCppRG = $clienteModel->getClienteCppRG();
                $clienteCppOrgaoEmissor = $clienteModel->getClienteCppOrgaoEmissor();
                $clienteCppEstadoOrgaoEmissor = $clienteModel->getClienteCppEstadoOrgaoEmissor();
                $clienteCppSexo = $clienteModel->getClienteCppSexo();
                $clienteCppEstadoCivil = $clienteModel->getClienteCppEstadoCivil();
                $clienteCppRegimeComunhao = $clienteModel->getClienteCppRegimeComunhao();
                $clienteCppFiliacao = $clienteModel->getClienteCppFiliacao();
                $clienteCppFiliacao2 = $clienteModel->getClienteCppFiliacao2();
                $clienteCppTelefone = $clienteModel->getClienteCppTelefone();
                $clienteCppTelefone2 = $clienteModel->getClienteCppTelefone2();
                $clienteCppEndereco = $clienteModel->getClienteCppEndereco();
                $clienteCppCidade = $clienteModel->getClienteCppCidade();
                $clienteCppEstado = $clienteModel->getClienteCppEstado();
                $clienteCppCEP = $clienteModel->getClienteCppCEP();
                $clienteCppEmail = $clienteModel->getClienteCppEmail();
                $clienteCppProfissao = $clienteModel->getClienteCppProfissao();
                $clienteCppRenda = $clienteModel->getClienteCppRenda();
                $clienteCppEmpresa = $clienteModel->getClienteCppEmpresa();
                $clienteCppCargo = $clienteModel->getClienteCppCargo();

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
                    <tr><td class='noborder cpp' colspan='2'><input type='checkbox' name='clienteCppStatus' value='C' $cpp1> CONJUGE</td><td class='noborder cpp' colspan='2'><input type='checkbox' name='clienteCppStatus' value='SP' $cpp2> SEGUNDO PROPONENTE</td><td class='noborder cpp' colspan='2'><input type='checkbox' name='clienteCppStatus' value='P' $cpp3> PROCURADOR</td><td class='noborder cpp' colspan='2'><input type='checkbox' name='clienteCppStatus' value='N' $cpp4> NENHUM</td></tr>";

                $html2 = "<tr><td colspan='8' class='secao'>DADOS DO " . mb_strtoupper($tipocpp) . "</td></tr>
                  <tr><td class='titulo'>NOME</td><td colspan='7'>$clienteCppNome</td></tr>
                  <tr><td class='titulo'>NACIONALIDADE</td><td colspan='5'>$clienteCppNacionalidade</td><td class='titulo'>NASCIMENTO</td><td>$clienteCppDataNascimento</td></tr>
                  <tr><td class='titulo'>RG</td><td colspan='2'>$clienteCppRG</td><td class='titulo'>ÓRGÃO EMISSOR</td><td colspan='2'>$clienteCppOrgaoEmissor - $clienteCppEstadoOrgaoEmissor</td><td class='titulo'>CPF</td><td>" . mascara($clienteCppCPF, '###.###.###-##') . "</td></tr>
                  <tr><td class='titulo'>ESTADO CIVIL</td><td colspan='2'>$clienteCppEstadoCivil</td><td class='titulo'>REGIME DE COMUNHÃO</td><td colspan='4'>$clienteCppRegimeComunhao</td></tr>
                  <tr><td class='titulo'>ENDEREÇO</td><td colspan='7'>$clienteCppEndereco - $clienteCppCidade/$clienteCppEstado</td></tr>
                  <tr><td class='titulo'>TELEFONE RESIDENCIAL</td><td colspan='3'>$clienteCppTelefone2</td><td class='titulo'>CELULAR</td><td colspan='3'>$clienteCppTelefone</td></tr>
                  <tr><td class='titulo'>PROFISSÃO</td><td colspan='2'>$clienteCppProfissao</td><td class='titulo'>CARGO</td><td colspan='2'>$clienteCppCargo</td><td class='titulo'>RENDA</td><td>R$ " . number_format($clienteCppRenda, 2, ',', '.') . "</td></tr>
                  <tr><td class='titulo'>EMPRESA</td><td colspan='7'>$clienteCppEmpresa</td></tr>";

                if ($clienteCppStatus != "N") {
                    $Html .= $html2;
                }

                $ProdutoAdo = new ProdutoAdo();

                $produto = $ProdutoAdo->consultaProdutoPeloCliente($clienteId);

                if (is_array($produto) and count($produto) > 0) {
                    $Html .= "<tr><td class='secao center' colspan='8'>APARTAMENTOS COMPRADOS</tr>"
                            . "<tr class='borda'><td class='titulo center noborder'>#</td><td colspan='3' class='titulo noborder center'>Apartamento</td><td colspan='2' class='titulo noborder center'>Box</td><td colspan='2' class='titulo noborder center'>Valor</td></tr>";
                    foreach ($produto as $produtos) {
                        $i = 1;
                        $produtoApartamento = $produtos->getProdutoApartamento();
                        $produtoBox = $produtos->getProdutoBox();
                        $produtoValor = $produtos->getProdutoValor();

                        $Html .= "<tr class='borda'><td class='center noborder'>$i</td><td class='center noborder' colspan='3'>$produtoApartamento</td>"
                                . "<td class='center noborder' colspan='2'>$produtoBox</td>"
                                . "<td class='center noborder' colspan='2'>R$ " . number_format($produtoValor, 2, ',', '.') . "</td></tr>";
                        $i++;
                    }
                } else if (is_array($produto) and count($produto) == 0) {
                    $Html .= "<tr><td class='secao center' colspan='8'>APARTAMENTOS COMPRADOS</tr>"
                            . "<tr><td colspan='8' class='titulo center'>Nenhum apartamento comprado.</td></tr>";
                }
                $Html .= "</tbody></table>";

                $mpdf->WriteHTML($Html, 2);
                $a--;
                if ($a > 0) {
                    $mpdf->AddPage();
                }
            }
        }

        $arquivo = date("d-m-Y") . "-clientes.pdf";
        $mpdf->Output($arquivo, "I");
        exit();
    }

    function EmitirRelatorioDeCliente($clienteModel) {
        $mpdf = new mPDF('pt', 'A4', 0, 'arial', 20, 20, 35, 20, 9, 9, 'P');
        $stylesheet = file_get_contents('../PDF/pdf_sistema.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->SetHTMLHeader('<table class="header"><tbody><tr><td rowspan="3" class="logo"><img src="../IMG/logo89x50.png" /></td><td class="nopad_top">PARK VILLE INCORPORAÇÃO SPE LTDA - 23.501.469/0001-00</td></tr><tr><td class="nopad_top">Rua Francisco Soyer, nº 714, Centro, Inhumas/GO</td></tr><tr><td class="nopad_top"></td></tr><tr><td class="titulo_relatorio center" colspan="2">Ficha do Cliente</td></tr></tbody></table>');

        $Html = null;

        $clienteId = $clienteModel->getClienteId();
        $clienteNome = $clienteModel->getClienteNome();
        $clienteNacionalidade = $clienteModel->getClienteNacionalidade();
        $clienteDataNascimento = $clienteModel->getClienteDataNascimento();
        $clienteCPF = $clienteModel->getClienteCPF();
        $clienteRG = $clienteModel->getClienteRG();
        $clienteOrgaoEmissor = $clienteModel->getClienteOrgaoEmissor();
        $clienteEstadoOrgaoEmissor = $clienteModel->getClienteEstadoOrgaoEmissor();
        $clienteSexo = $clienteModel->getClienteSexo();
        $clienteEstadoCivil = $clienteModel->getClienteEstadoCivil();
        $clienteRegimeComunhao = $clienteModel->getClienteRegimeComunhao();
        $clienteFiliacao = $clienteModel->getClienteFiliacao();
        $clienteFiliacao2 = $clienteModel->getClienteFiliacao2();
        $clienteTelefone = $clienteModel->getClienteTelefone();
        $clienteTelefone2 = $clienteModel->getClienteTelefone2();
        $clienteEndereco = $clienteModel->getClienteEndereco();
        $clienteCidade = $clienteModel->getClienteCidade();
        $clienteEstado = $clienteModel->getClienteEstado();
        $clienteCEP = $clienteModel->getClienteCEP();
        $clienteEmail = $clienteModel->getClienteEmail();
        $clienteProfissao = $clienteModel->getClienteProfissao();
        $clienteRenda = $clienteModel->getClienteRenda();
        $clienteEmpresa = $clienteModel->getClienteEmpresa();
        $clienteCargo = $clienteModel->getClienteCargo();

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
                <tr><td colspan='8' class='secao'>DADOS DO CLIENTE</td></tr>
                <tr><td class='titulo'>NOME</td><td colspan='7'>$clienteNome</td></tr>
                <tr><td class='titulo'>NACIONALIDADE</td><td colspan='5'>$clienteNacionalidade</td><td class='titulo'>NASCIMENTO</td><td>$clienteDataNascimento</td></tr>
                <tr><td class='titulo'>RG</td><td colspan='2'>$clienteRG</td><td class='titulo'>ÓRGÃO EMISSOR</td><td colspan='2'>$clienteOrgaoEmissor - $clienteEstadoOrgaoEmissor</td><td class='titulo'>CPF</td><td>" . mascara($clienteCPF, '###.###.###-##') . "</td></tr>
                <tr><td class='titulo'>ESTADO CIVIL</td><td colspan='2'>$clienteEstadoCivil</td><td class='titulo'>REGIME DE COMUNHÃO</td><td colspan='4'>$clienteRegimeComunhao</td></tr>
                <tr><td class='titulo'>ENDEREÇO</td><td colspan='7'>$clienteEndereco - $clienteCidade/$clienteEstado</td></tr>
                <tr><td class='titulo'>TELEFONE RESIDENCIAL</td><td colspan='3'>$clienteTelefone2</td><td class='titulo'>CELULAR</td><td colspan='3'>$clienteTelefone</td></tr>
                <tr><td class='titulo'>PROFISSÃO</td><td colspan='2'>$clienteProfissao</td><td class='titulo'>CARGO</td><td colspan='2'>$clienteCargo</td><td class='titulo'>RENDA</td><td>R$ " . number_format($clienteRenda, 2, ',', '.') . "</td></tr>
                <tr><td class='titulo'>EMPRESA</td><td colspan='7'>$clienteEmpresa</td></tr>";

        $clienteCppStatus = $clienteModel->getClienteCppStatus();

        $clienteCppNome = $clienteModel->getClienteCppNome();
        $clienteCppNacionalidade = $clienteModel->getClienteCppNacionalidade();
        $clienteCppDataNascimento = $clienteModel->getClienteCppDataNascimento();
        $clienteCppCPF = $clienteModel->getClienteCppCPF();
        $clienteCppRG = $clienteModel->getClienteCppRG();
        $clienteCppOrgaoEmissor = $clienteModel->getClienteCppOrgaoEmissor();
        $clienteCppEstadoOrgaoEmissor = $clienteModel->getClienteCppEstadoOrgaoEmissor();
        $clienteCppSexo = $clienteModel->getClienteCppSexo();
        $clienteCppEstadoCivil = $clienteModel->getClienteCppEstadoCivil();
        $clienteCppRegimeComunhao = $clienteModel->getClienteCppRegimeComunhao();
        $clienteCppFiliacao = $clienteModel->getClienteCppFiliacao();
        $clienteCppFiliacao2 = $clienteModel->getClienteCppFiliacao2();
        $clienteCppTelefone = $clienteModel->getClienteCppTelefone();
        $clienteCppTelefone2 = $clienteModel->getClienteCppTelefone2();
        $clienteCppEndereco = $clienteModel->getClienteCppEndereco();
        $clienteCppCidade = $clienteModel->getClienteCppCidade();
        $clienteCppEstado = $clienteModel->getClienteCppEstado();
        $clienteCppCEP = $clienteModel->getClienteCppCEP();
        $clienteCppEmail = $clienteModel->getClienteCppEmail();
        $clienteCppProfissao = $clienteModel->getClienteCppProfissao();
        $clienteCppRenda = $clienteModel->getClienteCppRenda();
        $clienteCppEmpresa = $clienteModel->getClienteCppEmpresa();
        $clienteCppCargo = $clienteModel->getClienteCppCargo();

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
                  <tr><td class='titulo'>PROFISSÃO</td><td colspan='2'>$clienteCppProfissao</td><td class='titulo'>CARGO</td><td colspan='2'>$clienteCppCargo</td><td class='titulo'>RENDA</td><td>R$ " . number_format($clienteCppRenda, 2, ',', '.') . "</td></tr>
                  <tr><td class='titulo'>EMPRESA</td><td colspan='7'>$clienteCppEmpresa</td></tr>";

        if ($clienteCppStatus != "N") {
            $Html .= $html2;
        }

        $ProdutoAdo = new ProdutoAdo();

        $produto = $ProdutoAdo->consultaProdutoPeloCliente($clienteId);

        if (is_array($produto) and count($produto) > 0) {
            $Html .= "<tr><td class='secao center' colspan='8'>APARTAMENTOS COMPRADOS</tr>"
                    . "<tr class='borda'><td class='titulo center noborder'>#</td><td colspan='3' class='titulo noborder center'>Apartamento</td><td colspan='2' class='titulo noborder center'>Box</td><td colspan='2' class='titulo noborder center'>Valor</td></tr>";
            foreach ($produto as $produtos) {
                $i = 1;
                $produtoApartamento = $produtos->getProdutoApartamento();
                $produtoBox = $produtos->getProdutoBox();
                $produtoValor = $produtos->getProdutoValor();

                $Html .= "<tr class='borda'><td class='center noborder'>$i</td><td class='center noborder' colspan='3'>$produtoApartamento</td>"
                        . "<td class='center noborder' colspan='2'>$produtoBox</td>"
                        . "<td class='center noborder' colspan='2'>R$ " . number_format($produtoValor, 2, ',', '.') . "</td></tr>";
                $i++;
            }
        } else if (is_array($produto) and count($produto) == 0) {
            $Html .= "<tr><td class='secao center' colspan='8'>APARTAMENTOS COMPRADOS</tr>"
                    . "<tr><td colspan='8' class='titulo center'>Nenhum apartamento comprado.</td></tr>";
        }

        $Html .= "</tbody></table>";

        $mpdf->WriteHTML($Html);

        $arquivo = date("d-m-Y") . "-ficha_$clienteNome.pdf";
        $mpdf->Output($arquivo, "I");
        exit();
    }

}
