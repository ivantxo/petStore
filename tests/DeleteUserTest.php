<?php


namespace App\tests;


use seregazhuk\React\PromiseTesting\TestCase;
use React\Promise\Deferred;
use React\EventLoop\Factory;


class SignUpUserTest extends \PHPUnit\Framework\TestCase
{
    private $loop;

    /**
     * @before
     */
    public function setUpConnector()
    {
        $this->loop = Factory::create();

        $f = new \React\Dns\Resolver\Factory();
        $resolver = $f->create('0.0.0.0', $this->loop);
    }
}
