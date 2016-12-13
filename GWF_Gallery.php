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
			'g_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::UNIQUE, GDO::NOT_NULL, 63),
			'g_user_id' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'g_created_at' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'g_deleted_at' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
				
//  			'g_access' => GWF_ACL::gdoDefine(),
				
			'creator' => array(GDO::JOIN, GDO::NULL, array('GWF_User', 'user_id', 'g_user_id')),
		);
	}
}
