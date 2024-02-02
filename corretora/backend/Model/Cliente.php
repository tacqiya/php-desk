<?php
namespace App\Model;
class Cliente {
    private $id;
    private $nome;
    private $endereco;
    private $telefone;
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function save() {
        if ($this->id) {
            return $this->db->update('clientes', [
                'nome' => $this->nome,
                'endereco' => $this->endereco,
                'telefone' => $this->telefone
            ], ['id' => $this->id]);
        } else {
            return $this->db->create('clientes', [
                'nome' => $this->nome,
                'endereco' => $this->endereco,
                'telefone' => $this->telefone
            ]);
        }
    }

    public function delete() {
        return $this->db->delete('clientes', ['id' => $this->id]);
    }
}
