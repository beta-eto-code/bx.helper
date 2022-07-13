<?php

namespace Bx\Helper\Utils;

use Bx\Helper\Interfaces\StateInterface;

class Helper
{
    /**
     * @param  string $key
     * @param  array  $data
     * @return bool
     */
    public static function hasStringKey(string $key, array $data): bool
    {
        foreach ($data as $k => $value) {
            if ($k === $key) {
                return true;
            }

            if (is_array($value) && static::hasStringKey($key, $value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $key
     * @param array $data
     * @param mixed $value
     * @return bool
     */
    public static function hasStringKeyWithValue(string $key, array $data, $value): bool
    {
        return static::getStateStringKeyWithValue($key, $data, $value)->isSuccess();
    }

    /**
     * @param array $keys
     * @param array $data
     * @return bool
     */
    public static function hasOneOfStringKey(array $keys, array $data): bool
    {
        foreach ($keys as $key) {
            if (static::hasStringKey($key, $data)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $key
     * @param array $data
     * @param int $depthLevel
     * @return StateInterface
     */
    public static function getStateStringKey(string $key, array &$data, int $depthLevel = 0): StateInterface
    {
        foreach ($data as $k => &$value) {
            if ($k === $key) {
                /**
                 * @psalm-suppress ReferenceConstraintViolation
                 */
                return new State($key, $data, $depthLevel);
            }

            if (is_array($value)) {
                $state = static::getStateStringKey($key, $value, $depthLevel + 1);
                if ($state->isSuccess()) {
                    return $state;
                }
            }
        }

        return new State($key);
    }

    /**
     * @param array $keys
     * @param array $data
     * @param int $depthLevel
     * @return StateInterface
     */
    public static function getOneOfStateStringKey(array $keys, array &$data, int $depthLevel = 0): StateInterface
    {
        foreach ($keys as $key) {
            $state = static::getStateStringKey($key, $data, $depthLevel);
            if ($state->isSuccess()) {
                return $state;
            }
        }

        return new State();
    }

    /**
     * @param string $key
     * @param array $data
     * @param mixed $value
     * @param int $depthLevel
     * @return StateInterface
     */
    public static function getStateStringKeyWithValue(
        string $key,
        array &$data,
        $value,
        int $depthLevel = 0
    ): StateInterface {

        foreach ($data as $k => &$v) {
            if ($key === $k && $value === $v) {
                /**
                 * @psalm-suppress ReferenceConstraintViolation
                 */
                return new State($key, $data, $depthLevel);
            }

            if (is_array($v)) {
                $state = static::getStateStringKey($key, $v, $depthLevel + 1);
                if ($state->isSuccess() && $state->getValue() === $v) {
                    return $state;
                }
            }
        }

        return new State($key);
    }
}
