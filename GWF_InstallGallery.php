<?php
final class GWF_InstallGallery
{
	public static function onInstall(Module_Gallery $module, $dropTables)
	{
		return GWF_ModuleLoader::installVars($module, array(
			'galleries_per_user' => array('-1', 'int', '-1', '100'),
			'gallery_guests' => array('0', 'bool'),
			'gallery_image_size' => array('2111222', 'int', '-1', '100000000'),
			'gallery_image_width' => array('2048', 'int', '1', '16348'),
			'gallery_image_height' => array('2048', 'int', '1', '16348'),
		)).
		self::createFolders($module, $dropTables);
	}
	
	private static function createFolders(Module_Gallery $module, $dropTables)
	{
		if ($dropTables)
		{
			GWF_File::removeDir($module->galleryPath());
			GWF_File::removeDir($module->thumbnailPath());
		}
		
		if (!GWF_File::createDir($module->galleryPath()))
		{
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}
		
		if (!GWF_File::createDir($module->thumbnailPath()))
		{
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}
		
		return '';
	}
}
