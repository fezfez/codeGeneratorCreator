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

use CrudGenerator\Utils\PhpStringParser;
use CrudGenerator\Context\SimpleQuestion;

class AskQuestionWithExpressionValidator
{
    /**
     * @var ExpressionValidator
     */
    private $expressionValidator = null;
    /**
     * @var PhpStringParser
     */
    private $phpStringParser = null;

    /**
     * @param ExpressionValidator $expressionValidator
     * @param PhpStringParser     $phpStringParser
     */
    public function __construct(ExpressionValidator $expressionValidator, PhpStringParser $phpStringParser)
    {
        $this->expressionValidator = $expressionValidator;
        $this->phpStringParser = $phpStringParser;
    }

    /**
     * @param  SimpleQuestion $question
     * @return string
     */
    public function ask(SimpleQuestion $question, Generator $generator)
    {
        $vars = $this->expressionValidator->getListOfVar($generator);

        $this->context->log('List of vars : '.implode(', ', $vars), 'vars');

        $isValid = false;
        do {
            $response  = $this->context->ask($question);
            try {
                $isValid = $this->expressionValidator->validate($generator, $response);
            } catch (\Exception $e) {
                $this->context->log('<error>'.$e->getMessage().'</error>');
            }
        } while ($isValid === false);

        return $response;
    }
}
