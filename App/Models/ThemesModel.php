<?php

namespace App\Models;

use Psr\Container\ContainerInterface;

/**
 * Class ThemesModel
 * @package App\Models
 */
class ThemesModel extends Model
{
    private const SELECT = <<< EOT
SELECT a.id,a.name,description,author,DATE_FORMAT(date, '%d/%m/%y') as date,version,pluxml,file,link,media,downloads,u.username
    FROM themes a
    LEFT JOIN users u ON author=u.id
    ##WHERE##
    ORDER BY name,date desc,username;
EOT;
    public $themes;

    public function __construct(ContainerInterface $container, int $author=NULL, String $name=NULL)
    {
        parent::__construct($container);

        if (!empty($author)) {
            # every theme from this author
            $where = "WHERE author='$author'";
            if(!empty($name)) {
                # just one theme from this author and this name of theme
                $where .= " AND a.name='$name'";
            }
        } else {
            $where = '';
        }

        $this->themes = $this->pdoService->query(str_replace('##WHERE##', $where, self::SELECT));
    }
}
