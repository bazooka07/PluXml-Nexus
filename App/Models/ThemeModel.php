<?php
/**
 * ThemeModel
 */
namespace App\Models;

use Psr\Container\ContainerInterface;

class ThemeModel extends Model
{

    public $name;
    public $description;
    public $author;
    public $date;
    public $version;
    public $pluxml;
    public $link;
    public $file;
    public $media;
    public $username;

    public function __construct(ContainerInterface $container, String $name, int $author)
    {
        parent::__construct($container);

        $themesModel = new ThemesModel($container, $author, $name);
        if (count($themesModel->themes) == 1)
        {
            $row = array_values($themesModel->themes)[0];
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->description = $row['description'];
            $this->author = $row['author'];
            $this->date = $row['date'];
            $this->version = $row['version'];
            $this->pluxml = $row['pluxml'];
            $this->link = $row['link'];
            $this->file = $row['file'];
            $this->media = $row['media'];
            $this->username = $row['username'];
        }
    }

    public function delete()
    {
        foreach(array($this->file, $this->media) as $f) {
            if(!empty($f)) {
                $filename = PUBLIC_DIR . $f;
                if(file_exists($filename)) {
                    unlink($filename);
                }
            }
        }
        return ($this->pdoService->delete('DELETE FROM themes WHERE id = '. $this->id . ';') == 1);
    }
}
