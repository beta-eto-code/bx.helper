<?php

namespace Bx\Helper\Iblock\Element;

use Bitrix\Main\ORM\Query\Join;
use Bx\Helper\RuntimeFactory;
use Bx\Helper\Utils\Helper;
use Bitrix\Iblock\SectionTable;

class InSectionFilterByCode
{
    /**
     * @param  array    $params
     * @param  string[] $sectionsCode
     * @param  bool     $includeSubsections
     * @return void
     */
    public static function update(array &$params, array $sectionsCode, bool $includeSubsections = true)
    {
        if (!$includeSubsections) {
            if (!Helper::hasOneOfStringKey(['=IBLOCK_SECTION.CODE', 'IBLOCK_SECTION.CODE'], $params['filter'])) {
                $params['filter']['=IBLOCK_SECTION.CODE'] = $sectionsCode;
            }
            return;
        }

        if (!Helper::hasOneOfStringKey(['=ROOT.CODE', 'ROOT.CODE'], $params['filter'])) {
            $params['filter']['=ROOT.CODE'] = $sectionsCode;
        }

        if (!Helper::hasStringKey('ROOT', $params['runtime'])) {
            $joinRuntime = RuntimeFactory::createJoin(
                'IBLOCK_SECTION.IBLOCK_ID',
                SectionTable::class,
                'IBLOCK_ID'
            )->setJoinType(Join::TYPE_INNER);
            $joinRuntime->getCondition()
                ->where('this.LEFT_MARGIN', '<=', 'this.IBLOCK_SECTION.LEFT_MARGIN')
                ->where('this.RIGHT_MARGIN', '>=', 'this.IBLOCK_SECTION.RIGHT_MARGIN');

            $params['runtime']['ROOT'] = $joinRuntime->compile('ROOT');
        }
    }
}
