<?php

namespace App\Models;

use Psr\Container\ContainerInterface;

class CategoriesModel extends Model
{

    private const USED_CATEGORIES = <<< EOT
SELECT category, count(*), c.name FROM plugins p
    LEFT JOIN categories c ON p.category=c.id
    GROUP BY category
    ORDER BY c.name;
EOT;
    private const ALL_CATEGORIES = <<< EOT
SELECT
    FROM CATEGORIES;
EOT;
    public $categories;

    public function __construct(ContainerInterface $container, bool $all=false)
    {
        parent::__construct($container);

        $this->categories = $this->pdoService->query($all ? self::ALL_CATEGORIES : self::USED_CATEGORIES);
    }
}