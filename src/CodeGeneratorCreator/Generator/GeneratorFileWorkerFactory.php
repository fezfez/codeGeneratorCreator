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
use CrudGenerator\Utils\TranstyperFactory;

class GeneratorFileWorkerFactory
{
    /**
     * @return GeneratorFileWorker
     */
    public static function getInstance()
    {
        return new GeneratorFileWorker(new FileManager(), TranstyperFactory::getInstance());
    }
}
