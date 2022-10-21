<?php

namespace App\Models;

use Psr\Container\ContainerInterface;

/**
 * Class PluginsModel
 * @package App\Models
 */
class PluginsModel extends Model
{

    public $plugins;

    public function __construct(ContainerInterface $container, string $userid = NULL, int $categoryId = NULL)
    {
        parent::__construct($container);

        if (!empty($userid)) {
            $where = "WHERE author='$userid'";
        } else if (!empty($categoryId)) {
            $where = "WHERE category='$categoryId'";
        } else {
            $where = '';
        }

        $this->plugins = $this->pdoService->query('SELECT * FROM plugins ' . $where . ' order by name,date;');
    }
}
