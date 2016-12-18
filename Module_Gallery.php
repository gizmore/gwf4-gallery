<?php
/**
 * Image gallery module.
 * @author gizmore
 * @license MIT
 */
final class Module_Gallery extends GWF_Module
{
	##############
	### Module ###
	##############
	public function getVersion() { return 4.00; }
	public function getDefaultPriority() { return 50; }
	public function getDefaultAutoLoad() { return true; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/gallery'); }
	public function getClasses() { return array('GWF_Gallery', 'GWF_GalleryImage'); }
	public function onInstall($dropTable) { require_once 'GWF_InstallGallery.php'; return GWF_InstallGallery::onInstall($this, $dropTable); }
	
	##############
	### Config ###
	##############
	public function cfgMaxGalleries() { return $this->getModuleVarInt('galleries_per_user'); }
	public function cfgAllowGuestGalleries() { return $this->getModuleVarBool('gallery_guests'); }
	public function cfgMaxImageSize() { return $this->getModuleVarInt('gallery_image_size'); }
	public function cfgMaxImageWidth() { return $this->getModuleVarInt('gallery_image_width'); }
	public function cfgMaxImageHeight() { return $this->getModuleVarInt('gallery_image_height'); }
	
	############
	### Path ###
	############
	public function galleryPath() { return GWF_PATH.'dbimg/gallery'; }
	
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
