<?php

namespace Bx\Helper\Iblock\Element;

use Bx\Helper\Interfaces\ParamDecoratorInterface;
use Bitrix\Main\Type\DateTime;
use Bx\Helper\Utils\Helper;

class ActualIBElementFilter implements ParamDecoratorInterface
{
    /**
     * @param  array $params
     * @return void
     */
    public static function update(array &$params)
    {
        $filter = $params['filter'] ?? [];
        $nowDate = new DateTime();

        $activeState = Helper::getOneOfStateStringKey(['=ACTIVE', 'ACTIVE'], $filter);
        if ($activeState->isSuccess()) {
            $activeState->setValue('Y');
        } else {
            $filter['=ACTIVE'] = 'Y';
        }

        $activeFromState = Helper::getStateStringKey('<=ACTIVE_FROM', $filter);
        $hasActiveFromFilter = $activeFromState->isSuccess() &&
            $activeFromState->getDepthLevel() === 1 &&
            $activeFromState->hasStringKeyWithValueInParent('=ACTIVE_FROM', null) &&
            $activeFromState->hasStringKeyInParent('LOGIC') &&
            ($activeFromState->getParent()['LOGIC'] ?? null) === 'OR';

        if (!$hasActiveFromFilter) {
            $filter[] = [
                'LOGIC' => 'OR',
                '<=ACTIVE_FROM' => $nowDate,
                '=ACTIVE_FROM' => null,
            ];
        }

        $activeToState = Helper::getStateStringKey('>=ACTIVE_TO', $filter);
        $hasActiveToFilter = $activeToState->isSuccess() &&
            $activeToState->getDepthLevel() === 1 &&
            $activeToState->hasStringKeyWithValueInParent('=ACTIVE_TO', null) &&
            $activeToState->hasStringKeyInParent('LOGIC') &&
            ($activeToState->getParent()['LOGIC'] ?? null) === 'OR';

        if (!$hasActiveToFilter) {
            $filter[] = [
                'LOGIC' => 'OR',
                '>=ACTIVE_TO' => $nowDate,
                '=ACTIVE_TO' => null,
            ];
        }

        if (!empty($filter)) {
            $params['filter'] = $filter;
        }
    }
}
