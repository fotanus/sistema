<?php if (!defined('CODEBASE')) { die; }

class lb_galeria {

    private $thumb_path = "img/nye/thumb/";
    private $folder = "";
    private $isdir = false;
    private $img_array = array();
    private $num_images = 0;

    var $cl = NULL;

    function __construct(&$data) {
        
        $this->cl = & $data;
        
        $this->folder = $this->cl->functions->url->returnFolfer($this->thumb_path);

        $this->isdir = is_dir($this->folder);
        $this->readDir();
    }

    private function readDir() {
        if ($this->isdir) {
            if ($dh = opendir($this->folder)) {
                while (($file = readdir($dh)) !== false) {
                    $filename = $this->folder . $file;
                    if (!is_dir($filename)) {
                        $data = getimagesize($filename);
                        if ($data != FALSE) {
                            $data[] = $file;
                            $this->img_array[$file] = $data;
                            $this->num_images++;
                        }
                    }
                }
            }
        }
    }

    public function GetHTML($start = 0) {
        
        $num_columnas = explode(".", $this->num_images / 4);
        $filas = (ceil($this->num_images / 4) > 3 ? 3 : ceil($this->num_images / 4));

        $llaves = array_keys($this->img_array);
        $html = "<div class=\"container_12 fk-galeria\">";
        $html .= "<div class=\"grid_12\" style=\"color:#FFF;text-align:center;\"><h2>Galería de Imagenes</h2></div>";
        if(!$this->isdir){
            $html .= "<div class=\"grid_12\" style=\"color:#FFF;text-align:center;\">No se encontro el directorio.</div>";
        }
        $count = 0;
        for ($a = 0; $a < $filas; $a++) {
            $html .= "<div class=\"grid_12\">";
            for ($b = 0; $b < 4; $b++) {
                $wandh = @$this->img_array[$llaves[$start]][3];
                $filename = @$this->img_array[$llaves[$start]][4];
                if (!empty($filename)) {
                    $html .= "<div class=\"grid_3 " . ($count == 0 ? 'alpha' : ($count == 3 ? 'omega' : '')) . "\"><div>";
                    $html .= "<img src=\"" . $this->cl->functions->url->returnPath($this->thumb_path . $filename) . "\" " . $wandh . " alt=\"$filename\"/>";
                    $html .= "</div></div>";
                }
                $start++;
                $count++;
            }
            $count = 0;
            $html .= "</div>";
        }
        if ($start > 0) {
            $html .= "<div class=\"grid_12\" style=\"color:#FFF;\">";
            $html .= "<div class=\"grid_1\"><input type=\"hidden\" value=\"".($start - ($start <= 12 ? $start : 12 ))."\" id=\"galAnterior\"><a href=\"#\" id=\"clicAnterior\">Anterior</a></div>";
            $html .= "<div class=\"grid_1\" style=\"float:right;\"><input type=\"hidden\" value=\"".($start + ($start <= 12 ? -$start : 1 ))."\" id=\"galSiguiente\"><a href=\"#\" id=\"clicSiguiente\">Siguiente</a></div>";
            $html .= "</div>";
        }
        $html .= "</div>";
        return $html;
    }

}
