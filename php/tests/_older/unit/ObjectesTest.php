<?php

class ObjectesTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
        include_once('./src/Persona.php');
        include_once('./src/Persona7.php');
        include_once('./src/Persona8.php');
        include_once('./src/Empleado.php');
        include_once('./src/JSerializable.php');
        include_once('./src/Person.php');
        include_once('./src/Worker.php');
        include_once('./src/Manager.php');
        include_once('./src/Employee.php');
        include_once('./src/Enterprise.php');

    }

    public function test301(){
        $empleado = new Persona();
        $empleado->setNombre('Ignasi');
        $empleado->setApellidos('Gomis Mullor');
        $empleado->setEdat('60');
        $this->assertEquals('Ignasi Gomis Mullor',$empleado->getNombreCompleto());
        $this->assertEquals(false,$empleado->estaJubilado());
    }

    public function test302()
    {
        $empleado = new Persona7('Ignasi', 'Gomis Mullor');
        $this->assertEquals('Ignasi Gomis Mullor', $empleado->getNombreCompleto());
        $this->assertEquals(false, $empleado->estaJubilado());
        $this->assertEquals(25, $empleado->getEdat());
        $empleado = new Persona7('Ignasi', 'Gomis Mullor', 70);
        $this->assertEquals('Ignasi Gomis Mullor', $empleado->getNombreCompleto());
        $this->assertEquals(true, $empleado->estaJubilado());
    }

    public function test303()
    {
        $empleado = new Persona8('Ignasi', 'Gomis Mullor');
        $this->assertEquals('Ignasi Gomis Mullor', $empleado->getNombreCompleto());
        $this->assertEquals(false, $empleado->estaJubilado());
        $this->assertEquals(25, $empleado->getEdat());
        $empleado = new Persona8('Ignasi', 'Gomis Mullor', 70);
        $this->assertEquals('Ignasi Gomis Mullor', $empleado->getNombreCompleto());
        $this->assertEquals(true, $empleado->estaJubilado());
    }

    public function test304(){
        $empleado = new Persona8('Ignasi','Gomis Mullor',75);
        $this->assertEquals(true,$empleado->estaJubilado());
    }

    public function test305(){
        $empleado = new Persona8('Ignasi','Gomis Mullor');
        $this->assertEquals(false,$empleado->estaJubilado());
        $empleado->setEdat(67);
        $this->assertEquals(true,$empleado->estaJubilado());
        $empleado::modificaLimite(70);
        $this->assertEquals(false,$empleado->estaJubilado());

    }

    public function test306(){
        $empleado = new Empleado('Ignasi','Gomis Mullor');
        $empleado->setSueldo('2000');
        $this->assertEquals('Ignasi Gomis Mullor',$empleado->getNombreCompleto());
        $this->assertEquals(false,$empleado->debePagarImpuestos());
        $empleado->anyadirTelefono(12345678);
        $empleado->anyadirTelefono(87654321);
        $this->assertEquals('12345678,87654321',$empleado->listarTelefonos());
        $empleado->vaciarTelefonos();
        $this->assertEquals('',$empleado->listarTelefonos());
    }


    public function test307(){
        $empleado = new Empleado('Ignasi','Gomis Mullor');
        $empleado->anyadirTelefono(12345678);
        $empleado->anyadirTelefono(87654321);
        $this->assertEquals('<p>Ignasi Gomis Mullor</p><ul><li>12345678</li><li>87654321</li></ul>',Empleado::toHtml($empleado));

    }

    public function test308(){
        $empleado = new Empleado('Ignasi','Gomis Mullor');
        $persona = new Persona8('Pepe','Botera');
        $empleado->anyadirTelefono(12345678);
        $empleado->anyadirTelefono(87654321);
        $this->assertEquals('<p>Ignasi Gomis Mullor</p><ul><li>12345678</li><li>87654321</li></ul>',Empleado::toHtml($empleado));
        $this->assertEquals('<p>Pepe Botera</p>',Persona8::toHtml($persona));

    }

    public function test309(){
        $empleado = new Empleado('Ignasi','Gomis Mullor');
        $persona = new Persona8('Pepe','Botera');
        $empleado->anyadirTelefono(12345678);
        $empleado->anyadirTelefono(87654321);
        $this->assertEquals('<p>Ignasi Gomis Mullor</p><ul><li>12345678</li><li>87654321</li></ul>',$empleado->__toString());
        $this->assertEquals('<p>Pepe Botera</p>',$persona->__toString());

    }

    public function test310(){
        $empleado = new Employee(horasTrabajadas: 40,precioPorHora: 20, nombre:'Ignasi',apellidos: 'Gomis Mullor',edat: '54');
        $empleado->anyadirTelefono(12345678);
        $empleado->anyadirTelefono(87654321);
        $this->assertEquals('<p>Ignasi Gomis Mullor</p><ul><li>12345678</li><li>87654321</li></ul>',$empleado->__toString());
        $this->assertEquals(800,$empleado->calcularSueldo());
        $this->assertEquals(false,$empleado->debePagarImpuestos());
        $empleado = new Manager(salari: 3000, nombre:'Ignasi',apellidos: 'Gomis Mullor',edat: '54');
        $empleado->anyadirTelefono(12345678);
        $empleado->anyadirTelefono(87654321);
        $this->assertEquals('<p>Ignasi Gomis Mullor</p><ul><li>12345678</li><li>87654321</li></ul>',$empleado->__toString());
        $this->assertEquals(4620.0,$empleado->calcularSueldo());
        $this->assertEquals(true,$empleado->debePagarImpuestos());
    }

    public function test311(){
        $empleado = new Employee(horasTrabajadas: 150,precioPorHora: 12, nombre:'Pepe',apellidos: 'Botera',edat: '24');
        $manager = new Manager(salari: 4000, nombre:'Ignasi',apellidos: 'Gomis Mullor',edat: '54');
        $empresa = new Enterprise('CIP FP BATOI','Serreta 8');
        $empresa->addWorker($empleado);
        $empresa->addWorker($manager);
        $this->assertEquals('<div><p>Pepe Botera</p><p>Ignasi Gomis Mullor</p></div>',$empresa->listWorkersHtml());
        $this->assertEquals($empleado->calcularSueldo()+$manager->calcularSueldo(),$empresa->getCosteNominas());
    }

    public function test312(){
        $empleado = new Employee(horasTrabajadas: 150,precioPorHora: 12, nombre:'Pepe',apellidos: 'Botera',edat: '24');
        $this->assertEquals('{"nombre":"Pepe","apellidos":"Botera","edat":"24","telefonos":[],"horasTrabajadas":150,"precioPorHora":12}',$empleado->toJSON());
        $this->assertEquals($empleado->toJSON(),unserialize($empleado->toSerialize())->toJSON());
        $manager = new Manager(salari: 4000, nombre:'Ignasi',apellidos: 'Gomis Mullor',edat: '54');
        $this->assertEquals('{"nombre":"Ignasi","apellidos":"Gomis Mullor","edat":"54","telefonos":[],"salari":4000}',$manager->toJSON());
        $this->assertEquals($manager->toJSON(),unserialize($manager->toSerialize())->toJSON());
        $empresa = new Enterprise('CIP FP BATOI','Serreta 8');
        $empresa->addWorker($empleado);
        $empresa->addWorker($manager);
        $this->assertEquals($empresa->toJSON(),unserialize($empresa->toSerialize())->toJSON());
    }

}