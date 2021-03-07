<?php
namespace Core\Models;

use Core\Libs\Db;

abstract class Model{
    
    public static function findAll()
    {
        $pdo = Db::getInstance();
        return $pdo->query('SELECT * FROM '.static::getTableName(), [], static::class);//позднее статическое связывание

    }

    public static function getById($id)
    {
        $pdo = Db::getInstance();
        $result = $pdo->query('SELECT * FROM '.static::getTableName().' WHERE id=:id', ['id'=>$id], static::class);//позднее статическое связывание
        return $result ? $result[0] : null;
    }

    private function propertiesToDb()
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();
        $props = [];
        foreach($properties as $property){
            $propertyName = $property->getName();
            $props[$propertyName] = $this->$propertyName;
        }
        return $props;
    }

    public function save()
    {
        $properties = $this->propertiesToDb();
        //echo '<pre>'.print_r($properties, true).'</pre>';
        if($this->id !== null){
            $this->update($properties);
        }
        else{
            $this->insert($properties);
        }
    }

    private function update(array $properties)
    {
        $columns = [];
        foreach($properties as $column=>$value){
            $columns[] = $column.'=:'.$column;
        }
        //echo '<pre>'.print_r($columns, true).'</pre>';
        $pdo = DB::getInstance();
        $sql = 'UPDATE '.static::getTableName().' SET '.implode(', ', $columns).' WHERE id=:id';
        $pdo->query($sql, $properties, static::class);


    }

    private function insert(array $properties)
    {
        //echo '<pre>'.print_r($properties, true).'</pre>';
        //echo var_dump($properties);
        $columns = [];
        $values = [];
        foreach($properties as $column=>$value){
            $columns[] = $column;
            $values[]= $value;
        }
        //echo '<pre>'.print_r($columns, true).'</pre>';
        //echo '<pre>'.print_r($values, true).'</pre>';
        $values = implode("', '", $values);
        $pdo = DB::getInstance();
        $sql = "INSERT INTO ".static::getTableName()." (".implode(', ', $columns).") VALUES ('".$values."')";
        //echo $sql;
        $pdo->query($sql, [], static::class);
    }

    
    public function delete()
    {
        $pdo = DB::getInstance();
        $sql = 'DELETE FROM '.static::getTableName().' WHERE id='.$this->id;
        $pdo->query($sql, [], static::class );  
    }


    abstract protected static function getTableName();
  
}