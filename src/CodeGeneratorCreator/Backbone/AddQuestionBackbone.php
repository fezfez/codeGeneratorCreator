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
use CrudGenerator\Utils\FileManager;
use CrudGenerator\View\ViewFactory;
use CrudGenerator\Utils\TranstyperFactory;
use CodeGeneratorCreator\Generator\GeneratorFileWorker;
use CrudGenerator\Generators\Parser\Lexical\QuestionTypeEnum;
use CrudGenerator\Context\QuestionWithPredefinedResponse;
use CrudGenerator\Context\PredefinedResponseCollection;
use CrudGenerator\Context\PredefinedResponse;

class AddQuestionBackbone
{
    /**
     * @var ContextInterface
     */
    private $context = null;
    /**
     * @var GeneratorFileWorker
     */
    private $generatorFileWorker = null;

    /**
     * @param ContextInterface $context
     * @param GeneratorFileWorker $generatorFileWorker
     */
    public function __construct(
        ContextInterface $context,
        GeneratorFileWorker $generatorFileWorker
    ) {
        $this->context             = $context;
        $this->generatorFileWorker = $generatorFileWorker;
    }


    /**
     * @return \CrudGenerator\Generators\GeneratorDataObject
     */
    public function run()
    {
        $generatorName  = $this->context->ask(new SimpleQuestion('Generator name', 'name'));

        $this->generatorFileWorker->generatorWellConfigured($generatorName);

        $generatorBasePath = $this->generatorFileWorker->generateSrcPath($generatorName);
        $generator         = $this->generatorFileWorker->getGeneratorJsonAsPhp($generatorName);
        $newQuestion       = array();

        if (array_key_exists('questions', $generator) === false) {
            $generator['questions'] = array();
        }

        $questionTypeCollection = new PredefinedResponseCollection();
        $responseTypeCollection = new PredefinedResponseCollection();

        $questionTypeCollection->append(new PredefinedResponse('Directory', 'Directory', QuestionTypeEnum::DIRECTORY));
        $questionTypeCollection->append(new PredefinedResponse('Iterator', 'Iterator', QuestionTypeEnum::ITERATOR));
        $questionTypeCollection->append(new PredefinedResponse('Simple', 'Simple', QuestionTypeEnum::SIMPLE));
        $questionTypeCollection->append(
            new PredefinedResponse(
                'Iterator with predefined responsectory',
                'Iterator with predefined response',
                QuestionTypeEnum::ITERATOR_WITH_PREDEFINED_RESPONSE
            )
        );

        $responseTypeCollection->append(new PredefinedResponse('text', 'text', 'text'));
        $responseTypeCollection->append(new PredefinedResponse('boolean', 'boolean', 'boolean'));

        $attribute    = $this->context->ask(new SimpleQuestion('dtoAttribute', 'dtoAttribute'));
        $questionType = $this->context->askCollection(new QuestionWithPredefinedResponse('type', 'type', $questionTypeCollection));

        if ($questionType === QuestionTypeEnum::SIMPLE || $questionType === QuestionTypeEnum::DIRECTORY) {
            $text         = $this->context->ask(new SimpleQuestion('text', 'text'));
            $newQuestion["text"]         = $text;
        }

        $newQuestion["dtoAttribute"] = $attribute;
        $newQuestion["type"]         = $questionType;

        if ($questionType === QuestionTypeEnum::SIMPLE) {
            $defaultResponse = $this->context->ask(new SimpleQuestion('Default response', 'defaultResponse'));
            $typeResponse    = $this->context->askCollection(new QuestionWithPredefinedResponse('Type response', 'response_type', $responseTypeCollection));

            $newQuestion["response"] = array(
                "default" => $defaultResponse,
                'type'    => $typeResponse
            );
        } elseif ($questionType !== QuestionTypeEnum::DIRECTORY) {
            $iterator        = $this->context->ask(new SimpleQuestion('iterator', 'iterator'));
            $retrieveBy      = $this->context->ask(new SimpleQuestion('retrieveBy', 'retrieveBy'));
            $defaultResponse = $this->context->ask(new SimpleQuestion('Default response', 'defaultResponse'));
            $typeResponse    = $this->context->askCollection(new QuestionWithPredefinedResponse('Type response', 'response_type', $responseTypeCollection));
            $text            = $this->context->ask(new SimpleQuestion('text', 'text'));

            $newQuestion['iteration'] = array(
                'iterator'   => $iterator,
                'text'       => $text,
                'retrieveBy' => $retrieveBy,
                'response' => array(
                    'type'    => $typeResponse,
                    'default' => $default,
                )
            );

            if ($questionType === QuestionTypeEnum::ITERATOR_WITH_PREDEFINED_RESPONSE) {
                do {
                    $text     = $this->context->ask(new SimpleQuestion('text', 'text'));
                    $response = $this->context->ask(new SimpleQuestion('response', 'response'));

                    $newQuestion['iteration']['response'][] = array(
                        'text'     => $text,
                        'response' => $response
                    );

                } while ($this->context->confirm('Do you want to add another predefined response', 'add_predefined_response'));
            }
        }
        $generator['questions'][] = $newQuestion;

        $this->generatorFileWorker->putGeneratorJson($generatorName, $generator);
        $this->context->log('Question succefully created at generators/' . $generatorName);
    }
}
