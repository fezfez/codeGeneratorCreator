<?php

namespace CodeGeneratorCreator\Tests\Backbone\CreateGeneratorBackboneFactory;

use CodeGeneratorCreator\Backbone\CreateGeneratorBackboneFactory;

class GetInstanceTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf(
            'CodeGeneratorCreator\Backbone\CreateGeneratorBackbone',
            CreateGeneratorBackboneFactory::getInstance(
                $this->getMockBuilder('CrudGenerator\Context\ContextInterface')->getMock()
            )
        );
    }
}