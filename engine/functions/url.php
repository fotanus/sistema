<?php if (!defined('CODEBASE')) { die; }

class Url {

    var $cl = NULL;

    function __construct(&$data) {
        $this->cl = & $data;
    }

    function createURL($to, $name) {
        return '<a href="' . $this->config['fullpath'] . '/' . $this->config['documento'] . '/' . $to . '">' . $name . '</a>';
    }

    function returnURL($to = "") {
        if ($to == "") {
            return $this->config['fullpath'] . '/' . $this->config['documento'];
        } else {
            return $this->config['fullpath'] . '/' . $this->config['documento'] . '/' . $to;
        }
    }

    function returnFolfer($to = "") {
        if ($to == "") {
            return $_SERVER['CONTEXT_DOCUMENT_ROOT']."/".$$this->config['root'];
        } else {
            return $_SERVER['CONTEXT_DOCUMENT_ROOT']."/".$$this->config['root'] . '/' . $to;
        }
    }

    function returnPath($to = "") {
        if ($to == "") {
            return $this->cl->config['fullpath'];
        } else {
            return $this->cl->config['fullpath'] . '/' . $to;
        }
    }

    function lastURL() {
        $out = explode('index.php', $_SERVER['HTTP_REFERER']);
        if (substr($out[1], 0, 1) == "/") {
            return substr($out[1], 1);
        } else {
            return $out[1];
        }
    }

}
