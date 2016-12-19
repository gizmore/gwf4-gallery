<?php
final class GWF_Gallery extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'gallery'; }
	public function getColumnDefines()
	{
		return array(
			'g_id' => array(GDO::AUTO_INCREMENT),
			'g_name' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 127),
			'g_user_id' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
 			'g_access' => GWF_ACL::gdoDefine(GWF_ACL::PUBLIC),
			'g_created_at' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'g_deleted_at' => array(GDO::DATE, GDO::NULL, GWF_Date::LEN_SECOND),

			'creator' => array(GDO::JOIN, GDO::NULL, array('GWF_User', 'user_id', 'g_user_id')),
		);
	}
	
	##############
	### Static ###
	##############
	public static function getByID($id) { return self::table(__CLASS__)->selectFirstObject('*', 'g_id='.((int)$id)); }
	
	############
	### Path ###
	############
	public function galleryPath() { return GWF_PATH.'dbimg/gallery/'.$this->getID(); }
	
	############
	### Href ###
	############
	public function hrefShow() { return GWF_WEB_ROOT.'gallery/'.$this->getID(); }
	public function hrefCreatorProfile() { return GWF_WEB_ROOT.'profile/'.$this->getVar('user_name'); }
	
	##############
	### Getter ###
	##############
	public function getID() { return $this->getVar('g_id'); }
	public function getName() { return $this->getVar('g_name'); }
	public function getUserID() { return $this->getVar('g_user_id'); }
	public function getAccess() { return $this->getVar('g_access'); }
	public function getCreatedAt() { return $this->getVar('g_created_at'); }
	public function getDeletedAt() { return $this->getVar('g_deleted_at'); }
	
	###############
	### Display ###
	###############
	public function displayDate() { return GWF_Time::displayDate($this->getCreatedAt()); }
	public function displayName() { return GWF_HTML::display($this->getName()); }
	public function displayCreatorName() { return $this->getVar('user_name'); }
	public function displayNameLinkShow() { return GWF_HTML::anchor($this->hrefShow(), $this->displayName()); }
	public function displayCreatorNameLinkProfile() { return GWF_HTML::anchor($this->hrefCreatorProfile(), $this->displayCreatorName()); }
	
	###############
	### Creator ###
	###############
	public function getCreator() { return GWF_User::getByID($this->getUserID()); }
	
	##################
	### Permission ###
	##################
	public function hasPermission(GWF_User $user) { return GWF_ACL::hasPermission($user, $this->getUserID(), $this->getAccess()); }
	
}
