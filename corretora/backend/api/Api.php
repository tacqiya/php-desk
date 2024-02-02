<?php
namespace App\Api;
use App\Model\CarteiraVirtual;
use App\Model\CryptoQuote;
class API {
    private $cryptoQuote;
    private $carteiraVirtual;

    public function __construct($db) {
        $this->cryptoQuote = new CryptoQuote($db);
        $this->carteiraVirtual = new CarteiraVirtual($db);
    }
    
    public function get_quote($data) {
    $new_price=$this->cryptoQuote->update_price($data);
            echo json_encode(["success" => true,'nome'=> $new_price['nome'], 'crypto'=> $new_price['sigla'] ,'preco'=>$new_price['valor']]);
        }
    public function createCarteira($data) {
        //$this->carteiraVirtual->createCarteira($data);
       $result = $this->carteiraVirtual->handleTransaction($data);
        echo $result;
    }

    public function getCarteira($token) {
        $result = $this->carteiraVirtual->getCarteira($token);
        echo json_encode($result);
    }

    public function updateCarteira($token, $data) {
        $this->carteiraVirtual->updateCarteira($token, $data);
        echo json_encode(["success" => true,'message'=>'Sucesso na transação']);
    }

    public function deleteCarteira($token) {
        $this->carteiraVirtual->deleteCarteira($token);
        echo json_encode(["success" => true,'message'=>'Carteira excluida com sucesso']);
    }
    public function initializeMoney($data) {
        $token=$data['token'];
        $result=$this->carteiraVirtual->initializeMoney($token, $data);
        echo json_encode(["success" => true,'money'=>'13000']);
    }   
    public function getMoney($token) {
        $this->carteiraVirtual->getMoney($token);
       
    }
    public function updateMoney($token,$data) {
        $this->carteiraVirtual->updateMoney($token, $data);
       
    }

    
}