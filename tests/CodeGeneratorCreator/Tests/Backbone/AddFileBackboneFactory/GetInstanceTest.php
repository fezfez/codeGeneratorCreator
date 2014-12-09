<?php

namespace CodeGeneratorCreator\Tests\Backbone\AddFileBackboneFactory;

use CodeGeneratorCreator\Backbone\AddFileBackboneFactory;

class GetInstanceTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf(
            'CodeGeneratorCreator\Backbone\AddFileBackbone',
            AddFileBackboneFactory::getInstance(
                $this->getMockBuilder('CrudGenerator\Context\ContextInterface')->getMock()
            )
        );
    }
}