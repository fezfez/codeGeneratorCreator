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

class MainBackboneFactory
{
    /**
     * @param  ContextInterface                     $context
     * @return \CrudGenerator\Backbone\MainBackbone
     */
    public static function getInstance(ContextInterface $context)
    {
        return new MainBackbone(
            CreateGeneratorBackboneFactory::getInstance($context),
            AddFileBackboneFactory::getInstance($context),
            AddTemplateVariableBackboneFactory::getInstance($context),
            $context
        );
    }
}
