<?php

namespace CodeGeneratorCreator\Tests\Service\CliFactory;

use CodeGeneratorCreator\Service\CliFactory;

class GetInstanceTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf(
            'Symfony\Component\Console\Application',
            CliFactory::getInstance(
                $this->getMockBuilder('Symfony\Component\Console\Output\OutputInterface')->getMock(),
                $this->getMockBuilder('Symfony\Component\Console\Input\InputInterface')->getMock()
            )
        );
    }
}