<?php
/**
 * Model
 */
namespace App\Models;

use Psr\Container\ContainerInterface;

class Model
{
    protected $pdoService;

    private ContainerInterface $container;

    private const TOKEN_LENGH = 60;

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
        $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";

        $token['token'] = substr(str_shuffle(str_repeat($alphabet, self::TOKEN_LENGH)), 0, self::TOKEN_LENGH);
        $token['expire'] = date('Y-m-d H:i:s', mktime(date('H') + AUTH_SIGNUP_LIFETIME, date('i'), date('s'), date('m'), date('d'), date('Y')));

        return $token;
    }
}