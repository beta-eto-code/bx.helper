<?php

namespace Bx\Helper\Interfaces;

use Bitrix\Main\Entity\DataManager;

interface JoinRuntimeInterface extends RuntimeInterface
{
    /**
     * @param string|DataManager $entityClass
     * @param string $linkedField
     * @return JoinRuntimeInterface
     * @psalm-suppress MismatchingDocblockParamType
     */
    public function setTarget(string $entityClass, string $linkedField): JoinRuntimeInterface;

    /**
     * @param string $field
     * @return JoinRuntimeInterface
     */
    public function setForeignKey(string $field): JoinRuntimeInterface;

    /**
     * @param string $type
     * @return JoinRuntimeInterface
     */
    public function setJoinType(string $type): JoinRuntimeInterface;

    /**
     * @return ConditionTreeInterface
     */
    public function getCondition();
}
