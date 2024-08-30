<?php
AddEventHandler('iblock', 'OnAfterIBlockElementAdd','addLog');
AddEventHandler('iblock', 'OnAfterIBlockElementUpdate', 'addLog');
function addLog(&$arFields)
    {
        $logIBlockCode = 'LOG';
        $logIBlockId = \Bitrix\Iblock\IblockTable::getList(['filter'=>['CODE'=>$logIBlockCode]])->Fetch()["ID"];
        if($arFields['IBLOCK_ID'] == $logIBlockId){
            return;
        }
        $iblock = CIBlock::GetByID($arFields['IBLOCK_ID']);
        if($ar_res = $iblock->GetNext()){
            
        }
        $sectionName = $ar_res['NAME'];
        $sectionCode = $arFields['IBLOCK_CODE'];
        $section = CIBlockSection::GetList([], [
            'IBLOCK_ID' => $logIBlockId,
            'NAME' => $sectionName,
        ])->Fetch();
        if(!$section){
            $sectionId = new CIBlockSection();
            $sectionId->Add(['NAME' => $sectionName,'CODE' => $arFields['IBLOCK_CODE'], 'IBLOCK_ID' => $logIBlockId]);
        }
        $dbSection = CIBlockSection::GetList([], [
            'IBLOCK_ID' => $logIBlockId,
            'NAME' => $sectionName,
        ]);
        if ($arSection = $dbSection->Fetch()) {
            $sectionId = $arSection['ID'];
        }
        $res = CIBlockSection::GetByID($arFields['SECTION_ID']);
        if($ar_result = $res->GetNext()){}
        $el = new CIBlockElement();
        $PROP['DATE'] = date('d.m.Y');
        $arLoadProductArray = [
            "IBLOCK_ID" => $logIBlockId,
            "IBLOCK_SECTION_ID" => $arSection['ID'],
            "PROPERTY_VALUES" => $PROP,
            "NAME" => $arFields['ID'],
            "PREVIEW_TEXT" => $sectionName . "->" . $ar_result['NAME'] . "->" . $arFields['NAME'],
            "ACTIVE" => 'Y',
        ];
        $el->Add($arLoadProductArray);
        return true;
    }
?>