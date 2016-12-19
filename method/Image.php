<?php
final class Gallery_Image extends GWF_Method
{
	private $user;
	private $gallery;
	private $image;

	public function getHTAccess()
	{
		return "RewriteRule gallery_image/([0-9]+)/? index.php?mo=Gallery&me=Image&id=$1 [QSA]".PHP_EOL;
	}

	public function execute()
	{
		if (false !== ($error = $this->sanitize()))
		{
			return $error;
		}
		return $this->renderImage();
	}

	private function sanitize()
	{
		$this->user = GWF_User::getStaticOrGuest();
		if (!($this->image = GWF_GalleryImage::getByID(Common::getGet('id'))))
		{
			return $this->module->error('err_gallery_image');
		}
		
		if (!($this->gallery = GWF_Gallery::getByID($this->image->getGalleryID())))
		{
			return $this->module->error('err_gallery');
		}
		
		if (!$this->gallery->hasPermission($this->user))
		{
			return GWF_HTML::err('ERR_PERMISSION');
		}
		return false;
	}

	private function renderImage()
	{
		
	}

}
