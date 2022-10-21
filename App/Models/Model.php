<?php
/**
 * Model
 */
namespace App\Models;

use Psr\Container\ContainerInterface;

class Model
{
    private const PATTERN = '0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN';
    private const TOKEN_LENGTH = 60;

    protected $pdoService;

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->pdoService = $this->container->get('pdo');
    }

    /**
     *
     * @return array keys are 'token' and 'expire'
     */
    public function generateToken()
    {

        return [
            'token'  => substr(str_shuffle(str_repeat(self::PATTERN, self::TOKEN_LENGTH)), 0, self::TOKEN_LENGTH),
            'expire' => date('Y-m-d H:i:s', time() + AUTH_SIGNUP_LIFETIME * 3600),
        ];
    }

    /**
     * @encrypted password
     */
    protected function encryptPassword(String $password) 
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}