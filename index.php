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




Route::start();

echo '<hr>';
echo '<hr>';

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





