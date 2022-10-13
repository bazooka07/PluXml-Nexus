<?php
/**
 * ThemesModel
 */
namespace App\Models;

use Psr\Container\ContainerInterface;

class ThemesModel extends Model
{

    public $themes;

    public function __construct(ContainerInterface $container, string $userid = NULL)
    {
        parent::__construct($container);

        if (!empty($userid)) {
            $this->themes = $this->pdoService->query("SELECT * FROM themes WHERE author='$userid' order by date,name");
        } else {
            $this->themes = $this->pdoService->query('SELECT * FROM themes order by name');
        }
    }
}
