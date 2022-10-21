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

    public $versionTheme;

    public $versionPluxml;

    public $link;

    public $file;

    public function __construct(ContainerInterface $container, String $name)
    {
        parent::__construct($container);

        $pdo = $this->pdoService->query("SELECT * FROM themes WHERE name = '$name'");

        if (!empty($pdo))
        {
            $this->name = $pdo[0]['name'];
            $this->description = $pdo[0]['description'];
            $this->author = $pdo[0]['author'];
            $this->date = $pdo[0]['date'];
            $this->versionTheme = $pdo[0]['versiontheme'];
            $this->versionPluxml = $pdo[0]['versionpluxml'];
            $this->link = $pdo[0]['link'];
            $this->file = $pdo[0]['file'];
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
        return $this->pdoService->delete("DELETE FROM themes WHERE name = '$name'");
    }
}