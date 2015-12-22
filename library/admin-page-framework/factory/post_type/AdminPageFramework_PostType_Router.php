<?php
/**
 Admin Page Framework v3.7.6b04 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
abstract class AdminPageFramework_PostType_Router extends AdminPageFramework_Factory {
    public function _isInThePage() {
        if (!$this->oProp->bIsAdmin) {
            return false;
        }
        if ($this->oUtil->getElement($this->oProp->aPostTypeArgs, 'public', true) && $this->oProp->bIsAdminAjax) {
            return true;
        }
        if (!in_array($this->oProp->sPageNow, array('edit.php', 'edit-tags.php', 'post.php', 'post-new.php'))) {
            return false;
        }
        return ($this->oUtil->getCurrentPostType() == $this->oProp->sPostType);
    }
}