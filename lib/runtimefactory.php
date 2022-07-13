<?php

namespace Bx\Helper;

use Bx\Helper\Interfaces\JoinRuntimeInterface;
use Bx\Helper\Interfaces\RuntimeInterface;
use Bitrix\Main\Entity\DataManager;

class RuntimeFactory
{
    /**
     * @param  string             $foreignKey
     * @param  string|DataManager $entityClass
     * @param  string             $linkedField
     * @return JoinRuntimeInterface
     * @psalm-suppress MismatchingDocblockParamType
     */
    public static function createJoin(
        string $foreignKey,
        string $entityClass,
        string $linkedField
    ): JoinRuntimeInterface {
        return (new JoinRuntime())->setForeignKey($foreignKey)->setTarget($entityClass, $linkedField);
    }

    /**
     * @param  string $expression
     * @param  string $entityFieldName
     * @return RuntimeInterface
     */
    public static function createExpression(string $expression, string $entityFieldName): RuntimeInterface
    {
        return new ExpressionRuntime($expression, [$entityFieldName]);
    }

    /**
     * @param  string $entityFieldName
     * @return RuntimeInterface
     */
    public static function createAvgExpression(string $entityFieldName): RuntimeInterface
    {
        return static::createExpression('AVG(%s)', $entityFieldName);
    }

    /**
     * @param  string $entityFieldName
     * @return RuntimeInterface
     */
    public static function createBitAndExpression(string $entityFieldName): RuntimeInterface
    {
        return static::createExpression('BIT_AND(%s)', $entityFieldName);
    }

    /**
     * @param  string $entityFieldName
     * @return RuntimeInterface
     */
    public static function createBitOrExpression(string $entityFieldName): RuntimeInterface
    {
        return static::createExpression('BIT_OR(%s)', $entityFieldName);
    }

    /**
     * @param  string $entityFieldName
     * @return RuntimeInterface
     */
    public static function createBitXorExpression(string $entityFieldName): RuntimeInterface
    {
        return static::createExpression('BIT_XOR(%s)', $entityFieldName);
    }

    /**
     * @param  string $entityFieldName
     * @return RuntimeInterface
     */
    public static function createCountExpression(string $entityFieldName = '*'): RuntimeInterface
    {
        return static::createExpression('COUNT(%s)', $entityFieldName);
    }

    /**
     * @param  string $entityFieldName
     * @return RuntimeInterface
     */
    public static function createGroupConcatExpression(string $entityFieldName): RuntimeInterface
    {
        return static::createExpression('GROUP_CONCAT(%s)', $entityFieldName);
    }

    /**
     * @param  string $entityFieldName
     * @return RuntimeInterface
     */
    public static function createMaxExpression(string $entityFieldName): RuntimeInterface
    {
        return static::createExpression('MAX(%s)', $entityFieldName);
    }

    /**
     * @param  string $entityFieldName
     * @return RuntimeInterface
     */
    public static function createMinExpression(string $entityFieldName): RuntimeInterface
    {
        return static::createExpression('MIN(%s)', $entityFieldName);
    }

    /**
     * @param  string $entityFieldName
     * @return RuntimeInterface
     */
    public static function createStdExpression(string $entityFieldName): RuntimeInterface
    {
        return static::createExpression('STD(%s)', $entityFieldName);
    }

    /**
     * @param  string $entityFieldName
     * @return RuntimeInterface
     */
    public static function createSumExpression(string $entityFieldName): RuntimeInterface
    {
        return static::createExpression('SUM(%s)', $entityFieldName);
    }
}
