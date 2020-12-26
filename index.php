<?php

use Core\Libs\Route;
use Classes\FileHandler;

spl_autoload_register(function($className){
    $className = explode('\\', $className);
    

    for($i=0; $i<=1; $i++){
        $className[$i] = lcfirst($className[$i]);
    }
    $className = implode('/', $className);
    //print_r($className);
    //echo $className.'<br>';
    require_once $className.'.php';
});
use Core\Libs\Exceptions;
use Core\Libs\Exceptions\DbException;
use Core\Libs\Exceptions\NotFoundException;
use Core\Views\View;

try{
    Route::start();
}
catch(DbException $e){
    echo $e->getMessage();
}
catch(NotFoundException $e){
    View::render('errors/404', [], 404);
}

$file1 = new FileHandler('textFile/text.txt');
/*
echo $file1->getPath().'<br>';
echo $file1->getDir().'<br>';
echo $file1->getName().'<br>';
echo $file1->getExt().'<br>';
echo $file1->getSize().'<br>';
echo $str =  $file1->getText();
$file1->setText('new text ');
$file1->appendText('add text');
$file->copy();
//$file1->rename('textFile/textNew');
//$file1->delete();
//$file1->replace('core/');
*/



















// $exception = new Exception('Сообщение', 123);
// throw $exception;

/*
try{
    throw new Exception('Сообщение', 123);
}
catch(Exception $e){
    echo 'Поймано исключение '.$e->getMessage().'. Код:'.$e->getCode();
}
*/

// function f1(){
//     try{
//        f2(); 
//     }
//     catch(Exception $e){
//         echo 'Поймано исключение '.$e->getMessage().'. Код:'.$e->getCode();
//     }
    
// }
// function f2(){
//     f3();
// }
// function f3(){
//     throw new Exception('Сообщение', 123);
//     echo 'cnhjrf yt ds';
// }

// f1();

// DbException
//NotFoundException 

/*try{
    // вызываем метод контроллера, DbException или NotFoundException 

}
catch(DbException $e){
    //обработка ошибки, связанной с БД
} 
catch(NotFoundException $e){
    //обработка ошибки, страница не найдена
}
*/




