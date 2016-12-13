<?php
final class GWF_GalleryImage extends GDO
{
	const MIME_LENGTH = 63;
	const FILENAME_LENGTH = 255;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'gallery_image'; }
	public function getColumnDefines()
	{
		return array(
			'gi_id' => array(GDO::AUTO_INCREMENT),
			'gi_file_name' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S|GDO::UNIQUE, GDO::NOT_NULL, self::FILENAME_LENGTH),
			'gi_file_mime' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::UNIQUE, GDO::NOT_NULL, self::MIME_LENGTH),
			'gi_file_size' => array(GDO::UINT, GDO::NOT_NULL),
			'gi_file_version' => array(GDO::TINY|GDO::UINT, GDO::NOT_NULL),
			'gi_uploaded_at' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'gi_deleted_at' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
		);
	}
}
