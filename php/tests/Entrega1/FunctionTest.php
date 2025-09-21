<?php
use PHPUnit\Framework\TestCase;

final class FunctionTest extends TestCase
{
    public function test_inicialitza_progres_crea_guions(): void
    {
        $arr = inicialitzaProgres('casa');
        $this->assertSame(['_','_','_','_'], $arr, 'Ha de crear tants guions com lletres');
    }

    public function test_imprimir_progres_format(): void
    {
        $arr = ['_', 'a', '_'];
        $this->expectOutputRegex('/_ a _/');
        imprimirProgres($arr);
    }

    public function test_comprovar_intent_encert(): void
    {
        $paraula = 'casa';
        $progres = ['_','_','_','_'];
        $erronia = comprovarIntent($paraula, 'a', $progres);
        $this->assertFalse($erronia, 'Si encerta, ha de retornar false');
        $this->assertSame(['_','a','_','a'], $progres);
    }

    public function test_comprovar_intent_error(): void
    {
        $paraula = 'casa';
        $progres = ['_','_','_','_'];
        $erronia = comprovarIntent($paraula, 'z', $progres);
        $this->assertTrue($erronia, 'Si falla, ha de retornar true');
        $this->assertSame(['_','_','_','_'], $progres);
    }
}
