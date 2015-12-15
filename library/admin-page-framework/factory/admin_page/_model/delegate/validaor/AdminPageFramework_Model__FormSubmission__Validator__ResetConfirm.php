<?php
/**
 Admin Page Framework v3.7.4 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
class AdminPageFramework_Model__FormSubmission__Validator__ResetConfirm extends AdminPageFramework_Model__FormSubmission__Validator__Reset {
    public $sActionHookPrefix = 'try_validation_before_';
    public $iHookPriority = 20;
    public $iCallbackParameters = 5;
    public function _replyToCallback($aInputs, $aRawInputs, array $aSubmits, $aSubmitInformation, $oFactory) {
        $_bIsReset = ( bool )$this->_getPressedSubmitButtonData($aSubmits, 'is_reset');
        if (!$_bIsReset) {
            return;
        }
        add_filter("options_update_status_{$this->oFactory->oProp->sClassName}", array($this, '_replyToSetStatus'));
        $_oException = new Exception('aReturn');
        $_oException->aReturn = $this->_confirmSubmitButtonAction($this->getElement($aSubmitInformation, 'input_name'), $this->getElement($aSubmitInformation, 'section_id'), 'reset');
        throw $_oException;
    }
    public function _replyToSetStatus($aStatus) {
        return array('confirmation' => 'reset') + $aStatus;
    }
}