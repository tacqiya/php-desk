<?php
namespace App\Model;
use Database;
class CryptoQuote {
    private $db;
    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function update_price($sigla) {
        // Primeiro, vamos buscar o valor atual do banco de dados.
        $conditions = ["sigla" => $sigla];
        $result = $this->db->read("cotacao", $conditions);
        if(count($result) > 0) {
            $current_value = $result[0]['valor'];
        } else {
            $current_value = 100; // Valor inicial se não houver entrada no banco de dados.
        }

        // Em seguida, calculamos a nova cotação e a variação.
        $percentage_change = mt_rand(-100, 100) / 1000; // Alteração de preço entre -0.1 e 0.1.
        $new_price = $current_value + ($current_value * $percentage_change);

        // Finalmente, atualizamos o banco de dados.
        $data = ["valor" => $new_price, "variacao" => $percentage_change];
        if(count($result) > 0) {
            // Se já houver uma entrada no banco de dados, atualizamos.
            $this->db->update("cotacao", $data, $conditions);
        } else {
            // Se não houver entrada no banco de dados, criamos uma nova.
            $data = array_merge($data, $conditions);
            $this->db->create("cotacao", $data);
        }

        return $result[0];
    }
}