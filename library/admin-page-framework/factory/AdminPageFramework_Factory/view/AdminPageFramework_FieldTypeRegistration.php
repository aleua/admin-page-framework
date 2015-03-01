<?php
/**
 Admin Page Framework v3.5.4b06 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
class AdminPageFramework_FieldTypeRegistration {
    static protected $aDefaultFieldTypeSlugs = array('default', 'text', 'number', 'textarea', 'radio', 'checkbox', 'select', 'hidden', 'file', 'submit', 'import', 'export', 'image', 'media', 'color', 'taxonomy', 'posttype', 'size', 'section_title', 'system',);
    static public function register($aFieldTypeDefinitions, $sExtendedClassName, $oMsg) {
        foreach (self::$aDefaultFieldTypeSlugs as $_sFieldTypeSlug) {
            $_sFieldTypeClassName = "AdminPageFramework_FieldType_{$_sFieldTypeSlug}";
            if (!class_exists($_sFieldTypeClassName)) {
                continue;
            }
            $_oFieldType = new $_sFieldTypeClassName($sExtendedClassName, null, $oMsg, false);
            foreach ($_oFieldType->aFieldTypeSlugs as $__sSlug) {
                $aFieldTypeDefinitions[$__sSlug] = $_oFieldType->getDefinitionArray();
            }
        }
        return $aFieldTypeDefinitions;
    }
    static private $_aLoadFlags = array();
    static public function _setFieldResources(array $aField, $oProp, &$oResource) {
        $_sFieldType = $aField['type'];
        self::$_aLoadFlags[$oProp->_sPropertyType] = isset(self::$_aLoadFlags[$oProp->_sPropertyType]) && is_array(self::$_aLoadFlags[$oProp->_sPropertyType]) ? self::$_aLoadFlags[$oProp->_sPropertyType] : array();
        if (isset(self::$_aLoadFlags[$oProp->_sPropertyType][$_sFieldType]) && self::$_aLoadFlags[$oProp->_sPropertyType][$_sFieldType]) {
            return;
        }
        self::$_aLoadFlags[$oProp->_sPropertyType][$_sFieldType] = true;
        if (!isset($oProp->aFieldTypeDefinitions[$_sFieldType])) {
            return;
        }
        self::_initializeFieldType($_sFieldType, $oProp);
        self::_setInlineResources($_sFieldType, $oProp);
        self::_enqueueReoucesByTyoe($oProp->aFieldTypeDefinitions[$_sFieldType]['aEnqueueStyles'], $oResource, 'style');
        self::_enqueueReoucesByTyoe($oProp->aFieldTypeDefinitions[$_sFieldType]['aEnqueueScripts'], $oResource, 'script');
    }
    static private function _initializeFieldType($_sFieldType, $oProp) {
        if (is_callable($oProp->aFieldTypeDefinitions[$_sFieldType]['hfFieldSetTypeSetter'])) {
            call_user_func_array($oProp->aFieldTypeDefinitions[$_sFieldType]['hfFieldSetTypeSetter'], array($oProp->_sPropertyType));
        }
        if (is_callable($oProp->aFieldTypeDefinitions[$_sFieldType]['hfFieldLoader'])) {
            call_user_func_array($oProp->aFieldTypeDefinitions[$_sFieldType]['hfFieldLoader'], array());
        }
    }
    static private function _setInlineResources($_sFieldType, $oProp) {
        if (is_callable($oProp->aFieldTypeDefinitions[$_sFieldType]['hfGetScripts'])) {
            $oProp->sScript.= call_user_func_array($oProp->aFieldTypeDefinitions[$_sFieldType]['hfGetScripts'], array());
        }
        if (is_callable($oProp->aFieldTypeDefinitions[$_sFieldType]['hfGetStyles'])) {
            $oProp->sStyle.= call_user_func_array($oProp->aFieldTypeDefinitions[$_sFieldType]['hfGetStyles'], array());
        }
        if (is_callable($oProp->aFieldTypeDefinitions[$_sFieldType]['hfGetIEStyles'])) {
            $oProp->sStyleIE.= call_user_func_array($oProp->aFieldTypeDefinitions[$_sFieldType]['hfGetIEStyles'], array());
        }
    }
    static private function _enqueueReoucesByTyoe(array $aResources, $oResource, $sType) {
        $_aMethodNames = array('script' => '_forceToEnqueueScript', 'style' => '_forceToEnqueueStyle',);
        if (!isset($_aMethodNames[$sType])) {
            return;
        }
        foreach ($aResources as $asSource) {
            if (is_string($asSource)) {
                call_user_func_array(array($oResource, $_aMethodNames[$sType]), array($asSource));
            } else if (is_array($asSource) && isset($asSource['src'])) {
                call_user_func_array(array($oResource, $_aMethodNames[$sType]), array($asSource['src'], $asSource));
            }
        }
    }
}