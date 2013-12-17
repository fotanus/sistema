<?php if (!defined('CODEBASE')) { die; }

class Parsepages extends Config {

    function __contruct() {
        parent::__construct();
        $this->logUse(__FUNCTION__, __FILE__, __LINE__);
    }

    function Init() {
        $this->loadContent();
        $this->detectPath();
    }

    function detectPath() {

        if(isset($_SERVER['HTTPS'])){
            $this->config['use_https'] = ($_SERVER['HTTPS'] ? true : false);
        }
        
        if ($this->config['fullpath'] == "") {
            $this->config['fullpath'] = ($this->config['use_https'] ? "https://" : "http://" ) . $_SERVER['SERVER_NAME'];
            if ($this->config['root'] != "/") {
                $this->config['fullpath'] .= "/" . $this->config['root'];
            }
        }
    }

    function loadContent() {

        $this->config['detected_path'] = $_SERVER['PHP_SELF'];
        $expl = array_filter(explode("/", $_SERVER['PHP_SELF']));
        $this->config['expl'] = $expl;

        $calc = 4;
        $new_array = array();
        for ($a = 1; $a <= count($expl); $a++) {
            if (stripos($expl[$a], ".php") !== false) {
                $calc = $a;
                $this->config['documento'] = $expl[$a];
                if (isset($expl[$a - 1])) {
                    $this->config['root'] = $expl[$a - 1];
                } else {
                    $this->config['root'] = "/";
                }
            } else {
                if ($a > $calc) {
                    $new_array[] = $expl[$a]; // array_push($new_array, $expl[$a]);
                }
            }
        }

        $this->config['niveles'] = array_filter($new_array);
        $this->config['funcion'] = "index"; //initial function

        if (!isset($this->config['niveles'][$this->config['pathlevel']])) {
            /**
             * Default class to start as main controller
             */
            $this->config['page_to_load'] = 'engine/contenidos/controllers/inicio.php'; //File to be loaded
            $this->config['class_to_start'] = "inicio"; // Class to start
        } else {
            $this->config['page_to_load'] = 'engine/contenidos/controllers/' . filter_var($this->config['niveles'][$this->config['pathlevel']], FILTER_SANITIZE_STRING) . '.php';
            $this->config['class_to_start'] = filter_var($this->config['niveles'][$this->config['pathlevel']], FILTER_SANITIZE_STRING);
            if (count($this->config['niveles']) > 1) {
                $this->config['funcion'] = filter_var($this->config['niveles'][$this->config['pathlevel'] + 1], FILTER_SANITIZE_STRING);
                for ($a = 2; $a < count($this->config['niveles']); $a++) {
                    $this->config['vars'][$a] = filter_var($this->config['niveles'][$a], FILTER_SANITIZE_STRING);
                }
            }
        }
        $this->logUse(__FUNCTION__, __FILE__, __LINE__);
    }

    function showContent() {

        $showerror = false;
        if (!is_object($this->controllers)) {
            $this->controllers = new stdClass(); //Create a new stdClass so new objects can be added in runtime
        }
        if ((include $this->config['page_to_load']) === FALSE) {
            $showerror = true;
        } else {
            if (class_exists($this->config['class_to_start'])) {
                if (method_exists($this->config['class_to_start'], $this->config['funcion'])) {

                    $class_to_start = $this->config['class_to_start'];
                    $this->controllers->$class_to_start = new $class_to_start($this);

                    $function_to_start = $this->config['funcion'];
                    $this->controllers->$class_to_start->$function_to_start();
                } else {
                    $showerror = true;
                }
            } else {
                $showerror = true;
            }
        }

        if ($showerror) {//Show error if no controller/view was found in the system
            include 'engine/contenidos/controllers/error404.php';
            $this->controllers->Error404 = new Error404();
            $this->controllers->Error404->index();
            $showerror = false;
        }
        $this->logUse(__FUNCTION__, __FILE__, __LINE__);
    }

    function loadModule($name) {
        $file = "engine/modulos/" . $name . ".php";
        if (!isset($this->config['modulos'][$name])) {
            if ((include $file) === FALSE) {
                
            } else {
                if (class_exists($name)) {
                    $this->config['modulos'][$name] = new $name();
                }
            }
        }
        $this->logUse(__FUNCTION__, __FILE__, __LINE__);
    }

    function loadLibrary($name) {
        if (!is_object($this->libs)) {
            $this->libs = new stdClass();
        }

        $file = "engine/librerias/" . $name . ".php";
        if (!isset($this->config['librerias'][$name])) {
            if ((include $file) === FALSE) {
                echo "No se encontro la libreria";
            } else {
                if (class_exists($name)) {
                    $this->libs->$name = new $name($this);
                }
            }
        }
        $this->logUse(__FUNCTION__, __FILE__, __LINE__);
    }

    function loadFunction($name, $startclass = TRUE) {

        if (!is_object($this->functions)) {
            $this->functions = new stdClass();
        }

        $file = "engine/functions/" . $name . ".php";

        if (!isset($this->config['functions'][$name])) {
            if ((include_once $file) === FALSE) {
                echo "Class not found";
            } else {
                if (class_exists($name) && $startclass) {
                    $this->functions->$name = new $name($this);
                }
            }
        }
        $this->logUse(__FUNCTION__, __FILE__, __LINE__);
    }

    function loadView($page) {

        $contenido = "engine/contenidos/view/" . $page . ".php";
        if ((include $contenido) === FALSE) {
            include 'engine/contenidos/view/404.php';
        } else {
            $this->views[] = $page;
        }
        $this->logUse(__FUNCTION__, __FILE__, __LINE__);
    }

    function load($page) {

        $contenido = "engine/contenidos/view/" . $page . ".php";
        if ((include $contenido) === FALSE) {
            @include 'engine/contenidos/view/404.php';
        }
        $this->logUse(__FUNCTION__, __FILE__, __LINE__);
    }

}
