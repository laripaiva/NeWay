<?php
setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );
date_default_timezone_set( 'America/Sao_Paulo' );
require('fpdf/alphapdf.php');
require('PHPMailer/class.phpmailer.php');
require('../Config.inc.php');

$course = filter_input (INPUT_GET, 'curso');
$aluno= filter_input (INPUT_GET, 'aluno', FILTER_VALIDATE_INT);

$readCourse = new Read;
$readCourse->exeRead("courses", "WHERE titulo = :t","t={$course}");

if ($readCourse->getResult()){
    $readUser = new Read;
    $readUser->exeRead("users", "WHERE id = :t","t={$aluno}");
    if ($readUser->getResult()){
      $fuck = new Read;
      $fuck->exeRead("watch_courses","WHERE id_user = :id AND id_courses = :idc","id={$aluno}&idc={$readCourse->getResult()[0]['id']}");
      if (!$fuck->getResult()){
        echo "<script>alert('Ação Invalida');</script>";
        header('Location:../../user/dashboard.php?exe=index');
      }else{
        $email    = 'aaaaa';
        //$nome = filter_input (INPUT_GET, 'nome');
        $nome = $readUser->getResult()[0]['nome'] . ' ' . $readUser->getResult()[0]['nome_final'];
        $cpf      = 8;
        // --------- Variáveis que podem vir de um banco de dados por exemplo ----- //
        $empresa  = "NeWay Cursos LTDA";
        $curso = $readCourse->getResult()[0]['titulo'];
        $data     = (strftime( '%d de %B de %Y', strtotime( date( 'Y-m-d' ))));
        $carga_h  = $readCourse->getResult()[0]['carga_horaria'] . " horas";


        $texto1 = utf8_decode($empresa);
        $texto2 = utf8_decode("pela participação no curso de ".$curso." com carga horária total de ".$carga_h.". \n Certificado emitido em ".$data . ".");
        $texto3 = utf8_decode("Rio de Janeiro, ".utf8_encode(strftime( '%d de %B de %Y', strtotime( date( 'Y-m-d' ) ) )));


        $pdf = new AlphaPDF();

        // Orientação Landing Page ///
        $pdf->AddPage('L');

        $pdf->SetLineWidth(1.5);


        // desenha a imagem do certificado
        $pdf->Image('certificado.jpg',0,0,295);

        // opacidade total
        $pdf->SetAlpha(1);

        // Mostrar texto no topo
        $pdf->SetFont('Arial', '', 15); // Tipo de fonte e tamanho
        $pdf->SetXY(122,46); //Parte chata onde tem que ficar ajustando a posição X e Y
        $pdf->MultiCell(265, 10, $texto1, '', 'L', 0); // Tamanho width e height e posição

        // Mostrar o nome
        $pdf->SetFont('Arial', '', 30); // Tipo de fonte e tamanho
        $pdf->SetXY(20,86); //Parte chata onde tem que ficar ajustando a posição X e Y
        $pdf->MultiCell(265, 10, $nome, '', 'C', 0); // Tamanho width e height e posição

        // Mostrar o corpo
        $pdf->SetFont('Arial', '', 15); // Tipo de fonte e tamanho
        $pdf->SetXY(20,110); //Parte chata onde tem que ficar ajustando a posição X e Y
        $pdf->MultiCell(265, 10, $texto2, '', 'C', 0); // Tamanho width e height e posição

        // Mostrar a data no final
        $pdf->SetFont('Arial', '', 15); // Tipo de fonte e tamanho
        $pdf->SetXY(32,172); //Parte chata onde tem que ficar ajustando a posição X e Y
        $pdf->MultiCell(165, 10, $texto3, '', 'L', 0); // Tamanho width e height e posição

        $pdfdoc = $pdf->Output('', 'S');



        // ******** Agora vai enviar o e-mail pro usuário contendo o anexo
        // ******** e também mostrar na tela para caso o e-mail não chegar

        $subject = 'Seu Certificado do Curso';
        $messageBody = "Olá $nome<br><br>É com grande prazer que entregamos o seu certificado.<br>Atenciosamente,<br>Equipe NeWay<br>";


        $mail = new PHPMailer();
        $mail->SetFrom("gustavogarcia@pet-si.ufrrj.br", "Certificado");
        $mail->Subject    = $subject;
        $mail->MsgHTML(utf8_decode($messageBody));
        $mail->AddAddress($email);
        $mail->addStringAttachment($pdfdoc, 'certificado.pdf');
        $mail->Send();

        $certificado="arquivos/$cpf.pdf"; //atribui a variável $certificado com o caminho e o nome do arquivo que será salvo (vai usar o CPF digitado pelo usuário como nome de arquivo)
        $pdf->Output($certificado,'F'); //Salva o certificado no servidor (verifique se a pasta "arquivos" tem a permissão necessária)
        // Utilizando esse script provavelmente o certificado ficara salvo em www.seusite.com.br/gerar_certificado/arquivos/999.999.999-99.pdf (o 999 representa o CPF digitado pelo usuário)

        $pdf->Output(); // Mostrar o certificado na tela do navegador

      }
    }else{
        echo "<script>alert('Ação Invalida');</script>";
        header('Location:../../user/dashboard.php?exe=index');
      }
}else{
      echo "<script>alert('Ação Invalida');</script>";
      header('Location:../../user/dashboard.php?exe=index');
}









/*
$dataUser = new Read;
$dataUser->exeRead("users","WHERE id = :id","id={$teste['id_user']}");
$dataUser= $dataUser->getResult()[0];

var_dump($dataUser);
*/
/*
// --------- Variáveis do Formulário ----- //

$email    = $dados['email'];
$nome     = $dados['nome'];
$cpf      = $dados['id'];
*/


?>
