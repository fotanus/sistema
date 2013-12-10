<?php

if (!isset($config['fullpath'])) {
    die;
}

if (true == false) {
    include_once("../functions/mysql.php");
}

if(!isset($out)){
    $config['functions']['parsepages']->loadFunction('mysql', FALSE);
}

class lb_noticiasyeventos extends MySQL {

    public $showJS = false;
    
    function __construct() {
        parent::__construct();
    }

    function __destruct() {
        parent::__destruct();
    }

    function nueva($id, $titulo, $desc, $imagen) {

        if (!empty($titulo) && trim($titulo) != "") {
            $insert['Titulo'] = parent::SQLValue($titulo);
        }

        if (!empty($desc) && trim($desc) != "") {
            $insert['Descripcion'] = parent::SQLValue($desc);
        }

        if (!empty($imagen) && trim($imagen) != "") {
            $insert['Imagen'] = parent::SQLValue($imagen);
        }

        if (empty($id) && trim($id) === "") {
            $where['Noticiasyeventos_Id'] = -1;
        } else {
            $where['Noticiasyeventos_Id'] = parent::SQLValue($id);
        }

        $insert['Owner'] = $_SESSION['sesion']['usuario']['Owner'];

        $result = parent::AutoInsertUpdate("noticiasyeventos", $insert, $where);

        return $result;
    }

    function listar() {
        $sql = "SELECT Noticiasyeventos_Id 'Id', Titulo, Descripcion, Imagen, Creado 'Creado o Modificado' FROM noticiasyeventos WHERE Owner = " . $_SESSION['sesion']['usuario']['Owner'] . " ";
        $sql .= " ORDER BY Creado DESC";
        parent::QueryArray($sql);
        return parent::GetHTML(false, 'table-layout:auto;');
    }
    
    function showMobile($Owner){
        $sql = "SELECT Titulo, Descripcion, Imagen FROM noticiasyeventos WHERE Owner = " . parent::SQLValue($Owner) . " ";
        $sql .= " ORDER BY Creado DESC";
        $sql .= " LIMIT 5 ";
        
        $result = parent::QueryArray($sql);
        
        $html = "";

        foreach($result as $value){
            $html .= "<div class=\"mo-noticias\">";
            $html .= "<div class=\"mo-noticias-titulo\">".$value['Titulo']."<span style=\"float:right;font-size:10px;\">(Clic para abrir)</span></div>";
            $html .= "<div class=\"mo-noticias-decripcion\">";
            $html .= "<img src=\"img/nye/thumb/".$value['Imagen']."\" alt=\"\">";
            $html .= $value['Descripcion'];
            $html .= "</div>";
            $html .= "</div>";
        }
        echo $html;
    }

    function showComplete($Owner) {
        
        $sql = "SELECT Titulo, Descripcion, Imagen FROM noticiasyeventos WHERE Owner = " . parent::SQLValue($Owner) . " ";
        $sql .= " ORDER BY Creado DESC";
        $sql .= " LIMIT 5 ";

        $result = parent::QueryArray($sql);

        $html = "";
        
        foreach ($result as $value) {
            $html .= "<div>";
            $html .= "<img src=\"img/nye/".$value['Imagen']."\" width=\"\" height=\"\" alt=\"\"/>";
            $html .= "<span class=\"titulo\">".$value['Titulo']."</span>";
            $html .= "<span class=\"descripcion\">".$value['Descripcion']."</span>";
            $html .= "</div>";
        }
        
        echo $html;
        $this->showJS = true;
    }
}
