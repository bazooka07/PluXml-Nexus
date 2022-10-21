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

    # public $password;

    public $email;

    public $website;

    public $role;

    public $token;

    public $tokenExpire;

    public function __construct(ContainerInterface $container, String $id, String $password='')
    {
        parent::__construct($container);

        $query = "SELECT id,username,email,website,role,password,token,tokenexpire FROM users WHERE token='' and " . (empty($password) ? 'id' : 'username') . "='$id';";
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
            $this->token = $pdo[0]['token'];
            $this->tokenExpire = $pdo[0]['tokenexpire'];
        } else {
            throw new \Exception('Failure User : ' . $query);
        }
    }

    public function editUser()
    {
        return $this->pdoService->insert("UPDATE users SET username = '$this->username', password = '$this->password', email = '$this->email', website = '$this->website', role = '$this->role', token = '$this->token', tokenexpire = '$this->tokenExpire' WHERE id = '$this->id'");
    }

    public function delete()
    {
        return $this->pdoService->delete("DELETE FROM users WHERE id = '$this->id'");
    }
}