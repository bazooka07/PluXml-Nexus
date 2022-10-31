<?php
/**
 * NewPluginModel
 */
namespace App\Models;

use Psr\Container\ContainerInterface;
use App\Facades\UsersFacade;

class NewPluginModel extends Model
{

    private $name;

    private $description;

    private $author;

    private $date;

    private $version;

    private $pluxml;

    private $link;

    private string $file;

    private int $category;

    public function __construct(ContainerInterface $container, Array $plugin)
    {
        parent::__construct($container);

        $this->id = $plugin['id'];
        $this->name = $plugin['name'];
        $this->description = $plugin['description'];
        $this->author = $plugin['author'];
        $this->date = isset($plugin['date']) ? $plugin['date'] : '';
        $this->version = $plugin['version'];
        $this->pluxml = $plugin['pluxml'];
        $this->link = $plugin['link'];
        if (!empty($plugin['file'])) {
            $this->file = $plugin['file'];
            $this->media = $plugin['media'];
        }
        $this->category = $plugin['category'];
    }

    /**
     *
     * @return bool
     */
    public function saveNewPlugin()
    {
        $description = addslashes($this->description);
        $query = <<< EOT
INSERT INTO plugins(name,description,author,date,version,pluxml,link,file,media,category) VALUES
    ('$this->name', '$description', '$this->author', '$this->date', '$this->version', '$this->pluxml', '$this->link', '$this->file', '$this->media', '$this->category');
EOT;
        return $this->pdoService->insert($query);
    }

    /**
     *
     * @return bool
     */
    public function updatePlugin()
    {
        if (!empty($this->file))
        {
            $extra = <<< EOT

    file='$this->file',
    media='$this->media',
EOT;
        } else {
            $extra = '';
        }
        $description = addslashes($this->description);
        $query = <<< EOT
UPDATE plugins SET
    description = '$description',
    author = '$this->author',
    date = NOW(),
    version = '$this->version',
    pluxml = '$this->pluxml',$extra
    link = '$this->link',
    category = '$this->category'
WHERE id = '$this->id';
EOT;
        return $this->pdoService->insert($query);
    }
}
