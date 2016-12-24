<?php
/**
 * Image gallery module.
 * 
 * @author gizmore
 * @license MIT
 */
final class Module_Gallery extends GWF_Module
{
	##############
	### Module ###
	##############
	public function getVersion() { return 4.01; }
	public function getDefaultPriority() { return 50; }
	public function getDefaultAutoLoad() { return true; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/gallery'); }
	public function getClasses() { return array('GWF_Gallery', 'GWF_GalleryImage'); }
	public function onInstall($dropTable) { require_once 'GWF_InstallGallery.php'; return GWF_InstallGallery::onInstall($this, $dropTable); }
	
	##############
	### Config ###
	##############
	public function cfgMaxGalleries() { return $this->getModuleVarInt('galleries_per_user', '-1'); }
	public function cfgAllowGuestGalleries() { return $this->getModuleVarBool('gallery_guests', '1'); }
	public function cfgMaxImageSize() { return $this->getModuleVarInt('gallery_image_size', '4096999'); }
	public function cfgMaxImageWidth() { return $this->getModuleVarInt('gallery_image_width', '4096'); }
	public function cfgMaxImageHeight() { return $this->getModuleVarInt('gallery_image_height', '4096'); }
	public function cfgThumbWidth() { return $this->getModuleVarInt('gallery_thumb_width', '96'); }
	public function cfgThumbHeight() { return $this->getModuleVarInt('gallery_thumb_height', '96'); }
	
	############
	### Path ###
	############
	public function galleryPath() { return GWF_PATH.'dbimg/gallery'; }
	public function thumbnailPath() { return GWF_PATH.'dbimg/gallery_thumbnails'; }
	
	###############
	### Startup ###
	###############
	public function onStartup()
	{
	}

	###############
	### Sidebar ###
	###############
	public function sidebarContent($bar)
	{
		if ( ($user = GWF_Session::getUser()) || ($this->cfgAllowGuestGalleries()) )
		{
			if ($bar === 'right')
			{
				$this->onLoadLanguage();
				$tVars = array(
					'href_galleries' => GWF_WEB_ROOT.'galleries',
					'href_my_galleries' => GWF_WEB_ROOT.'my_galleries',
					'href_create_gallery' => GWF_WEB_ROOT.'create_gallery',
				);
				return $this->template('gallery-sidebar.php', $tVars);
			}
		}
	}
}
