<?php 
namespace Core\Models;

use Core\Libs\Db;

class Category extends Model{
    
    protected static function getTableName()
    {
        return 'categories';
    }

    public static function getCategoryId($nameCategory)
    {
        $pdo = DB::getInstance();
        $sql = "SELECT id FROM categories WHERE name ='$nameCategory'";
        $category = $pdo->query($sql, [], static::class);
        $category = $category[0]->id;
        return $category;
    }
}