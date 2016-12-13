<?php
final class Gallery_UploadImage extends GWF_Method
{
	public function getHTAccess()
	{
		return "RewriteRule add_gallery_image/? index.php?mo=Gallery&me=UploadImage [QSA]".PHP_EOL;
	}

	public function execute()
	{

	}
}
