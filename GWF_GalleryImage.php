<?php
final class GWF_GalleryImage extends GDO
{
	const MIME_LENGTH = 128;
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
			'gi_gid' => array(GDO::UINT|GDO::INDEX),
			'gi_file_name' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, GDO::NOT_NULL, self::FILENAME_LENGTH),
			'gi_file_mime' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, self::MIME_LENGTH),
			'gi_file_size' => array(GDO::UINT, GDO::NOT_NULL),
			'gi_file_version' => array(GDO::TINY|GDO::UINT, GDO::NOT_NULL),
			'gi_uploaded_at' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'gi_deleted_at' => array(GDO::DATE, GDO::NULL, GWF_Date::LEN_SECOND),
				
			'gallery' => array(GDO::JOIN, GDO::NULL, array('GWF_Gallery', 'g_id', 'gi_gid')),
			'uploader' => array(GDO::JOIN, GDO::NULL, array('GWF_User', 'user_id', 'g_user_id')),
		);
	}
	
	##############
	### Static ###
	##############
	public static function getByID($id) { return self::table(__CLASS__)->selectFirstObject('*', 'gi_id='.((int)$id)); }

	############
	### Path ###
	############
	public function imagePath() { return GWF_PATH.'dbimg/gallery/'.$this->getGalleryID().'/'.$this->getFileName(); }
	public function thumbnailPath() { return GWF_PATH.'dbimg/gallery_thumbnails/'.$this->getGalleryID().'/'.$this->getFileName(); }
	
	############
	### Href ###
	############
	public function hrefImage() { return GWF_WEB_ROOT.'gallery_image/'.$this->getID().'-'.$this->getNameSEO(); }
	public function hrefThumbnail() { return GWF_WEB_ROOT.'gallery_thumbnail/'.$this->getID().'-'.$this->getThumbnailNameSEO(); }
	
	##############
	### Getter ###
	##############
	public function getID() { return $this->getVar('gi_id'); }
	public function getGalleryID() { return $this->getVar('gi_gid'); }
	public function getName() { $name = $this->getFileName(); return Common::rsubstrTo($name, '.', $name); }
	public function getFileName() { return $this->getVar('gi_file_name'); }
	public function getFileMime() { return $this->getVar('gi_file_mime'); }
	public function getFileSize() { return $this->getVar('gi_file_size'); }
	public function getFileVersion() { return $this->getVar('gi_file_version'); }
	public function getUploadedAt() { return $this->getVar('gi_uploaded_at'); }
	public function getDeletedAt() { return $this->getVar('gi_deleted_at'); }
	
	###########
	### SEO ###
	###########
	public function getNameSEO() { return GWF_HTML::urlencodeSEO($this->getFileName()); }
	public function getThumbnailNameSEO() { $name = $this->getNameSEO(); $postfix = Common::rsubstrFrom($name, '.'); $name = Common::rsubstrTo($name, '.'); return $name.'.thumb.'.$postfix; }
	
	###############
	### Display ###
	###############
	public function displayTitle() { return GWF_HTML::display($this->getName()); }
	public function displayDate() { return GWF_Time::displayDate($this->getUploadedAt()); }
	
}
