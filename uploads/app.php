<?php
    trait getInstance{
        public static $instance;
        public static function getInstance() {
            $arg = func_get_args();
            $arg = array_pop($arg);
            return (!(self::$instance instanceof self) || !empty($arg)) ? self::$instance = new static(...(array) $arg) : self::$instance;
        }
    }
    function autoload($class) {
        // Directorios donde buscar archivos de clases
        $directories = [
            dirname(__DIR__).'/scripts/'
        ];
        // Convertir el nombre de la clase en un nombre de archivo relativo
        $classFile = str_replace('\\', '/', $class) . '.php';
    
        // Recorrer los directorios y buscar el archivo de la clase
        foreach ($directories as $directory) {
            $file = $directory.$classFile;
            var_dump($file);
            // Verificar si el archivo existe y cargarlo
            if (file_exists($file)) {
                require $file;
                break;
            }
        }
    }
    spl_autoload_register('autoload');

    class apiSuperPerrona{
        use getInstance;
        public function __construct(private $_METHOD, public $_HEADER, private $_DATA){
            switch ($_METHOD) {
                case 'POST':
                    info::getInstance($_DATA['info']);
                    break;
            }
        }

    }
    $data = [
        "_METHOD"=>$_SERVER['REQUEST_METHOD'], 
        "_HEADER"=> apache_request_headers(), 
        "_DATA" => json_decode(file_get_contents("php://input"), true)
    ];
    apiSuperPerrona::getInstance($data);

    














    // print_r(tb_user::getInstance()->getUserId(["n_bill" => 1]));
    // print_r(tb_user::getInstance()->getAllUser());
    // print_r(tb_user::getInstance()->deleteUser(["n_bill" => 1]));

    // $data ='{
    //     "n_bill": 1,
    //     "bill_date": "1998-01-01",
    //     "seller": "a",
    //     "identification": 1,
    //     "full_name": "a",
    //     "email": "a@gmail.com",
    //     "address": "a",
    //     "pone": 1
    // }';
    // print_r(tb_user::getInstance()->putUser(json_decode($data,true)));


    



    // $data ='{
    //     "n_bill": 1,
    //     "bill_date": "2023-03-09",
    //     "seller": "Campus",
    //     "identification": 106465,
    //     "full_name": "Miguel Angel Catsro Escamilla",
    //     "email": "ma@gmail.com",
    //     "address": "Calle 11",
    //     "pone": "30455154845"
    // }';
    // print_r(tb_user::getInstance()->postUser(json_decode($data, true)));
    
?>