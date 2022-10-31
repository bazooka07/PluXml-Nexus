<?php
/**
 * NewUserModel
 */

namespace App\Models;

use Psr\Container\ContainerInterface;

class NewUserModel extends Model
{

    private $username;

    private $password;

    private $email;

    private $website;

    private $token;

    private $tokenExpire;

    public function __construct(ContainerInterface $container, array $user)
    {
        parent::__construct($container);

        $this->username = $user['username'];
        $this->userid = $user['userid'];
        # $this->password = self::encryptPassword($user['password']);
        $this->email = $user['email'];
        $this->website = $user['website'];

        $token = parent::generateToken();
        $this->token = $token['token'];
        $this->tokenExpire = $token['expire'];
    }

    /**
     *
     * @return bool
     */
    public function saveNewUser()
    {
        return $this->pdoService->insert("INSERT INTO users SET username = '$this->username', password = '$this->password', email = '$this->email', website = '$this->website', role = '', token = '$this->token', tokenexpire = '$this->tokenExpire'");
    }

    public function updateUser()
    {
        return $this->pdoService->insert("UPDATE users SET email = '$this->email', website = '$this->website' WHERE id = '$this->userid'");
    }
}
