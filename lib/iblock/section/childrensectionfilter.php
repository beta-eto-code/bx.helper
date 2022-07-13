<?php

namespace Bx\Helper\Iblock\Section;

use Bitrix\Iblock\SectionTable;
use Bx\Helper\RuntimeFactory;
use Bx\Helper\Utils\Helper;

class ChildrenSectionFilter
{
    /**
     * @param  array  $params
     * @param  string $sectionCode
     * @return void
     */
    public static function update(array &$params, string $sectionCode)
    {
        $stateFilter = Helper::getOneOfStateStringKey(['=ROOT.CODE', 'ROOT.CODE'], $params['filter']);
        if (!$stateFilter->isSuccess()) {
            $params['filter']['=ROOT.CODE'] = $sectionCode;
        } else {
            $stateFilter->setValue($sectionCode);
        }

        $joinRuntime = RuntimeFactory::createJoin(
            'IBLOCK_ID',
            SectionTable::class,
            'IBLOCK_ID'
        );
        $joinRuntime->getCondition()
            ->where('this.LEFT_MARGIN', '<=', 'this.LEFT_MARGIN')
            ->where('this.RIGHT_MARGIN', '>=', 'this.RIGHT_MARGIN');

        $rootRuntime = $joinRuntime->compile('ROOT');
        $stateRuntime = Helper::getStateStringKey('ROOT', $params['runtime']);
        if (!$stateRuntime->isSuccess()) {
            $params['runtime']['ROOT'] = $rootRuntime;
        } else {
            $stateRuntime->setValue($rootRuntime);
        }
    }
}
