<?php if (!defined('CODEBASE')) { die; }

class general {

    var $cl = NULL;

    function __construct(&$data) {
        $this->cl = & $data;
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
        return '<meta http-equiv="refresh" content="0;URL=\'' . $this->functions->url->returnURL($url) . '\'" />';
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

}
