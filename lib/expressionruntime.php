<?php

namespace Bx\Helper;

use Bx\Helper\Interfaces\RuntimeInterface;
use Bitrix\Main\Entity\ExpressionField;

class ExpressionRuntime implements RuntimeInterface
{
    private string $expression;
    private array $buildFrom;

    /**
     * @param string $expression
     * @param array $buildFrom
     */
    public function __construct(string $expression, array $buildFrom)
    {
        $this->expression = $expression;
        $this->buildFrom = $buildFrom;
    }

    /**
     * @param  string $resultFieldName
     * @return ExpressionField
     */
    public function compile(string $resultFieldName)
    {
        return new ExpressionField($resultFieldName, $this->expression, $this->buildFrom);
    }
}
