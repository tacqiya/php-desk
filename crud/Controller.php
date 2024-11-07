<?php
date_default_timezone_set("America/Sao_Paulo");
require_once("Model.php");

$dados = new Model();

$comando="CREATE TABLE IF NOT EXISTS `produtos_2` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `imagem` longblob,
    `descricao` varchar(50) NOT NULL,
    `preco` decimal(9,2) NOT NULL,
    `marca` varchar(50) NOT NULL,
    `fabricante` varchar(50) NOT NULL,
    `datafabricacao` date NOT NULL,
    `origem` varchar(25) NOT NULL,
    `ativo` integer NOT NULL DEFAULT 1,
    `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;";
  
  $dados->multisql($comando);

if(isset($_POST['op'])){
    $op = $_POST['op'];
    if($op=='insert'){
        $descricao = filter_input(INPUT_POST, 'descricao', FILTER_DEFAULT, FILTER_SANITIZE_SPECIAL_CHARS);
        $preco = filter_input(INPUT_POST, 'preco', FILTER_DEFAULT, FILTER_SANITIZE_SPECIAL_CHARS);
        $marca = filter_input(INPUT_POST, 'marca', FILTER_DEFAULT, FILTER_SANITIZE_SPECIAL_CHARS);
        $fabricante = filter_input(INPUT_POST, 'descricao', FILTER_DEFAULT, FILTER_SANITIZE_SPECIAL_CHARS);
        $datafabricacao = filter_input(INPUT_POST, 'dataFab', FILTER_DEFAULT, FILTER_SANITIZE_SPECIAL_CHARS);
        $origem = filter_input(INPUT_POST, 'origem', FILTER_DEFAULT, FILTER_SANITIZE_SPECIAL_CHARS);
        $produto = array(
            "descricao"=> $descricao ,
            "preco"=> $preco,
            "marca"=> $marca,
            "fabricante"=> $fabricante,
            "datafabricacao"=> $datafabricacao,
            "origem"=> $origem      
        );        
                
        $resultado = $dados->insert($produto,'produtos_2');
        
        echo json_encode($resultado);
    }

    if($op=='delete'){
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $condicao = array(
            "where"=> array(
                "id"=> $id,
            )
        );
        $resultado = $dados->delete($condicao,'produtos_2');
        echo json_encode($resultado);
    }

    if($op=='disable'){
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $produto = array(
            "ativo"=> 0      
        ); 
        $condicao = array(
            "id"=> $id,  
        );
        $resultado = $dados->disable($produto,$condicao,'produtos_2');
        if($resultado==1){

        }
        echo json_encode($resultado);
    }

    if($op=='enable'){
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $produto = array(
            "ativo"=> 1      
        ); 
        $condicao = array(
            "id"=> $id,  
        );
        $resultado = $dados->disable($produto,$condicao,'produtos_2');
        if($resultado==1){

        }
        echo json_encode($resultado);
    }

    if($op=='update'){
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $condicao = array(
            "where"=>array(
                "id"=> $id,
            ),
            "return_type"=>'single'
        );
        $descricao = filter_input(INPUT_POST, 'descricao', FILTER_DEFAULT, FILTER_SANITIZE_SPECIAL_CHARS);
        $preco = filter_input(INPUT_POST, 'preco', FILTER_DEFAULT, FILTER_SANITIZE_SPECIAL_CHARS);
        $marca = filter_input(INPUT_POST, 'marca', FILTER_DEFAULT, FILTER_SANITIZE_SPECIAL_CHARS);
        $fabricante = filter_input(INPUT_POST, 'descricao', FILTER_DEFAULT, FILTER_SANITIZE_SPECIAL_CHARS);
        $datafabricacao = filter_input(INPUT_POST, 'dataFab', FILTER_DEFAULT, FILTER_SANITIZE_SPECIAL_CHARS);
        $origem = filter_input(INPUT_POST, 'origem', FILTER_DEFAULT, FILTER_SANITIZE_SPECIAL_CHARS);
        $produto = array(
            "descricao"=> $descricao ,
            "preco"=> $preco,
            "marca"=> $marca,
            "fabricante"=> $fabricante,
            "datafabricacao"=> $datafabricacao,
            "origem"=> $origem      
        );        
        $resultado = $resp = $dados->update($produto,$condicao,"produtos_2");
        
        echo json_encode($resultado);
    }

    if($op=='select'){
        if(isset($_POST['condicao']) && $_POST['condicao']<2){
            $filtro = array(
                "where"=>array(
                    "ativo"=>$_POST['condicao']
                )
            );
            $resultado = $dados->getRows("produtos_2",$filtro);
        }else{
            $resultado = $dados->getRows("produtos_2");
        }
        echo json_encode($resultado);
    }

    if($op=='selectById'){
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $condicao = array(
            "where"=> array(
                "id"=> $id,
            )    
        );
        
        $resultado = $dados->getById("produtos_2",$condicao);
        
        echo json_encode($resultado);
    }
}