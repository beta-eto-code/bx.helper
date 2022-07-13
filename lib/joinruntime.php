<?php

namespace Bx\Helper;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\ORM\Query\Join;
use Bx\Helper\Interfaces\ConditionTreeInterface;
use Bitrix\Main\ORM\Query\Filter\ConditionTree;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bx\Helper\Interfaces\JoinRuntimeInterface;
use Exception;

class JoinRuntime implements JoinRuntimeInterface
{
    /**
     * @var DataManager|string
     */
    private $entityClass = '';
    /**
     * @var string
     */
    private string $linkedField = '';
    /**
     * @var string
     */
    private string $field = '';
    /**
     * @var string
     */
    private string $joinType = '';

    /**
     * @var ConditionTreeInterface|null
     */
    private $condition = null;

    /**
     * @param DataManager|string $entityClass
     * @param string $linkedField
     * @return JoinRuntimeInterface
     * @psalm-suppress MismatchingDocblockParamType
     */
    public function setTarget(string $entityClass, string $linkedField): JoinRuntimeInterface
    {
        $this->entityClass = $entityClass;
        $this->linkedField = $linkedField;

        return $this;
    }

    /**
     * @param string $field
     * @return JoinRuntimeInterface
     */
    public function setForeignKey(string $field): JoinRuntimeInterface
    {
        $this->field = $field;
        return $this;
    }

    /**
     * @param string $type
     * @return JoinRuntimeInterface
     */
    public function setJoinType(string $type): JoinRuntimeInterface
    {
        $this->joinType = $type;
        return $this;
    }

    /**
     * @return ConditionTreeInterface
     * @psalm-suppress InvalidReturnStatement,InvalidReturnType,InvalidPropertyAssignmentValue
     */
    public function getCondition()
    {
        if ($this->condition instanceof ConditionTree) {
            return $this->condition;
        }

        return $this->condition = new ConditionTree();
    }

    /**
     * @param  string $resultFieldName
     * @return Reference
     * @throws Exception
     */
    public function compile(string $resultFieldName)
    {
        if (empty($this->field)) {
            throw new Exception('Foreign key is not set for join runtime');
        }

        if (empty($this->entityClass)) {
            throw new Exception('Entity class is not set for join runtime');
        }

        if (empty($this->linkedField)) {
            throw new Exception('Linked field is not set for join runtime');
        }

        $join = Join::on("this.{$this->field}", "ref.{$this->linkedField}");
        if ($this->condition instanceof ConditionTree) {
            $join->addCondition($this->condition);
        }

        $result = new Reference($resultFieldName, $this->entityClass, $join);
        if (!empty($this->joinType) && in_array($this->joinType, Join::getTypes())) {
            $result->configureJoinType($this->joinType);
        }

        return $result;
    }
}
