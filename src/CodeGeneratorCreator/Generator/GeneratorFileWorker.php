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
    public function generatorWellConfigured($generatorName)
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
     * @param  string $generatorName
     * @return string
     */
    public function generatorJsonPath($generatorName)
    {
        return $this->generateSrcPath($generatorName).$generatorName.'.generator.json';
    }

    /**
     * @return mixed
     */
    public function getGeneratorJsonAsPhp($generatorName)
    {
        $this->generatorWellConfigured($generatorName);

        return $this->transtyper->decode($this->fileManager->fileGetContent($this->generatorJsonPath($generatorName)));
    }

    /**
     * @param string $generatorName
     * @param array  $data
     */
    public function putGeneratorJson($generatorName, array $data)
    {
        $this->fileManager->filePutsContent(
            $this->generatorJsonPath($generatorName),
            $this->transtyper->encode($data)
        );
    }

    /**
     * @param  string $generatorName
     * @return string
     */
    public function generatorBasePath($generatorName)
    {
        return 'generators/'.$generatorName;
    }

    /**
     * @param  string $generatorName
     * @return string
     */
    public function generateSrcPath($generatorName)
    {
        return $this->generatorBasePath($generatorName).'/src/'.$generatorName.'/';
    }
}
