<?php
namespace Hakaczu\Przelewy24PhpSdk;
use PHPUnit\Framework\TestCase;
include './config/env.php';
final class AuthTest extends TestCase {

    public function testClassConstructor(){
        $auth = new Auth(
            $_ENV['urlAuth'],
            $_ENV['username'],
            $_ENV['password']
        );
        
        $this->assertSame($_ENV['urlAuth'], $auth->url);
        $this->assertSame($_ENV['username'], $auth->username);
        $this->assertSame($_ENV['password'], $auth->password);
    }

    public function testConnectionToApi(){
        $auth = new Auth(
            $_ENV['urlAuth'],
            $_ENV['username'],
            $_ENV['password']
        );
        $auth->connection();
        $this->assertSame(200, $auth->httpCode);
    }
}