<?php

namespace Bx\Helper\Interfaces;

use Bitrix\Main\ORM\Query\Chain;
use Bitrix\Main\ORM\Query\Filter\Condition;
use Bitrix\Main\ORM\Query\Filter\ConditionTree;
use Bitrix\Main\ORM\Query\Query;
use Bitrix\Main\DB\SqlExpression;

/**
 * Handles filtering conditions for Query and join conditions for Entity References.
 *
 * @package    bitrix
 * @subpackage main
 */
interface ConditionTreeInterface
{
    /**
     * All conditions will be imploded by this logic: static::LOGIC_AND or static::LOGIC_OR
     *
     * @param string|null $logic and|or
     *
     * @return ConditionTreeInterface
     */
    public function logic(?string $logic = null): ConditionTreeInterface;

    /**
     * Sets NOT before all the conditions.
     *
     * @param bool $negative
     *
     * @return ConditionTreeInterface
     */
    public function negative(bool $negative = true): ConditionTreeInterface;

    /**
     * General condition. In regular case used with 3 parameters:
     *   where(columnName, operator, value), e.g. ('ID', '=', 1); ('SALARY', '>', '500')
     *
     * List of available operators can be found in Operator class.
     *
     * @param mixed ...$filter
     *
     * @return ConditionTreeInterface
     * @see    Operator::$operators
     *
     * Can be used in short format:
     *   where(columnName, value), with operator '=' by default
     * Can be used in ultra short format:
     *   where(columnName), for boolean fields only
     *
     * Can be used for subfilter set:
     *   where(ConditionTree subfilter)
     *
     * Instead of columnName, you can use runtime field:
     *   where(new ExpressionField('TMP', 'CONCAT(%s, %s)', ["NAME", "LAST_NAME"]), 'Anton Ivanov')
     *     or with expr helper
     *   where(Query::expr()->concat("NAME", "LAST_NAME"), 'Anton Ivanov')
     */
    public function where(...$filter): ConditionTreeInterface;

    /**
     * Sets NOT before any conditions or subfilter.
     *
     * @param mixed ...$filter
     *
     * @return ConditionTreeInterface
     * @see    ConditionTree::where()
     */
    public function whereNot(...$filter): ConditionTreeInterface;

    /**
     * The same logic as where(), but value will be taken as another column name.
     *
     * @param mixed ...$filter
     *
     * @return ConditionTreeInterface
     * @see    ConditionTree::where()
     */
    public function whereColumn(...$filter): ConditionTreeInterface;

    /**
     * Compares column with NULL.
     *
     * @param string $column
     *
     * @return ConditionTreeInterface
     */
    public function whereNull(string $column): ConditionTreeInterface;

    /**
     * Compares column with NOT NULL.
     *
     * @param string $column
     *
     * @return ConditionTreeInterface
     */
    public function whereNotNull(string $column): ConditionTreeInterface;

    /**
     * IN() condition.
     *
     * @param string                    $column
     * @param array|Query|SqlExpression $values
     *
     * @return ConditionTreeInterface
     */
    public function whereIn(string $column, $values): ConditionTreeInterface;

    /**
     * Negative IN() condition.
     *
     * @param string                    $column
     * @param array|Query|SqlExpression $values
     *
     * @return ConditionTreeInterface
     * @see    ConditionTree::whereIn()
     */
    public function whereNotIn(string $column, $values): ConditionTreeInterface;

    /**
     * BETWEEN condition.
     *
     * @param string $column
     * @param mixed $valueMin
     * @param mixed $valueMax
     *
     * @return ConditionTreeInterface
     */
    public function whereBetween(string $column, $valueMin, $valueMax): ConditionTreeInterface;

    /**
     * Negative BETWEEN condition.
     *
     * @param string $column
     * @param mixed $valueMin
     * @param mixed $valueMax
     *
     * @return ConditionTreeInterface
     * @see    ConditionTree::whereBetween()
     */
    public function whereNotBetween(string $column, $valueMin, $valueMax): ConditionTreeInterface;

    /**
     * LIKE condition, without default % placement.
     *
     * @param string $column
     * @param mixed $value
     *
     * @return ConditionTreeInterface
     */
    public function whereLike(string $column, $value): ConditionTreeInterface;

    /**
     * Negative LIKE condition, without default % placement.
     *
     * @param string $column
     * @param mixed $value
     *
     * @return ConditionTreeInterface
     * @see    ConditionTree::whereLike()
     */
    public function whereNotLike(string $column, $value): ConditionTreeInterface;

    /**
     * Exists() condition. Can be used with Query object or plain sql wrapped with SqlExpression.
     *
     * @param Query|SqlExpression $query
     *
     * @return ConditionTreeInterface
     */
    public function whereExists($query): ConditionTreeInterface;

    /**
     * Negative Exists() condition. Can be used with Query object or plain sql wrapped with SqlExpression.
     *
     * @param Query|SqlExpression $query
     *
     * @return ConditionTreeInterface
     * @see    ConditionTree::whereExists()
     */
    public function whereNotExists($query): ConditionTreeInterface;

    /**
     * Fulltext search condition.
     *
     * @param string $column
     * @param mixed $value
     *
     * @return ConditionTreeInterface
     * @see    Helper::matchAgainstWildcard() for preparing $value for AGAINST.
     */
    public function whereMatch(string $column, $value): ConditionTreeInterface;

    /**
     * Negative fulltext search condition.
     *
     * @param string $column
     * @param mixed $value
     *
     * @return ConditionTreeInterface
     * @see    Helper::matchAgainstWildcard() for preparing $value for AGAINST.
     */
    public function whereNotMatch(string $column, $value): ConditionTreeInterface;

    /**
     * Any SQL Expression condition
     *
     * @param string   $expr
     * @param string[] $arguments
     *
     * @return ConditionTreeInterface
     * @see    ExpressionField
     */
    public function whereExpr(string $expr, array $arguments): ConditionTreeInterface;

    /**
     * Adds prepared condition.
     *
     * @param Condition|ConditionTree $condition
     *
     * @return ConditionTreeInterface
     */
    public function addCondition($condition): ConditionTreeInterface;
}
