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

    public function __construct(ContainerInterface $container, String $id, String $password='', bool $validToken=false)
    {
        parent::__construct($container);

        if(strlen($id) == self::TOKEN_LENGTH and empty($password)) {
            $confirmToken = true;
            $query = <<< EOT
SELECT id,username,email
    FROM users
    WHERE token='$id'
    AND tokenexpire > now();
EOT;
        } else {
            $selector = is_numeric($id) ? 'id' : 'username';
            $where = $validToken ? '(token IS NOT NULL AND tokenexpire > now())' : 'token is null';
            $query = <<< EOT
SELECT id,username,password,email,website,role,lastconnected,token
    FROM users
    WHERE $where
    AND $selector = '$id';
EOT;
        }

        $pdo = $this->pdoService->query($query);

        if (
            count($pdo) === 1 and
            (empty($password) or password_verify($password, $pdo[0]['password']))
        ) {
            $this->id = $pdo[0]['id'];
            $this->username = $pdo[0]['username'];
            $this->email = $pdo[0]['email'];
            if(empty($confirmToken)) {
                $this->website = $pdo[0]['website'];
                $this->role = $pdo[0]['role'];
                $this->lastconnected = $pdo[0]['lastconnected'];
                $this->updateLastConnected();
                # For confirmation by e-mail
                $this->token = $validToken ? $pdo[0]['token'] : '';
            }
        } else {
            throw new \Exception(_['FAILURE_USER'] . ' : ' . (DEBUG ? $query : $id));
        }
    }

    public function editUser(bool $newToken=false)
    {
        if($newToken === true) {
            # For resetting password
            $this->token = $this->generateToken();
            $lifetime = AUTH_SIGNUP_LIFETIME;
            $query = <<< EOT
UPDATE users SET
    token = '$this->token',
    tokenexpire = DATE_ADD(NOW(), INTERVAL $lifetime HOUR)
    WHERE id = '$this->id';
EOT;
        } elseif(!empty($this->password)) {
            # Update password
            $encryptPassword = password_hash($this->password, PASSWORD_BCRYPT);
            $query = <<< EOT
UPDATE users SET
    password = '$encryptPassword',
    token = NULL,
    tokenexpire = NULL
    WHERE id = '$this->id';
EOT;
        } else {
            $query = <<< EOT
UPDATE users SET
    email = '$this->email',
    website = '$this->website'
    WHERE id = '$this->id';
EOT;
            }
        return $this->pdoService->insert($query);
    }

    private function updateLastConnected()
    {
        $query = <<< EOT
UPDATE users SET
    lastconnected = NOW()
    WHERE id = '$this->id';
EOT;
        return $this->pdoService->insert($query);
    }
}