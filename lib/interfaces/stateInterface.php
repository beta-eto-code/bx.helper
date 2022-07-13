<?php

namespace Bx\Helper\Interfaces;

interface StateInterface
{
    /**
     * @return array|null
     */
    public function getParent(): ?array;

    /**
     * @return mixed
     */
    public function getKey();

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param mixed $value
     * @return bool
     */
    public function setValue($value): bool;

    /**
     * @param string $key
     * @return bool
     */
    public function hasStringKeyInParent(string $key): bool;

    /**
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function hasStringKeyWithValueInParent(string $key, $value): bool;

    /**
     * @param string $key
     * @return StateInterface
     */
    public function getStateStringKeyInParent(string $key): StateInterface;

    /**
     * @return bool
     */
    public function isSuccess(): bool;

    /**
     * @return int
     */
    public function getDepthLevel(): int;
}
