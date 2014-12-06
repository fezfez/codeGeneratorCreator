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

class MainBackbone
{
    /**
     * @var CreateGeneratorBackbone
     */
    private $createGenerator = null;
    /**
     * @var AddFileBackbone
     */
    private $addFileBackbone = null;
    /**
     * @var AddTemplateVariableBackbone
     */
    private $addTemplateVariableBackbone = null;
    /**
     * @var ContextInterface
     */
    private $context = null;

    /**
     * @param CreateGeneratorBackbone $createGenerator
     * @param AddFileBackbone $addFileBackbone
     * @param AddTemplateVariableBackbone $addTemplateVariableBackbone
     * @param ContextInterface $context
     */
    public function __construct(
        CreateGeneratorBackbone $createGenerator,
        AddFileBackbone $addFileBackbone,
        AddTemplateVariableBackbone $addTemplateVariableBackbone,
        ContextInterface $context
    ) {
        $this->createGenerator = $createGenerator;
        $this->addFileBackbone = $addFileBackbone;
        $this->addTemplateVariableBackbone = $addTemplateVariableBackbone;
        $this->context         = $context;
    }

    public function run()
    {
        $this->context->menu(
            'Create new generator',
            'create-generator',
            function () {
                $this->createGenerator->run();
            }
        );

        $this->context->menu(
            'Add file to an existing generator',
            'add-file',
            function () {
                $this->addFileBackbone->run();
            }
        );

        $this->context->menu(
            'Add template variable to an existing generator',
            'add-template-variable',
            function () {
                $this->addTemplateVariableBackbone->run();
            }
        );
    }
}
