<?php

// ------------------------- DADOS DINAMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

$nome[0] = $_POST["nome"];
$nome[2] = $_POST["nome_final"];
$nome[1] = " ";
$endereco = $_POST["endereco"];
$cidade = $_POST["cidade"];
$estado = $_POST["estado"];
$cep = $_POST["CEP"];
$bairro = $_POST["bairro"];
$numero = $_POST["numero"];

if(!$nome[0] || !$nome[2] || !$endereco || !$cidade || !$estado || !$cep || !$bairro || !$numero){
  echo "<script>alert('Preencha Todos os campos');location.href='../../user/segunda-via.php'; </script>";
}



// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = 2.95;
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";
$valor_cobrado = "199,90"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = '12345678';  // Nosso numero - REGRA: Máximo de 8 caracteres!
$dadosboleto["numero_documento"] = '0123';	// Num do pedido ou nosso numero
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE

$dadosboleto["sacado"] = $nome[0] . $nome[1] . $nome[2];
$dadosboleto["endereco1"] = $endereco. " " . $numero . " " . $bairro;
$dadosboleto["endereco2"] = $cidade . " - " . $estado . "- " . $cep;

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Pagamento da plataforma NeWay";
$dadosboleto["demonstrativo2"] = "Mensalidade referente ao acesso a plataforma<br>Taxa bancaria - R$ ".number_format($taxa_boleto, 2, ',', '');
$dadosboleto["demonstrativo3"] = "NeWay";
$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
$dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
$dadosboleto["instrucoes3"] = "- Em caso de dívidas entre em contato conosco: xxxx@xxxx.com.br";
$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema NeWay ";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "";
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - ITAU
$dadosboleto["agencia"] = "1565"; // Num da agencia, sem digito
$dadosboleto["conta"] = "13877";	// Num da conta, sem digito
$dadosboleto["conta_dv"] = "4"; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - ITAU
$dadosboleto["carteira"] = "175";  // C�digo da Carteira: pode ser 175, 174, 104, 109, 178, ou 157

// SEUS DADOS
$dadosboleto["identificacao"] = "NeWay Cursos LTDA";
$dadosboleto["cpf_cnpj"] = "999-9999-999";
$dadosboleto["endereco"] = "Tequilar";
$dadosboleto["cidade_uf"] = "Seropedica / Rio de Janeiro";
$dadosboleto["cedente"] = "";

// NÃO ALTERAR!
include("include/funcoes_itau.php");
include("include/layout_itau.php");
//}
?>
