<?php
class Service {
    private $id;
    private $titulo;
    private $valor;
    private $categoria;
    private $descricao;
    private $prazoEntrega;
    private $imagens;
    private $linksYoutube;
    private $dono_servico;

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getValor() {
        return $this->valor;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getPrazoEntrega() {
        return $this->prazoEntrega;
    }

    public function getImagens() {
        return $this->imagens;
    }

    public function getLinksYoutube() {
        return $this->linksYoutube;
    }

    public function getDonoServico() {
        return $this->dono_servico;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setPrazoEntrega($prazoEntrega) {
        $this->prazoEntrega = $prazoEntrega;
    }

    public function setImagens($imagens) {
        $this->imagens = $imagens;
    }

    public function setLinksYoutube($linksYoutube) {
        $this->linksYoutube = $linksYoutube;
    }

    public function setDonoServico($dono_servico) {
        $this->dono_servico = $dono_servico;
    }
}
?>
