<?php
use PHPUnit\Framework\TestCase;

final class SessionTest extends TestCase
{
    public function test_session_auth_class_exists(): void
    {
        $this->assertTrue(class_exists('SessionAuth'), 'Ha d'existir la classe SessionAuth');
    }

    public function test_login_method_stub_exists(): void
    {
        $this->assertTrue(method_exists('SessionAuth','login'), 'Ha d'existir el mètode login');
    }
}
