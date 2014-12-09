<?php

namespace CodeGeneratorCreator\Tests\Backbone\AddTemplateVariableBackboneFactory;

use CodeGeneratorCreator\Backbone\AddTemplateVariableBackboneFactory;

class GetInstanceTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf(
            'CodeGeneratorCreator\Backbone\AddTemplateVariableBackbone',
            AddTemplateVariableBackboneFactory::getInstance(
                $this->getMockBuilder('CrudGenerator\Context\ContextInterface')->getMock()
            )
        );
    }
}