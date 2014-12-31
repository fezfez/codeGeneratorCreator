<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) Stéphane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CodeGeneratorCreator\Generator;

use CrudGenerator\Utils\PhpStringParser;
use CrudGenerator\Generators\GeneratorDataObject;
use CrudGenerator\Generators\Parser\ParserCollection;

class ExpressionValidator
{
    /**
     * @var ParserCollection
     */
    private $parseCollection = null;
    /**
     * @var PhpStringParser
     */
    private $phpStringParser = null;

    /**
     * @param ParserCollection $parseCollection
     * @param PhpStringParser  $phpStringParser
     */
    public function __construct(ParserCollection $parseCollection, PhpStringParser $phpStringParser)
    {
        $this->parseCollection = $parseCollection;
        $this->phpStringParser = $phpStringParser;
    }

    public function getListOfVar(Generator $generator)
    {
        return $this->parse($generator)->getVariables();
    }

    public function validate(Generator $generator, $string)
    {
        $this->parse($generator)->parse($string);

        return true;
    }

    private function parse(Generator $generator)
    {
        $generatorDto = new GeneratorDataObject();
        $generatorDto->setName($generator->getName());
        $generatorDto->setPath($generator->getSrcPath());

        foreach ($this->parseCollection->getPreParse() as $parser) {
            $generatorDto = $parser->evaluate($generator->getProcess(), $this->phpStringParser, $generatorDto, true);
        }

        $this->phpStringParser->addVariable(lcfirst($generator->getName()), $generatorDto->getDto());
        $generatorDto->addTemplateVariable(lcfirst($generator->getName()), $generatorDto->getDto());

        foreach ($this->parseCollection->getPostParse() as $parser) {
            $generatorDto = $parser->evaluate($generator->getProcess(), $this->phpStringParser, $generatorDto, true);
        }

        return $this->phpStringParser;
    }
}
