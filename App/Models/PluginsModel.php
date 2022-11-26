<?php

namespace App\Models;

use Psr\Container\ContainerInterface;

/**
 * Class PluginsModel
 * @package App\Models
 */
class PluginsModel extends Model
{
    private const SELECT = <<< EOT
SELECT a.id,a.name,description,author,DATE_FORMAT(date, '%d/%m/%y') as date,version,pluxml,file,link,media,downloads,u.username,category,c.name as categoryName,c.icon as categoryIcon
    FROM plugins a
    LEFT JOIN users u ON author=u.id
    LEFT JOIN categories c on a.category=c.id
    ##WHERE##
    ORDER BY name,date desc,username;
EOT;

    public $plugins;

    public function __construct(ContainerInterface $container, int $author=NULL, String $name=NULL, String $categoryName=NULL)
    {
        parent::__construct($container);

        if (!empty($author)) {
            # every plugin from this author
            $where = "WHERE a.author='$author'";
            if(!empty($name)) {
                # just one plugin from this author and this name of plugin
                $where .= " AND a.name='$name'";
            }
        } else if (!empty($categoryName)) {
            $where = "WHERE c.name='$categoryName'";
        } else {
            $where = '';
        }

        $this->plugins = $this->pdoService->query(str_replace('##WHERE##', $where, self::SELECT));

        # vérifier que les fichiers pour media et file existent
        foreach($this->plugins as $i=>$item) {
            foreach(array('file', 'media') as $f) {
                if(!file_exists(PUBLIC_DIR . $item[$f])) {
                    $this->plugins[$i][$f] = '';
                }
            }
        }
    }
}
