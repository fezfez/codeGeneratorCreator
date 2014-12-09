<?php

namespace CodeGeneratorCreator\Tests\Backbone\AddQuestionBackboneFactory;

use CodeGeneratorCreator\Backbone\AddQuestionBackboneFactory;

class GetInstanceTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf(
            'CodeGeneratorCreator\Backbone\AddQuestionBackbone',
            AddQuestionBackboneFactory::getInstance(
                $this->getMockBuilder('CrudGenerator\Context\ContextInterface')->getMock()
            )
        );
    }
}