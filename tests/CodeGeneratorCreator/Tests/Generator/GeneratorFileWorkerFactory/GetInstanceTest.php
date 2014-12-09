<?php

namespace CodeGeneratorCreator\Tests\Generator\GeneratorFileWorkerFactory;

use CodeGeneratorCreator\Generator\GeneratorFileWorkerFactory;

class GetInstanceTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf(
            'CodeGeneratorCreator\Generator\GeneratorFileWorker',
            GeneratorFileWorkerFactory::getInstance()
        );
    }
}