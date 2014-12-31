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

use CrudGenerator\Utils\FileManager;
use CrudGenerator\Utils\Transtyper;
use CrudGenerator\View\ViewFactory;

class GeneratorFileWorker
{
    /**
     * @var FileManager
     */
    private $fileManager = null;
    /**
     * @var Transtyper
     */
    private $transtyper = null;

    const BASE_GENERATORS = 'generators';

    /**
     * @param FileManager $fileManager
     * @param Transtyper  $transtyper
     */
    public function __construct(FileManager $fileManager, Transtyper $transtyper)
    {
        $this->fileManager = $fileManager;
        $this->transtyper  = $transtyper;
    }

    /**
     * @param  string                              $generatorName
     * @throws GeneratorNotWellConfiguredException
     */
    private function isValid($generatorName)
    {
        if ($this->fileManager->isDir($this->generatorBasePath($generatorName)) === false) {
            throw new GeneratorNotWellConfiguredException('Generator does not exist');
        }

        if ($this->fileManager->isDir($this->generateSrcPath($generatorName)) === false) {
            throw new GeneratorNotWellConfiguredException('src path does not exist');
        }

        if ($this->fileManager->fileExists($this->generatorJsonPath($generatorName)) === false) {
            throw new GeneratorNotWellConfiguredException('Json does not exist');
        }
    }

    /**
     * Find all generator
     * @return Generator[]
     */
    public function findAll()
    {
        $generators = array();
        $collection = $this->fileManager->glob(self::BASE_GENERATORS.'/*', GLOB_ONLYDIR);

        if (empty($collection)) {
            throw new GeneratorNotWellConfiguredException("Create a generator before any work");
        }

        foreach ($collection as $generatorPath) {
            $generatorName =  str_replace(self::BASE_GENERATORS.'/', '', $generatorPath);

            try {
                $this->isValid($generatorName);

                $generator = new Generator();
                $generator->setProcess($this->getGeneratorJsonAsPhp($generatorName));
                $generator->setSrcPath($this->generateSrcPath($generatorName));
                $generator->setName($generatorName);

                $generators[] = $generator;
            } catch (GeneratorNotWellConfiguredException $e) {
                continue;
            }
        }

        return $generators;
    }

    /**
     * @param  string $generatorName
     * @return string
     */
    private function generatorJsonPath($generatorName)
    {
        return $this->generateSrcPath($generatorName).$generatorName.'.generator.json';
    }

    /**
     * @return mixed
     */
    private function getGeneratorJsonAsPhp($generatorName)
    {
        $this->isValid($generatorName);

        return $this->transtyper->decode($this->fileManager->fileGetContent($this->generatorJsonPath($generatorName)));
    }

    /**
     * @param string $generatorName
     * @param array  $data
     */
    public function persist(Generator $generator)
    {
        $generator = $this->persistFiles($generator);
        $generator = $this->persistTemplateVariable($generator);

        $this->fileManager->filePutsContent(
            $this->generatorJsonPath($generatorName),
            $this->transtyper->encode($generator->getProcess())
        );
    }

    public function create(Generator $generator)
    {
        $this->fileManager->ifDirDoesNotExistCreate('generators');

        $this->fileManager->mkdir('generators/'.$generator->getName());
        $this->fileManager->mkdir('generators/'.$generator->getName().'/src');
        $this->fileManager->mkdir('generators/'.$generator->getName().'/src/'.$generator->getName());
        $this->fileManager->mkdir('generators/'.$generator->getName().'/src/'.$generator->getName().'/Skeleton/'.$generator->getName(), true);

        $view = ViewFactory::getInstance();

        $this->fileManager->filePutsContent(
            'generators/'.$generator->getName().'/composer.json',
            $view->render(__DIR__.'/../Template/', 'composer.json.phtml', array(
                'name'           => $generator->getName(),
                'author'         => $generator->getAuthor(),
                'email'          => $generator->getEmail(),
                'description'    => $generator->getDescription(),
                'githubUserName' => $generator->getGithubUserName(),
                'keywords'       => $generator->getKeywords(),
            )));

        $baseGenerator = array(
            'name'       => $generator->getName(),
            'definition' => $generator->getDescription(),
        );

        $this->fileManager->filePutsContent(
            'generators/'.$generator->getName().'/src/'.$generator->getName().'/'.$generator->getName().'.generator.json',
            json_encode($baseGenerator, JSON_PRETTY_PRINT)
        );
    }

    /**
     * @param  Generator $generator
     * @return Generator
     */
    private function persistTemplateVariable(Generator $generator)
    {
        $process           = $generator->getProcess();
        $templateVariables = $generator->getTemplateVariable();

        if ($templateVariables !== array()) {
            foreach ($templateVariables as $templateVariable) {
                if (false === array_key_exists('templateVariables', $process)) {
                    $process['templateVariables'] = array();
                }

                $process['templateVariables'][] = array(
                    'variableName' => $templateVariables['variableName'],
                    'value'        => $templateVariables['value'],
                );
            }
        }

        $generator->setProcess($process);

        return $generator;
    }

    /**
     * @param  Generator $generator
     * @return Generator
     */
    private function persistFiles(Generator $generator)
    {
        $process = $generator->getProcess();
        $files   = $generator->getFiles();

        if ($files !== array()) {
            foreach ($files as $file) {
                if (false === array_key_exists('filesList', $process)) {
                    $process['filesList'] = array();
                }

                $process['filesList'][] = array(
                    'templatePath' => $file['template'],
                    'destination'  => $file['destination'],
                    'description'  => $file['description'],
                );

                $this->fileManager->filePutsContent($generator->getSkeletonPath().$file['template'].'.phtml', '');
            }
        }

        $generator->setProcess($process);

        return $generator;
    }

    /**
     * @param  string $generatorName
     * @return string
     */
    private function generatorBasePath($generatorName)
    {
        return self::BASE_GENERATORS.'/'.$generatorName;
    }

    /**
     * @param  string $generatorName
     * @return string
     */
    private function generateSrcPath($generatorName)
    {
        return $this->generatorBasePath($generatorName).'/src/'.$generatorName.'/';
    }
}
