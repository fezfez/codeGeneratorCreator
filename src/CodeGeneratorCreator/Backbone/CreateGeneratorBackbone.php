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

class CreateGeneratorBackbone
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
     * @param FileManager  $fileManager
     * @param ContextInterface $context
     */
    public function __construct(FileManager $fileManager, ContextInterface $context)
    {
        $this->fileManager = $fileManager;
        $this->context     = $context;
    }

    /**
     * @return \CrudGenerator\Generators\GeneratorDataObject
     */
    public function run()
    {
        $author         = $this->context->ask(new SimpleQuestion('Author name', 'author'));
        $email          = $this->context->ask(new SimpleQuestion('Email', 'email'));
        $description    = $this->context->ask(new SimpleQuestion('Description', 'description'));
        $keywords       = explode(',', $this->context->ask(new SimpleQuestion('Keywords', 'keywords')));
        $githubUserName = $this->context->ask(new SimpleQuestion('Github user name', 'github'));
        $generatorName  = $this->context->ask(new SimpleQuestion('ame of the new generator', 'name'));


        $this->fileManager->ifDirDoesNotExistCreate('./generators');

        $this->fileManager->mkdir('./generators/' . $generatorName);
        $this->fileManager->mkdir('./generators/' . $generatorName . '/src');
        $this->fileManager->mkdir('./generators/' . $generatorName . '/src/' . $generatorName);
        $this->fileManager->mkdir('./generators/' . $generatorName . '/src/' . $generatorName . '/Skeleton/' . $generatorName, true);

        $view = ViewFactory::getInstance();

        $this->fileManager->filePutsContent(
            'generators/' . $generatorName . '/composer.json',
            $view->render(__DIR__ . '/../Template/', 'composer.json.phtml', array(
                'name'           => $generatorName,
                'author'         => $author,
                'email'          => $email,
                'description'    => $description,
                'githubUserName' => $githubUserName,
                'keywords'       => $keywords,
        )));

        $baseGenerator = array(
            'name' => $generatorName,
            'definition' => $description
        );

        $this->fileManager->filePutsContent(
            'generators/' . $generatorName . '/src/' . $generatorName . '/' . $generatorName . '.generator.json',
            json_encode($baseGenerator, JSON_PRETTY_PRINT)
        );

        $this->context->log('Generator succefully created at generators/' . $generatorName);
    }
}
