<?php
/**
 * NewThemeModel
 */
namespace App\Models;

use Psr\Container\ContainerInterface;
use App\Facades\UsersFacade;

class NewThemeModel extends Model
{

    private $id;
    private String $name;
    private $description;
    private $author;
    private $date;
    private $version;
    private $pluxml;
    private $link;
    private String $file;
    private String $media;

    public function __construct(ContainerInterface $container, Array $theme)
    {
        parent::__construct($container);

        $this->id = $theme['id'];
        $this->name = $theme['name'];
        $this->description = $theme['description'];
        $this->author = $theme['author'];
        $this->version = $theme['version'];
        $this->pluxml = $theme['pluxml'];
        $this->link = $theme['link'];
        if (!empty($theme['file'])) {
            $this->file = isset($theme['file']) ? $theme['file'] : '';
            $this->media = isset($theme['media']) ? $theme['media'] : '';
        }
    }

    /**
     *
     * @return bool
     */
    public function save()
    {
        $description = addslashes($this->description);
        $query = <<< EOT
INSERT INTO themes(name,description,author,date,version,pluXml,link,file,media)
 VALUES('$this->name', '$description', $this->author, NOW(), '$this->version', '$this->pluxml', '$this->link','$this->file', '$this->media');
EOT;
        return $this->pdoService->insert($query);
    }

    /**
     *
     * @return bool
     */
    public function update()
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
UPDATE themes SET
    description='$description',
    author='$this->author',
    date=NOW(),
    version='$this->version',
    pluxml='$this->pluxml',$extra
    link='$this->link'
WHERE id = $this->id
EOT;
        return $this->pdoService->insert($query);
    }
}
