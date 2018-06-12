<?php

//CONFIGURAÇÕES DO SITE
define ('HOST', 'localhost');
define ('USER', 'root');
define ('PASS', '');
define ('DBSA', 'bd_neway');

/**
 * Verificação se o arquivo existe e se ele não é um diretório
*/ 
function __autoload($Class){
    
    //dirName -> Nome do diretório
    $configDir = ['Conn','Helpers', 'Models']; //Configuração de diretório
    $incDir = null; //Inclusão de diretório

    /**
     * Verificação se o arquivo existe e se ele não é um diretório
     */
    foreach ($configDir as $dirName){
        if (!$incDir && file_exists(__DIR__."\\{$dirName}\\{$Class}.class.php") &&  !is_dir($dirName)){
            include_once(__DIR__."\\{$dirName}\\{$Class}.class.php");
            $incDir= true;
        }
    }

    /**
     * Retorno do erro
     */
    if (!$incDir){
        trigger_error("Não foi possível incluir {$Class}.class.php", E_USER_ERROR);
    }

}

/*
----------------------------------------------------------------------------------------------------------------
*/ 

//TRATAMENTO DE ERROS

//CSS constantes :: Mensagens de Erro

define('ACCEPT','accept'); //Constante de sucesso
define('INFOR','infor'); // Constante de notícia
define('ALERT','alert'); // Constante de alerta
define('ERROR','error'); // Constante de erro

//Erro:: Exibição dos erros  (Exibindo o erro, sem exibir linha ou arquivo) // PARTE FRONT END

function frontErro ($msgErro, $tipoErro, $erroDie = null){
    
    if ($tipoErro == E_USER_NOTICE){
        $cssClass= INFOR;
    }
    elseif ($tipoErro == E_USER_WARNING){
        $cssClass = ALERT;
    } 
    elseif ($tipoErro == E_USER_ERROR){
        $cssClass = ERROR;
    }
    else{
        $cssClass = ACCEPT;
    }

    echo "<p class =\"trigger {$cssClass}\"> ";
    echo "{$msgErro}</p>";

    if ($erroDie){
        die;
    }
}


function endErro ($tipoErro, $msgErro,  $arqErro, $linhaErro){

    if ($tipoErro == E_USER_NOTICE){
        $cssClass= INFOR;
    }
    elseif ($tipoErro == E_USER_WARNING){
        $cssClass = ALERT;
    } 
    elseif ($tipoErro == E_USER_ERROR){
        $cssClass = ERROR;
    }
    else{
        $cssClass = ACCEPT;
    }

    echo "<p class =\"trigger {$cssClass}\"> ";
    echo ("<b>Erro na linha: {$linhaErro} : </b> {$msgErro} <br>");
    echo ("<small> {$arqErro} </small></p>");
}

set_error_handler ('frontErro');