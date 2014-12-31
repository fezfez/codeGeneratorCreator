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

use CrudGenerator\Context\ContextInterface;
use CrudGenerator\Utils\PhpStringParserFactory;

class AskQuestionWithExpressionValidatorFactory
{
    /**
     * @param  ContextInterface                                                   $context
     * @return \CodeGeneratorCreator\Generator\AskQuestionWithExpressionValidator
     */
    public static function getInstance(ContextInterface $context)
    {
        return new AskQuestionWithExpressionValidator(
            ExpressionValidatorFactory::getInstance($context),
            PhpStringParserFactory::getInstance()
        );
    }
}
