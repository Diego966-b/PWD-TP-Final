<?php
class Encriptar
{
    
    // Atributos

    private $texto;

    // Métodos 
    
    /**
     * Recibe los valores iniciales para los atributos
     */
    public function __construct()
    {
        $this -> texto = "";
    }

    /**
     * Encripta con md5 el texto y lo devuevle.
     */
    public function encriptarMd5 ($texto)
    {
        $textoEncriptado = md5($texto);
        return $textoEncriptado;
    }


    // Métodos get

    public function getTexto ()
    {
        return $this -> texto;
    }

    // Métodos set

    /**
     * Set de texto
     * @param string $textoNuevo
     */
    public function setTexto ($textoNuevo)
    {
        $this -> texto = $textoNuevo;
    }
}