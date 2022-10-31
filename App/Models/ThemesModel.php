<?php

namespace App\Models;

use Psr\Container\ContainerInterface;

/**
 * Class ThemesModel
 * @package App\Models
 */
class ThemesModel extends Model
{
    private const SELECT_ALL = <<< EOT
SELECT t.id,name,description,author,DATE_FORMAT(date, '%d/%m/%y') as date,version,pluxml,file,link,media,u.username
    FROM themes t
    LEFT JOIN users u ON author=u.id
    ORDER BY name,date desc,username;
EOT;
    public $themes;

    public function __construct(ContainerInterface $container, string $userid = NULL)
    {
        parent::__construct($container);

        if (!empty($userid)) {
            $this->themes = $this->pdoService->query("SELECT * FROM themes WHERE author='$userid' order by date,name");
        } else {
            $this->themes = $this->pdoService->query(self::SELECT_ALL);
        }
    }
}
