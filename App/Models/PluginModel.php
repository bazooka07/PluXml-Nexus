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

    public $category;

    public function __construct(ContainerInterface $container, string $name)
    {
        parent::__construct($container);

        $pdo = $this->pdoService->query("SELECT * FROM plugins WHERE name = '$name'");

        if (!empty($pdo)) {
            $this->id = $pdo[0]['id'];
            $this->name = $pdo[0]['name'];
            $this->description = $pdo[0]['description'];
            $this->author = $pdo[0]['author'];
            $this->date = $pdo[0]['date'];
            $this->version = $pdo[0]['version'];
            $this->pluxml = $pdo[0]['pluxml'];
            $this->link = $pdo[0]['link'];
            $this->file = $pdo[0]['file'];
            $this->media = $pdo[0]['media'];
            $this->category = $pdo[0]['category'];
        }
    }

    /**
     *
     * @param ContainerInterface $container
     * @param string $name
     * @return bool
     */
    public function delete(ContainerInterface $container, string $name)
    {
        return $this->pdoService->delete("DELETE FROM plugins WHERE name = '$name'");
    }
}
