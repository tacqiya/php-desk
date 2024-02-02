<?php
namespace App\Model;
use Database;
class CarteiraVirtual {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function createCarteira($data) {
        $conditions = ["token" => $data['token'], "crypto" => $data['crypto']];
        $carteira = $this->db->read("carteira", $conditions);

        if (empty($carteira[0])) {
            return $this->db->create("carteira", $data);
        } else {
            $data['amount'] += $carteira[0]['amount'];
            $data['preco'] = ($data['amount'] * $data['preco'] + $carteira[0]['amount'] * $carteira[0]['preco']) / ($data['amount'] + $carteira[0]['amount']);
            return $this->db->update("carteira", $data, $conditions);
        }
    }

//     public function handleTransaction($data) {
//     $conditions = ["token" => $data['token'], "crypto" => $data['crypto']];
//     $carteira = $this->db->read("carteira", $conditions);
//     var_dump($carteira);
//     // Verificar saldo na carteira antes de vender
//     if ($data['type'] === 'sell') {
//         if (empty($carteira[0]) || $carteira[0]['amount'] < $data['amount']) {
//             return json_encode([
//                 'status' => 'error',
//                 'message' => 'Não há criptomoedas suficientes para vender na carteira'
//             ]);
//         }
//         $data['amount'] = $carteira[0]['amount'] - $data['amount'];
//         if ($data['amount'] == 0) {
//             $this->db->delete("carteira", $conditions);
//         } else {
//             $this->db->update("carteira", $data, $conditions);
//         }
//     }
//     // Verificar saldo antes de comprar
//     else if ($data['type'] === 'buy') {
//         $moneyConditions = ["token" => $data['token']];
//         $money = $this->db->read("money", $moneyConditions);
//         $totalPrice = $data['amount'] * $data['preco'];
//         if (empty($money[0]) || $money[0]['money'] < $totalPrice) {
//             return json_encode([
//                 'status' => 'error',
//                 'message' => 'Saldo insuficiente para comprar'
//             ]);
//         }
//         $this->createCarteira($data);
//         $newMoney = $money[0]['money'] - $totalPrice;
//         $this->db->update("money", ['money' => $newMoney], $moneyConditions);
//     }
//     return json_encode(['status' => 'success']);
// }
public function handleTransaction($data) {
    $conditions = ["token" => $data['token'], "crypto" => $data['crypto']];
    $carteira = $this->db->read("carteira", $conditions);
    // Verificar saldo na carteira antes de vender
    if ($data['type'] === 'sell') {
        if (empty($carteira[0]) || $carteira[0]['amount'] < $data['amount']) {
            return json_encode([
                'status' => 'error',
                'message' => 'Não há criptomoedas suficientes para vender na carteira'
            ]);
        }

        $newAmount = $carteira[0]['amount'] - $data['amount'];
        if ($newAmount < 0) {
            return json_encode([
                'status' => 'error',
                'message' => 'A quantidade a vender não pode ser maior do que a quantidade na carteira'
            ]);
        } elseif ($newAmount == 0) {
            $this->db->delete("carteira", $conditions);
        } else {
            $this->db->update("carteira", ['amount' => $newAmount], $conditions);
        }

        return json_encode(['status' => 'success','message' => 'Compra realizada com sucesso']);
    }

    // Verificar saldo antes de comprar
    elseif ($data['type'] === 'buy') {
        $moneyConditions = ["token" => $data['token']];
        $money = $this->db->read("money", $moneyConditions);
        $totalPrice = $data['amount'] * $data['preco'];
        if (empty($money[0]) || $money[0]['money'] < $totalPrice) {
            return json_encode([
                'status' => 'error',
                'message' => 'Saldo insuficiente para comprar'
            ]);
        }

        $this->createCarteira($data);
        $newMoney = $money[0]['money'] - $totalPrice;
        $this->db->update("money", ['money' => $newMoney], $moneyConditions);

        return json_encode(['status' => 'success']);
    } else {
        // Retorna um erro se o tipo de transação não for válido
        return json_encode([
            'status' => 'error',
            'message' => 'Tipo de transação não é válido'
        ]);
    }
}



    public function getCarteira($token) {
        $conditions = ["token" => $token];
        return $this->db->read("carteira", $conditions);
    }

    public function updateCarteira($token, $data) {
        $conditions = ["token" => $token];
        return $this->db->update("carteira", $data, $conditions);
    }

    public function deleteCarteira($token) {
        $conditions = ["token" => $token];
       $this->db->delete("carteira", $conditions);
       return  $this->db->update("money", ["money" => '13000'], $conditions);

    }
    public function initializeMoney($token, $data) {
        // Use a variável $data para definir o dinheiro inicial do usuário.
        $conditions = ["token" => $token];
        $moneyData = $this->db->read("money", $conditions);
    
        if (empty($moneyData)) {
            return $this->db->create("money", ["token" => $token, "money" => $data['money']]);
        } else {
            // Usuário já tem dinheiro inicializado.
        }
    }
    public function getMoney($token) {
        $conditions = ["token" => $token];
        $moneyData = $this->db->read("money", $conditions);
        echo json_encode(["money" =>$moneyData]);
    }
    public function updateMoney($token, $data) {
        $conditions = ["token" => $token];
        $moneyData = $this->db->read("money", $conditions);
        $amount = $moneyData[0]['money'];
            if ($data['type'] == 'buy') {
                $amount -= $data['amount'];
            } else if ($data['type'] == 'sell') {
                $amount += $data['amount'] ;
            }
        $this->db->update("money", ["money" => $amount], $conditions);
        echo json_encode(["money" => $amount]);
    }

}