<?php 
namespace Classes;


class FileHandler implements iFile
{
    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }
		
    public function getPath() // путь к файлу
    {
        return $this->filePath;       
    }
    public function getDir()  // папка файла
    {
        $path = $this->filePath;
        $path = explode('/', $path);
        $dir = $path[0];
        return $dir;
    }
    public function getName() // имя файла
    {
        $path = $this->filePath;
        $path = explode('/', $path);
        $path = explode('.', $path[1]);
        $name = $path[0];
        return $name;
    }
    public function getExt()  // расширение файла
    {
        $path = $this->filePath;
        $path = explode('/', $path);
        $path = explode('.', $path[1]);
        $ext = $path[1];
        return $ext;
    }
    public function getSize() // размер файла
    {
        $size = filesize($this->filePath);
        return $size;
    }
    public function getText()          // получает текст файла
    {
        $text = file_get_contents($this->filePath);
        return $text;
    }
    public function setText($text)     // устанавливает текст файла
    {
        file_put_contents($this->filePath, $text);
    }
	public function appendText($text)  // добавляет текст в конец файла
	{
        file_put_contents($this->filePath, $text, FILE_APPEND);
    }
    public function copy($copyPath)    // копирует файл
    {
        copy($this->filePath, $copyPath);
    }
    public function delete()           // удаляет файл
    {
        unlink($this->filePath);
    }
    public function rename($newName)   // переименовывает файл
    {
        rename($this->filePath ,$newName);
    }
    public function replace($newPath)  // перемещает файл
    {
        rename($this->filePath ,$newPath.$this->getName());
    }
}