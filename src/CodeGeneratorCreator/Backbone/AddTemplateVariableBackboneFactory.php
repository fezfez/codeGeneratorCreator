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
use CodeGeneratorCreator\Generator\GeneratorFileWorkerFactory;
use CodeGeneratorCreator\Generator\AskQuestionWithExpressionValidatorFactory;
use CodeGeneratorCreator\Generator\AskGeneratorFactory;

class AddTemplateVariableBackboneFactory
{
    /**
     * @param  ContextInterface            $context
     * @return AddTemplateVariableBackbone
     */
    public static function getInstance(ContextInterface $context)
    {
        return new AddTemplateVariableBackbone(
            $context,
            AskQuestionWithExpressionValidatorFactory::getInstance($context),
            GeneratorFileWorkerFactory::getInstance(),
            AskGeneratorFactory::getInstance($context)
        );
    }
}
