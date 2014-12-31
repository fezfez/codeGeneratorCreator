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
use CodeGeneratorCreator\Generator\GeneratorFileWorker;
use CodeGeneratorCreator\Generator\AskGenerator;
use CodeGeneratorCreator\Generator\AskQuestionWithExpressionValidator;

class AddFileBackbone
{
    /**
     * @var ContextInterface
     */
    private $context = null;
    /**
     * @var AskQuestionWithExpressionValidator
     */
    private $askQuestionWithExpressionValidator = null;
    /**
     * @var GeneratorFileWorker
     */
    private $generatorFileWorker = null;
    /**
     * @var AskGenerator
     */
    private $askGenerator = null;

    /**
     * @param ContextInterface                   $context
     * @param AskQuestionWithExpressionValidator $askQuestionWithExpressionValidator
     * @param GeneratorFileWorker                $generatorFileWorker
     * @param AskGenerator                       $askGenerator
     */
    public function __construct(
        ContextInterface $context,
        AskQuestionWithExpressionValidator $askQuestionWithExpressionValidator,
        GeneratorFileWorker $generatorFileWorker,
        AskGenerator $askGenerator
    ) {
        $this->context                            = $context;
        $this->askQuestionWithExpressionValidator = $askQuestionWithExpressionValidator;
        $this->generatorFileWorker                = $generatorFileWorker;
        $this->askGenerator                       = $askGenerator;
    }

    /**
     * @return \CrudGenerator\Generators\GeneratorDataObject
     */
    public function run()
    {
        $generator    = $this->askGenerator->ask();
        $destination  = $this->askQuestionWithExpressionValidator->ask(new SimpleQuestion('Destination path', 'destination'), $generator);
        $templatePath = $this->context->ask(new SimpleQuestion('Template path', 'template_path'));
        $description  = $this->context->ask(new SimpleQuestion('File description', 'description'));

        $this->generatorFileWorker->persist(
            $generator->addFile($templatePath, $destination, $description)
        );

        $this->context->log('File succefully created at generators/'.$generatorName);
    }
}
