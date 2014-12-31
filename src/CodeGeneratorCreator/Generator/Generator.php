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

class Generator
{
    private $srcPath = null;
    private $process = null;
    private $files   = array();
    private $templateVariable   = array();
    private $author = null;
    private $email = null;
    private $description    = null;
    private $githubUserName = null;
    private $keywords = null;
    private $name    = null;

    public function setSrcPath($value)
    {
        $this->srcPath = $value;

        return $this;
    }

    public function setProcess($value)
    {
        $this->process = $value;

        return $this;
    }

    public function setName($value)
    {
        $this->name = $value;

        return $this;
    }

    public function setAuthor($value)
    {
        $this->author = $value;

        return $this;
    }

    public function setEmail($value)
    {
        $this->email = $value;

        return $this;
    }

    public function setDescription($value)
    {
        $this->description = $value;

        return $this;
    }

    public function setKeywords($value)
    {
        $this->keywords = $value;

        return $this;
    }

    public function setGithubUserName($value)
    {
        $this->githubUserName = $value;

        return $this;
    }

    public function addFile($template, $destination, $description)
    {
        $this->files[] = array(
            'template' => $template,
            'destination' => $destination,
            'description' => $description,
        );

        return $this;
    }

    public function addTemplateVariable($variableName, $value)
    {
        $this->templateVariable[] = array(
            'variableName' => $variableName,
            'value' => $value,
        );

        return $this;
    }

    public function getSrcPath()
    {
        return $this->srcPath;
    }

    public function getSkeletonPath()
    {
        return $this->srcPath.'/Skeleton/';
    }

    public function getProcess()
    {
        return $this->process;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function getTemplateVariable()
    {
        return $this->templateVariable;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getGithubUserName()
    {
        return $this->githubUserName;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function getEmail()
    {
        return $this->email;
    }
}
