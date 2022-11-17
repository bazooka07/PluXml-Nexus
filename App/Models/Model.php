<?php
/**
 * Model
 */
namespace App\Models;

use Psr\Container\ContainerInterface;

class Model
{
    private const PATTERN = '0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN';
    private const PATTERN_REPEAT = 3;
    protected const TOKEN_LENGTH = 60;

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
        $max = strlen(self::PATTERN) * self::PATTERN_REPEAT;
        return substr(
            str_shuffle(str_repeat(self::PATTERN, self::PATTERN_REPEAT)),
            mt_rand(0, $max - self::TOKEN_LENGTH),
            self::TOKEN_LENGTH
        );
    }

    /**
     * @encrypted password
     */
    protected function encryptPassword(String $password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}