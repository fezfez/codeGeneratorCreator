<?php
/**
 * This file is part of the Code Generator package.
 *
 * (c) Stéphane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CodeGeneratorCreator\Backbone;

use CrudGenerator\Context\ContextInterface;
use CrudGenerator\Context\SimpleQuestion;
use CodeGeneratorCreator\Generator\Generator;
use CodeGeneratorCreator\Generator\GeneratorFileWorker;

class CreateGeneratorBackbone
{
    /**
     * @var GeneratorFileWorker
     */
    private $generatorFileWorker = null;
    /**
     * @var ContextInterface
     */
    private $context = null;

    /**
     * @param GeneratorFileWorker $generatorFileWorker
     * @param ContextInterface    $context
     */
    public function __construct(GeneratorFileWorker $generatorFileWorker, ContextInterface $context)
    {
        $this->generatorFileWorker = $generatorFileWorker;
        $this->context     = $context;
    }

    /**
     * @return \CrudGenerator\Generators\GeneratorDataObject
     */
    public function run()
    {
        $generator = new Generator();

        $generator->setAuthor($this->context->ask(new SimpleQuestion('Author name', 'author')));
        $generator->setEmail($this->context->ask(new SimpleQuestion('Email', 'email')));
        $generator->setDescription($this->context->ask(new SimpleQuestion('Description', 'description')));
        $generator->setKeywords(explode(',', $this->context->ask(new SimpleQuestion('Keywords', 'keywords'))));
        $generator->setGithubUserName($this->context->ask(new SimpleQuestion('Github user name', 'github')));
        $generator->setName($this->context->ask(new SimpleQuestion('Name of the new generator', 'name')));

        $this->generatorFileWorker->create($generator);

        $this->context->log('Generator succefully created at generators/'.$generator->getName());
    }
}
