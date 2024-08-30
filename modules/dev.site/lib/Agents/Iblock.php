<?php

namespace Only\Site\Agents;


class Iblock
{
    public static function clearOldLogs()
    {
        if (\Bitrix\Main\Loader::includeModule('iblock')) {
            
            $elements = [];
            $res = CIBlockElement::GetList(
                ['DATE_CREATE' => 'DESC'], 
                ['IBLOCK_CODE' => 'LOG'], 
                false,
                ['nPageSize' => 0],
                ['ID', 'DATE_CREATE']
            );
        
            while ($element = $res->Fetch()) {
                $elements[] = $element['ID'];
            }
        
            
            $elementsToDelete = array_slice($elements, 10);
        
            
            foreach ($elementsToDelete as $element['ID']) {
                CIBlockElement::Delete($element['ID']);
            }
        }
    
        
    
        return '\\' . __CLASS__ . '::' . __FUNCTION__ . '();';
    }
    

    public static function example()
    {
        global $DB;
        if (\Bitrix\Main\Loader::includeModule('iblock')) {
            $iblockId = \Only\Site\Helpers\IBlock::getIblockID('QUARRIES_SEARCH', 'SYSTEM');
            $format = $DB->DateFormatToPHP(\CLang::GetDateFormat('SHORT'));
            $rsLogs = \CIBlockElement::GetList(['TIMESTAMP_X' => 'ASC'], [
                'IBLOCK_ID' => $iblockId,
                '<TIMESTAMP_X' => date($format, strtotime('-1 months')),
            ], false, false, ['ID', 'IBLOCK_ID']);
            while ($arLog = $rsLogs->Fetch()) {
                \CIBlockElement::Delete($arLog['ID']);
            }
        }
        return '\\' . __CLASS__ . '::' . __FUNCTION__ . '();';
    }
}
