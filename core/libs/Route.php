<?php
namespace Core\Libs;

use Core\Views\View;

class Route{

    private static $page;
    public static function start()
    {
        self::$page = $_GET['page'] ?? '/';
        $routes = require __DIR__.'/../web.php';

        $isRouteFound = false;//$routes нет совпадений по url
        foreach($routes as $pattern => $controllerAndMethod){
            preg_match('~^'.$pattern.'$~', self::$page, $matches);
            //var_dump($matches);
            if(!empty($matches)){
                $isRouteFound = true;
                break;
            }
        }


        if($isRouteFound){
            list($nameController, $nameMethod) = explode('@', $controllerAndMethod);
            if(file_exists('core/controllers/'.$nameController.'.php')){
                //require 'core/controllers/'.$nameController.'.php';
                $pathController = 'Core\\Controllers\\'.$nameController;
                $controller = new $pathController();
                if(method_exists($controller, $nameMethod)){
                    unset($matches[0]);
                    $controller->$nameMethod(...$matches);
                }else{
                    echo 'Method not found';
                }
            }else{
                echo 'File not found';
            }
        }else{
            View::render('errors/404', [], 404);
        }
    }

    public static function getPage()
    {
        return self::$page;
    }

}
