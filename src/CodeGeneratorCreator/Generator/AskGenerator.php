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

use CrudGenerator\Context\ContextInterface;
use CrudGenerator\Context\PredefinedResponseCollection;
use CrudGenerator\Context\PredefinedResponse;
use CrudGenerator\Context\QuestionWithPredefinedResponse;

class AskGenerator
{
    /**
     * @var GeneratorFileWorker
     */
    private $generatorFileWorker = null;
    /**
     * @var Context
     */
    private $context = null;

    /**
     * @param GeneratorFileWorker $generatorFileWorker
     * @param Context             $context
     */
    public function __construct(GeneratorFileWorker $generatorFileWorker, ContextInterface $context)
    {
        $this->generatorFileWorker = $generatorFileWorker;
        $this->context = $context;
    }

    /**
     * @throws \Exception
     * @return Generator
     */
    public function ask()
    {
        $generatorsCollection = new PredefinedResponseCollection();

        foreach ($this->generatorFileWorker->findAll() as $generator) {
            try {
                $generatorsCollection->append(new PredefinedResponse($generator->getName(), $generator->getName(), $generator));
            } catch (GeneratorNotWellConfiguredException $e) {
                $this->context->log($e->getMessage());
            }
        }

        if ($generatorsCollection->getIterator()->count() === 0) {
            throw new \Exception('No generator found');
        }

        return $this->context->askCollection(new QuestionWithPredefinedResponse('Generator name', 'name', $generatorsCollection));
    }
}
