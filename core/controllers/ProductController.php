<?php 
namespace Core\Controllers;


use Core\Views\View;
use Core\Models\Article;
use Core\Models\User;
use Core\Libs\Exceptions\NotFoundException;
use Core\Models\Category;
use Core\Models\Product;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Core\Libs\Db;

class ProductController extends Controller{

    public function import()
    {
        View::render('main/import');
    }

    public function importFile(){
        $fileName = $_FILES['uploadFile'];
        //print_r($fileName);
        if(!file_exists('uplouds')){
            mkdir('uplouds');
        }
        else{
            move_uploaded_file($fileName['tmp_name'], 'uplouds/'.$fileName);
        }
        
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(TRUE);
        $spreadsheet = $reader->load('uplouds/'.$fileName);
        $worksheet = $spreadsheet->getActiveSheet();

        $len = $worksheet->getHighestRow();
        $width = $worksheet->getHighestColumn();
        //echo $width;
       
        $names=[];
        for($i=2; $i < $len; $i++ ){
            array_push($names, $worksheet->getCell("A{$i}")->getValue()) ;
        }
        $description=[];
        for($i=2; $i < $len; $i++ ){
            array_push($description, $worksheet->getCell("B{$i}")->getValue()) ;
        }
        $price =[];
        for($i=2; $i < $len; $i++ ){
            array_push($price, $worksheet->getCell("C{$i}")->getValue()) ;
        }
        $sku =[];
        for($i=2; $i < $len; $i++ ){
            array_push($sku, $worksheet->getCell("D{$i}")->getValue()) ;
        }
        $categories =[];
        for($i=2; $i < $len; $i++ ){
            array_push($categories, $worksheet->getCell("E{$i}")->getValue()) ;
        } 
        $categoriesList =[];
        for($i=2; $i < $len; $i++ ){
            $val = $worksheet->getCell("E{$i}")->getValue();
            if( in_array($val, $categoriesList) ){
                continue;
            }
            else{
                array_push($categoriesList, $worksheet->getCell("E{$i}")->getValue()) ;
            }
        } 
        $this->importCategories($categoriesList);
        $result = $this->importProduct($names, $description, $price, $sku, $categories);
        // $_SESSION['resultUpdate'] = "<script>alert('Добавлено $result[0] товаров, обновлено $result[1] товаров.')</script";
        // echo $_SESSION['resultUpdate'];
        $this->redirect('/');
        //View::render('main/index', compact($result));
        //echo "<script>alert('Добавлено $result[0] товаров, обновлено $result[1] товаров.')</script";
    } 

    public function importCategories($categoriesList)
    {
        $addCategories = 0;
        $categories = Category::findAll();
        $categoriesOld = [];
        foreach($categories as $category){
            array_push($categoriesOld, $category->name);
            
        }
        //print_r($categoriesOld);
        //print_r($categoriesList);
        for ($i=0; $i < count($categoriesList); $i++) { 
            if(in_array($categoriesList[$i], $categoriesOld)){
                continue;
            }else{
                $category = new Category;
                $category->name = $categoriesList[$i];
                $category->save();
                $addCategories++;
            }
        }
    }

    public function importProduct($names, $description, $price, $sku, $categories)
    {
        $addProducts = 0;
        $updaitProducts = 0;
        $pdo = DB::getInstance();
        $products = Product::findAll();
        $productOldSku = [];
        foreach($products as $product){
            array_push($productOldSku, $product->sku);
        }
        //print_r($products);
        //print_r($sku);
        for ($i=0; $i < count($sku); $i++) { 
            $category = Category::getCategoryID($categories[$i]);
            if(in_array($sku[$i], $productOldSku)){
                $id = Product::getProductId($sku[$i]);
                $product = Product::getById($id);
                $product->name = $names[$i];
                $product->description = $description[$i];
                $product->price = $price[$i];
                $product->category_id = $category;
                $product->save();
                $updaitProducts++;
            }else{
                $product = new Product;
                $product->name = $names[$i];
                $product->description = $description[$i];
                $product->price = $price[$i];
                $product->sku = $sku[$i];
                $product->category_id = $category;
                $product->save();
                $addProducts++;
            }
        }
        $result = [$addProducts, $updaitProducts];
        return $result;
    }
   
}


