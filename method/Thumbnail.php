<?php
final class Gallery_Thumbnail extends GWF_Method
{
	private $user;
	private $gallery;
	private $image;

	public function getHTAccess()
	{
		return "RewriteRule gallery_thumbnail/([0-9]+)/? index.php?mo=Gallery&me=Thumbnail&id=$1 [QSA]".PHP_EOL;
	}

	public function execute()
	{
		if (false !== ($error = $this->sanitize()))
		{
			return $error;
		}
		return $this->renderThumbnail();
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

	private function renderThumbnail()
	{
		if (!$this->cacheThumbnail())
		{
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}
		
		GWF_Image::render($this->image->thumbnailPath());
		die(0);
	}
	
	private function cacheThumbnail()
	{
		if (!GWF_File::isFile($this->image->thumbnailPath()))
		{
			GWF_File::createDir(dirname($this->image->thumbnailPath()));
			$image = GWF_Image::fromPath($this->image->imagePath());
			$w = $this->module->cfgThumbWidth();
			$h = $this->module->cfgThumbHeight();
			$image = GWF_Image::resize($image, $w, $h, $w, $h);
			imagejpeg($image, $this->image->thumbnailPath());
		}
		return true;
	}
}

