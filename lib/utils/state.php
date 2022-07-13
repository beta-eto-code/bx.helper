<?php

namespace Bx\Helper\Utils;

use Bx\Helper\Interfaces\StateInterface;

class State implements StateInterface
{
    private ?string $key;
    private ?array $parent;
    private int $depthLevel;

    /**
     * @param string|null $key
     * @param array|null $parent
     * @param int $depthLevel
     */
    public function __construct(?string $key = null, ?array &$parent = null, int $depthLevel = 0)
    {
        $this->key = $key;
        $this->parent = $parent;
        $this->depthLevel = $depthLevel;
    }

    /**
     * @return array|null
     */
    public function getParent(): ?array
    {
        return $this->parent;
    }

    /**
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @return mixed|null
     */
    public function getValue()
    {
        if (empty($this->parent) || empty($this->key)) {
            return null;
        }

        return $this->parent[$this->key] ?? null;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function setValue($value): bool
    {
        if (empty($this->parent) || empty($this->key)) {
            return false;
        }

        $this->parent[$this->key] = $value;
        return true;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasStringKeyInParent(string $key): bool
    {
        return !empty($this->parent) && Helper::hasStringKey($key, $this->parent);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function hasStringKeyWithValueInParent(string $key, $value): bool
    {
        $state = $this->getStateStringKeyInParent($key);
        return $state->isSuccess() && $state->getValue() === $value;
    }

    /**
     * @param string $key
     * @return StateInterface
     */
    public function getStateStringKeyInParent(string $key): StateInterface
    {
        if (empty($this->parent)) {
            return new State($key);
        }

        return Helper::getStateStringKey($key, $this->parent);
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return !empty($this->key) && !empty($this->parent);
    }

    /**
     * @return int
     */
    public function getDepthLevel(): int
    {
        return $this->depthLevel;
    }
}
