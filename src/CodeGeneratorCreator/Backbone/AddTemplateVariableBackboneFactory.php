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
use CrudGenerator\Utils\FileManager;
use CodeGeneratorCreator\Generator\GeneratorFileWorkerFactory;

class AddTemplateVariableBackboneFactory
{
    /**
     * @param  ContextInterface            $context
     * @return AddTemplateVariableBackbone
     */
    public static function getInstance(ContextInterface $context)
    {
        return new AddTemplateVariableBackbone(
            new FileManager(),
            $context,
            GeneratorFileWorkerFactory::getInstance()
        );
    }
}
