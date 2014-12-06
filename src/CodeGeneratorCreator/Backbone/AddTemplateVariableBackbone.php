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

class AddTemplateVariableBackbone
{
    /**
     * @var FileManager
     */
    private $fileManager = null;
    /**
     * @var ContextInterface
     */
    private $context = null;
    /**
     * @var GeneratorFileWorker
     */
    private $generatorFileWorker = null;

    /**
     * @param FileManager  $fileManager
     * @param ContextInterface $context
     * @param GeneratorFileWorker $generatorFileWorker
     */
    public function __construct(
        FileManager $fileManager,
        ContextInterface $context,
        GeneratorFileWorker $generatorFileWorker
    ) {
        $this->fileManager         = $fileManager;
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

        $generatorBasePath = $this->generatorFileWorker->generatorBasePath($generatorName);
        $generator         = $this->generatorFileWorker->getGeneratorJsonAsPhp($generatorName);

        if (is_array($generator['templateVariables']) === false) {
            $generator['templateVariables'] = array();
        }

        $variableName = $this->context->ask(new SimpleQuestion('Variable name', 'variableName'));
        $value        = $this->context->ask(new SimpleQuestion('Value', 'value'));

        $generator['templateVariables'][] = array(
            "variableName" => $variableName,
            "value"        => $value
        );

        $this->generatorFileWorker->putGeneratorJson($generatorName, $generator);
        $this->context->log('Template variable succefully added on ' . $generatorName);
    }
}
