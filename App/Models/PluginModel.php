<?php
/**
 * PluginModel
 */

namespace App\Models;

use Psr\Container\ContainerInterface;

class PluginModel extends Model
{

    public $id;
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
    public $category;
    public $categoryName;
    public $categoryIcon;

    public function __construct(ContainerInterface $container, String $name, int $author)
    {
        parent::__construct($container);

        $pluginsModel = new PluginsModel($container, $author, $name);
        if (count($pluginsModel->plugins) == 1)
        {
            $row = array_values($pluginsModel->plugins)[0];
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
            $this->category = $row['category'];
            $this->categoryName = $row['categoryName'];
            $this->categoryIcon = $row['categoryIcon'];
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
        return $this->pdoService->delete('DELETE FROM plugins WHERE id = '. $this->id . ';');
    }
}
