<?php

namespace CodeGeneratorCreator\Tests\Backbone\MainBackboneFactory;

use CodeGeneratorCreator\Backbone\MainBackboneFactory;

class GetInstanceTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf(
            'CodeGeneratorCreator\Backbone\MainBackbone',
            MainBackboneFactory::getInstance(
                $this->getMockBuilder('CrudGenerator\Context\ContextInterface')->getMock()
            )
        );
    }
}