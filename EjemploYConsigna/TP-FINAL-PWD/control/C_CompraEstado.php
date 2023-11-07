<?php
class C_CompraEstado
{

    /**
     * @param array $param
     * @return CompraEstado
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (
            array_key_exists('idCompraEstado', $param) and array_key_exists('idCompra', $param)
            and array_key_exists('idCompraEstadoTipo', $param) and array_key_exists('ceFechaIni', $param)
            and array_key_exists('ceFechaFin', $param)
        ) {

            $objCompra = new Compra();
            $objCompra->setIdCompra($param['idCompra']);
            $objCompra->cargar();

            $objCompraEstadoTipo = new CompraEstadoTipo();
            $objCompraEstadoTipo->setIdCompraEstadoTipo($param['idCompraEstadoTipo']);
            $objCompraEstadoTipo->cargar();

            $obj = new CompraEstado();
            $obj->setear($param['idCompraEstado'], $objCompra, $objCompraEstadoTipo, $param['ceFechaIni'], $param['ceFechaFin']);
        }
        return $obj;
    }

    /**
     * @param array $param
     * @return CompraEstado
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idcompraestado'])) {
            $obj = new CompraEstado();
            $obj->setear($param['idcompraestado'], null, null, null, null);
        }
        return $obj;
    }

    /**
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idCompraEstado']))
            $resp = true;
        return $resp;
    }

    /**
     * Inserta en la base de datos
     * @param array $param
     * @return boolean
     */
    public function alta($param)
    {
        $resp = false;
        $param['idCompraEstado'] = null;
        $obj = $this->cargarObjeto($param);
        if ($obj != null and $obj->insertar()) {
            $resp = true;
        }
        return $resp;
    }


    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $obj = $this->cargarObjetoConClave($param);
            if ($obj != null and $obj->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $obj = $this->cargarObjeto($param);
            if ($obj != null and $obj->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }


    /**
     * @param array $param
     * @return array
     */
    public function buscar($param)
    {
        $where = " true ";
        if ($param != null) {
            if (isset($param['idCompraEstado']))
                $where .= " and idCompraEstado =" . $param['idCompraEstado'];
            if (isset($param['idCompra']))
                $where .= " and idCompra =" . $param['idCompra'];
            if (isset($param['idCompraEstadoTipo']))
                $where .= " and idcompraestadotipo ='" . $param['idcompraestadotipo'] . "'";
        }

        $obj = new CompraEstado();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }

    public function buscarCompraBorrador($arrayCompra)
    {
        $objCompraEstadoInciada = null;
        $i = 0;
        /* Busca en el arraycompra si hay alguna que este con el estado "iniciada" */
        while (($objCompraEstadoInciada == null) && ($i < count($arrayCompra))) {
            $idCompra["idCompra"] = $arrayCompra[$i]->getIdCompra();
            $arrayCompraEstado = $this->buscar($idCompra);
            if ($arrayCompraEstado[0]->getCompraEstadoTipo()->getCetDescripcion() == "borrador") {
                $objCompraEstadoInciada = $arrayCompraEstado[0];
            } else {
                $i++;
            }
        }
        return $objCompraEstadoInciada;
    }

    public function buscarCompras($arrayCompra)
    {
        $arrayCompraIniciadas = [];
        /* Busca en el arraycompra si hay alguna que este con el estado "iniciada" */
        foreach ($arrayCompra as $compra) {
            $idCompra["idCompra"] = $compra->getIdCompra();
            $arrayCompraEstado = $this->buscar($idCompra);
            if (count($arrayCompraEstado) > 1) {
                foreach ($arrayCompraEstado as $compraEstado) {
                    if ($compraEstado->getCeFechaFin() == "0000-00-00 00:00:00") {
                        array_push($arrayCompraIniciadas, $compraEstado);
                    }
                }
            } else {
                if ($arrayCompraEstado[0]->getCompraEstadoTipo()->getIdCompraEstadoTipo() >= 2) {
                    array_push($arrayCompraIniciadas, $arrayCompraEstado[0]);
                }
            }
        }
        return $arrayCompraIniciadas;
    }

    public function compraEstadoActual($arrayCompra)
    {
    }
}
