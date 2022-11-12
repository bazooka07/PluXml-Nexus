<?php
/**
 * UsersModel
 */
namespace App\Models;

use Psr\Container\ContainerInterface;
use App\Models\UsersFilter;

class UsersModel extends Model
{
    const DELETE_EXPIRE         = 'DELETE from users WHERE token != "" AND tokenexpire < now() AND role != \'admin\';';
    const EXPIRE_COUNT          = <<< EOT
SELECT count(*) AS cnt
    FROM users
    WHERE token != "" AND tokenexpire<now() AND role!= 'admin';
EOT;
    const SELECT_ALL            = <<< EOT
SELECT id,username,email,website,role,token,tokenexpire
    FROM users
    ORDER BY username;
EOT;
    const SELECT_CONTRIBUTORS = <<< EOT
SELECT id,username,email,website,role
    FROM users
    WHERE
        id IN (SELECT DISTINCT author FROM plugins)
    OR
        id IN (SELECT DISTINCT author FROM themes)
    ORDER BY username;
EOT;

# select id,username from users where id in (select distinct author from plugins) or id in (select distinct author from themes) order by username;
    const SELECT_WITH_PLUGINS = <<< EOT
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
        $result = $this->pdoService->query(self::DELETE_EXPIRE);
        return $result;
    }

    public function expireCount()
    {
        $rows = $this->pdoService->query(self::EXPIRE_COUNT); # retourne un tableau de 1 rangée !!!!
        return $rows ? $rows[0]['cnt'] : 0;
    }

    public function searchUserWithValidToken(String $username)
    {
        $query = <<< EOT
SELECT id,username,email FROM users
    WHERE username = '$username'
    AND token IS NOT NULL
    AND tokenexpire > NOW();
EOT;
        return $this->pdoService->query($query);
    }

    public function confirmEmail(String $username, String $token)
    {
        $query = <<< EOT
SELECT id FROM users
    WHERE username = '$username'
    and token = '$token'
    and tokenexpire > now();
EOT;
        $result = $this->pdoService->query($query);
        if (count($result) !== 1) {
            return false;
        }

        $id = array_values($result)['id'];
        $query = <<< EOT
UPDATE users SET
    token = NULL,
    tokenexpire = NULL,
    role = 'user'
    WHERE id = $id;
EOT;
        $result = $this->pdoService->query($query);
        return true;
    }
}