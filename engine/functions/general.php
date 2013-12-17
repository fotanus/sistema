<?php if (!defined('CODEBASE')) { die; }

class general {
    
    const SQLVALUE_BIT = "bit";
    const SQLVALUE_BOOLEAN = "boolean";
    const SQLVALUE_DATE = "date";
    const SQLVALUE_DATETIME = "datetime";
    const SQLVALUE_NUMBER = "number";
    const SQLVALUE_T_F = "t-f";
    const SQLVALUE_TEXT = "text";
    const SQLVALUE_TIME = "time";
    const SQLVALUE_Y_N = "y-n";

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
        return '<meta http-equiv="refresh" content="0;URL=\'' . $this->cl->functions->url->returnURL($url) . '\'" />';
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
    
    static public function SQLValue($value, $datatype = self::SQLVALUE_TEXT) {
        $return_value = "";

        switch (strtolower(trim($datatype))) {
            case "text":
            case "string":
            case "varchar":
            case "char":
                if (strlen($value) == 0) {
                    $return_value = "NULL";
                } else {
                    if (get_magic_quotes_gpc()) {
                        $value = stripslashes($value);
                    }
                    $return_value = "'" . str_replace("'", "''", $value) . "'";
                }
                break;
            case "number":
            case "integer":
            case "int":
            case "double":
            case "float":
                if (is_numeric($value)) {
                    $return_value = $value;
                } else {
                    $return_value = "NULL";
                }
                break;
            case "boolean":  //boolean to use this with a bit field
            case "bool":
            case "bit":
                if (self::GetBooleanValue($value)) {
                    $return_value = "1";
                } else {
                    $return_value = "0";
                }
                break;
            case "y-n":  //boolean to use this with a char(1) field
                if (self::GetBooleanValue($value)) {
                    $return_value = "'Y'";
                } else {
                    $return_value = "'N'";
                }
                break;
            case "t-f":  //boolean to use this with a char(1) field
                if (self::GetBooleanValue($value)) {
                    $return_value = "'T'";
                } else {
                    $return_value = "'F'";
                }
                break;
            case "date":
                if (self::IsDate($value)) {
                    $return_value = "'" . date('Y-m-d', strtotime($value)) . "'";
                } else {
                    $return_value = "NULL";
                }
                break;
            case "datetime":
                if (self::IsDate($value)) {
                    $return_value = "'" . date('Y-m-d H:i:s', strtotime($value)) . "'";
                } else {
                    $return_value = "NULL";
                }
                break;
            case "time":
                if (self::IsDate($value)) {
                    $return_value = "'" . date('H:i:s', strtotime($value)) . "'";
                } else {
                    $return_value = "NULL";
                }
                break;
            default:
                exit("ERROR: Invalid data type specified in SQLValue method");
        }
        return $return_value;
    }
}
