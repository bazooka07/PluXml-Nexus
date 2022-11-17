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

    public function __construct(ContainerInterface $container, array $user)
    {
        parent::__construct($container);

        $this->username = $user['username'];
        $this->userid = isset($user['userid']) ? $user['userid'] : '';
        $this->password = isset($user['password']) ? self::encryptPassword($user['password']) : '';
        $this->email = $user['email'];
        $this->website = isset($user['website']) ? $user['website'] : '';
    }

    /**
     *
     * @return bool
     */
    public function saveNewUser()
    {

        $token = parent::generateToken();
        # https://mariadb.com/kb/en/date_add/
        $lifetime = AUTH_SIGNUP_LIFETIME;

        $query = <<< EOT
INSERT INTO users SET
    username = '$this->username',
    password = '$this->password',
    email = '$this->email',
    website = '$this->website',
    token = '$token',
    tokenexpire = DATE_ADD(NOW(), INTERVAL $lifetime HOUR)
EOT;
        return $this->pdoService->insert($query);
    }

    public function updateUser()
    {
        # checks if empty($this->userid) ?
        $query = <<< EOT
UPDATE users SET
    email='$this->email',
    website = '$this->website'
    WHERE id = '$this->userid';
EOT;
        return $this->pdoService->insert($query);
    }
}
