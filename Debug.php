<?php

class Custom_Debug{

    public static function dump($obj, $exit = true){
        echo '<pre>';
        print_r($obj);
        echo '</pre>';

        if ($exit){
            die;
        }
    }

    public static function showClassMethodsAndParams($objClass, $exit = true){
        $methods = get_class_methods($objClass);

        if (!count($methods)){
            echo 'Não foi possível obter os métodos desta class / objeto';
        }

        foreach ($methods as $method){
            $reflectionMethod = new ReflectionMethod($objClass, $method);

            $params = $reflectionMethod->getParameters();

            if (count($params) > 0){

                $string = $method.'(';

                foreach ($params as $key => $param){

                    if ($key == count($params)-1){
                        $string .= $param->name.')';
                    }else{
                        $string .= $param->name.',';
                    }
                }
            }else{
                $string = $method.'()';
            }


            echo $string.'<br>';
            unset($string);
            unset($params);
            unset($reflectionMethod);
        }

        if ($exit){
            die;
        }
    }

}

?>