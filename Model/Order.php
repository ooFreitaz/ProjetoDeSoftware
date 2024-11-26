<?php
class Order {
    protected $idCompra;
    protected $idComprador;
    protected $idVendedor;
    protected $idServico;
    protected $dataCompra;
    protected $valorFinal;

    // Getters
    public function getIdCompra() {
        return $this->idCompra;
    }

    public function getIdComprador() {
        return $this->idComprador;
    }

    public function getIdVendedor() {
        return $this->idVendedor;
    }

    public function getIdServico() {
        return $this->idServico;
    }

    public function getDataCompra() {
        return $this->dataCompra;
    }

    public function getValorFinal() {
        return $this->valorFinal;
    }

    // Setters
    public function setIdCompra($idCompra) {
        $this->idCompra = $idCompra;
    }

    public function setIdComprador($idComprador) {
        $this->idComprador = $idComprador;
    }

    public function setIdVendedor($idVendedor) {
        $this->idVendedor = $idVendedor;
    }

    public function setIdServico($idServico) {
        $this->idServico = $idServico;
    }

    public function setDataCompra($dataCompra) {
        $this->dataCompra = $dataCompra;
    }

    public function setValorFinal($valorFinal) {
        $this->valorFinal = $valorFinal;
    }
}
?>
