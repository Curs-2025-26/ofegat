<?php
use PHPUnit\Framework\TestCase;

final class JocPooTest extends TestCase
{
    public function test_classes_exist(): void
    {
        $this->assertTrue(class_exists('App\\Joc'), 'Falta App\\Joc');
        $this->assertTrue(class_exists('App\\GestorPartida'), 'Falta App\\GestorPartida');
        $this->assertTrue(class_exists('App\\Jugador'), 'Falta App\\Jugador');
    }
}
