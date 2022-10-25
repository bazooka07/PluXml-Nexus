<?php
/**
 * NewThemeModel
 */
namespace App\Models;

use Psr\Container\ContainerInterface;
use App\Facades\UsersFacade;

class NewThemeModel extends Model
{

    private $name;

    private $description;

    private $author;

    private $date;

    private $versionTheme;

    private $versionPluxml;

    private $link;

    private string $file;

    public function __construct(ContainerInterface $container, Array $plugin)
    {
        parent::__construct($container);

        $UserModel = UsersFacade::searchUser($container, $plugin['author']);

        $this->name = $plugin['name'];
        $this->description = $plugin['description'];
        $this->author = $UserModel->id;
        $this->date = date('Y-m-d H:i:s');
        $this->versionTheme = $plugin['versionTheme'];
        $this->versionPluxml = $plugin['versionPluxml'];
        $this->link = $plugin['link'];
        $this->file = DIR_THEMES . DIRECTORY_SEPARATOR . $plugin['name'] . '.zip';
    }

    /**
     *
     * @return bool
     */
    public function saveNewTheme()
    {
        return $this->pdoService->insert("INSERT INTO themes SET name = '$this->name', description = '$this->description', author = '$this->author', date = '$this->date', versionTheme = '$this->versionTheme', versionPluxml = '$this->versionPluxml', link = '$this->link', file= '$this->file'");
    }

    /**
     *
     * @return bool
     */
    public function updateTheme()
    {
        return $this->pdoService->insert("UPDATE themes SET description = '$this->description', author = '$this->author', date = '$this->date', versionTheme = '$this->versionTheme', versionPluxml = '$this->versionPluxml', link = '$this->link', file= '$this->file' WHERE name = '$this->name'");
    }
}

