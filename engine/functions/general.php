<?php

class general extends Config {
    
    function __construct($data) {
        parent::start($data);
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ#/:.!?~';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    function generateRandomNumber() {
        return substr(number_format(time() * rand(), 0, '', ''), 0, 10);
    }

    function redirigir($url = "") {
        return '<meta http-equiv="refresh" content="0;URL=\'' . $this->config['functions']['url']->returnURL($url) . '\'" />';
    }

    function dropdownmenu($valores, $lista = false, $listid = 'rollist', $multiple = 'multiple') {
        $dropdown = "<select id=\"" . $listid . "\" ";
        $dropdown .= ($lista) ? " size=\"15\" $multiple" : "";
        $dropdown .= ">";
        foreach ($valores as $value => $llave) {
            $dropdown .= "<option value=\"" . $llave[0] . "\">" . $llave[1] . "</option>";
        }
        $dropdown .= "</select>";
        return $dropdown;
    }

    function mostrarMensaje($error, $t = "error") {

        $tipo = array("error" => "pm-error-message", "sucess" => "pm-sucess-message");

        $_SESSION['errores']['mostrar'] = true;
        $_SESSION['errores']['mensaje'] = $error;
        $_SESSION['errores']['estilo'] = $tipo[$t];
    }

}
