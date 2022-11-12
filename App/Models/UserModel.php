<?php
/**
 * UserModel
 */
namespace App\Models;

use Psr\Container\ContainerInterface;

class UserModel extends Model
{

    public $id;
    public $username;
    public $email;
    public $website;
    public $role;
    public $token;
    public $tokenExpire;

    public function __construct(ContainerInterface $container, String $id, String $password='')
    {
        parent::__construct($container);

        $selector = empty($password) ? 'id' : 'username';
        $query = <<< EOT
    SELECT id,username,password,email,website,role,lastconnected
        FROM users
        WHERE (token IS NULL OR token = '')
        AND $selector = '$id';
    EOT;

        $pdo = $this->pdoService->query($query);

        if (
            count($pdo) === 1 and
            (empty($password) or password_verify($password, $pdo[0]['password']))
        ) {
            $this->id = $pdo[0]['id'];
            $this->username = $pdo[0]['username'];
            $this->email = $pdo[0]['email'];
            $this->website = $pdo[0]['website'];
            $this->role = $pdo[0]['role'];
            $this->lastconnected = $pdo[0]['lastconnected'];
            $this->updateLastConnected();
        } else {
            throw new \Exception('Failure User : ' . (DEBUG ? $query : $id));
        }
    }

    public function editUser()
    {
        $query = <<< EOT
UPDATE users SET
    email = '$this->email',
    website = '$this->website',
    WHERE id = '$this->id';
EOT;
        return $this->pdoService->insert($query);
    }

    private function updateLastConnected()
    {
        $query = <<< EOT
UPDATE users SET
    lastconnected = now()
    WHERE id = '$this->id';
EOT;
        return $this->pdoService->insert($query);
    }

    public function delete()
    {
        return $this->pdoService->delete("DELETE FROM users WHERE id = '$this->id'");
    }
}