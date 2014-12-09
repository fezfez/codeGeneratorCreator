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
use CodeGeneratorCreator\Generator\GeneratorFileWorker;

class AddFileBackbone
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
     * @param FileManager         $fileManager
     * @param ContextInterface    $context
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

        $generatorBasePath = $this->generatorFileWorker->generateSrcPath($generatorName);
        $generator         = $this->generatorFileWorker->getGeneratorJsonAsPhp($generatorName);

        if (array_key_exists('fileList', $generator) === false) {
            $generator['fileList'] = array();
        }

        $templatePath = $this->context->ask(new SimpleQuestion('Template path', 'template_path'));
        $description  = $this->context->ask(new SimpleQuestion('File description', 'description'));
        $destination  = $this->context->ask(new SimpleQuestion('Destination path', 'destination'));

        $generator['fileList'][] = array(
            "templatePath"    => $description,
            "destinationPath" => $destination,
            "description"     => $description,
        );

        $this->context->log('Create template path at '.$generatorBasePath.'/Skeleton/'.$templatePath);
        $this->fileManager->filePutsContent($generatorBasePath.'/Skeleton/'.$templatePath.'.phtml', '');
        $this->generatorFileWorker->putGeneratorJson($generatorName, $generator);
        $this->context->log('Generator succefully created at generators/'.$generatorName);
    }
}
