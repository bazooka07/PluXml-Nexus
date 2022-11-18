<?php
/**
 * UsersModel
 */
namespace App\Models;

use Psr\Container\ContainerInterface;
use App\Models\UsersFilter;

class UsersModel extends Model
{
    const DELETE_EXPIRE         = <<< EOT
DELETE from users
    WHERE token != ''
    AND tokenexpire < now()
    AND role is NULL;
EOT;
    const EXPIRE_COUNT          = <<< EOT
SELECT count(*) AS cnt
    FROM users
    WHERE token != ''
    AND tokenexpire < now()
    AND role is NULL;
EOT;
    const SELECT_ALL            = <<< EOT
SELECT id,username,email,website,role,token,tokenexpire
    FROM users
    ORDER BY username;
EOT;
    const SELECT_CONTRIBUTORS   = <<< EOT
SELECT id,username,email,website,role
    FROM users
    WHERE
        id IN (SELECT DISTINCT author FROM plugins)
    OR
        id IN (SELECT DISTINCT author FROM themes)
    ORDER BY username;
EOT;
    const SELECT_WITH_PLUGINS =   <<< EOT
SELECT id,username,email,website,role,token,tokenexpire,count(b.id) as plugins
    FROM users a, plugins b
    WHERE users.token ='' AND users.id = b.author
    GROUP BY userid
    ORDER BY name;
EOT;
    const SELECT_WITH_THEMES   = <<< EOT
SELECT id,username,email,website,role,token,tokenexpire,count(b.id) as themes
    FROM users a, yhemes b
    WHERE users.id = b.author
    GROUP BY userid
    ORDER BY name;
EOT;
    # https://dev.mysql.com/doc/refman/8.0/en/join.html
    const SELECT_ITEMS_COUNT    = <<< EOT
SELECT u.id,username,email,website,role,token,tokenexpire,p.plugins_cnt,t.themes_cnt
    FROM users as u
    LEFT JOIN (SELECT author, count(*) AS plugins_cnt FROM plugins group by author) AS p ON u.id=p.author
    LEFT JOIN (SELECT author, count(*) AS themes_cnt FROM themes group by author) AS t ON u.id=t.author
    ORDER BY username;
EOT;

    public $users; # rows from SQL query

    public function __construct(ContainerInterface $container, UsersFilter $filter = UsersFilter::None)
    {
        parent::__construct($container);

        switch($filter) {
            case UsersFilter::HasPlugins: $query = self::SELECT_WITH_PLUGINS; break;
            case UsersFilter::Contributors: $query = self::SELECT_CONTRIBUTORS; break;
            case UsersFilter::HasThemes: $query = self::SELECT_WITH_THEMES; break;
            case UsersFilter::ItemsCount: $query = self::SELECT_ITEMS_COUNT; break;
            case UsersFilter::NoUsers : break;
            default: $query = self::SELECT_ALL;
        }
        $this->users = isset($query) ? $this->pdoService->query($query) : [];
    }

    public function deleteExpire()
    {
        return $this->pdoService->delete(self::DELETE_EXPIRE);
    }

    public function expireCount()
    {
        $rows = $this->pdoService->query(self::EXPIRE_COUNT); # retourne un tableau de 1 rangée !!!!
        return $rows ? $rows[0]['cnt'] : 0;
    }

    public static function confirmEmail(ContainerInterface $container, String $username, String $token)
    {
        $pdoService = $container->get('pdo');

        $query = <<< EOT
UPDATE users SET
    token = NULL,
    tokenexpire = NULL,
    role = 'user'
    WHERE username = '$username'
    AND token = '$token'
    AND tokenexpire > now();
EOT;
        return $pdoService->delete($query);
    }
}