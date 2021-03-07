<?php 
namespace Core\Models;

use Core\Libs\Db;

class Product extends Model{
    
    protected static function getTableName()
    {
        return 'products';
    }
    public function getCategory()
    {
        return Product::getById($this->category_id);
    }

    public static function getProductId($sku)
    {
        $pdo = DB::getInstance();
        $sql = "SELECT id FROM products WHERE sku ='$sku'";
        //echo $sql;
        $product = $pdo->query($sql, [], static::class);
        $id = $product[0]->id;
        return $id;
    }
}