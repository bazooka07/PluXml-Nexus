<?php

namespace App\Models;

use Psr\Container\ContainerInterface;

class CategoriesModel extends Model
{

    private const USED_CATEGORIES = <<< EOT
SELECT c.id, count(*) as cnt, c.name FROM plugins p
    LEFT JOIN categories c ON p.category=c.id
    ##WHERE##
    GROUP BY category
    ORDER BY c.name;
EOT;
    private const ALL_CATEGORIES = <<< EOT
SELECT id, name
    FROM categories;
EOT;

    public $categories;

    public function __construct(ContainerInterface $container, bool $all=false, int $userid=null)
    {
        parent::__construct($container);

        if($all) {
            $query = self::ALL_CATEGORIES;
        } elseif(empty($userid)) {
            $query = str_replace('##WHERE##', '', self::USED_CATEGORIES);
        } else {
            $query = str_replace('##WHERE##', "where p.author=$userid", self::USED_CATEGORIES);
        }
        $this->categories = $this->pdoService->query($query);
    }
}