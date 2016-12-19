<?php
final class Gallery_Gallery extends GWF_Method
{
	private $user;
	private $gallery;
	private $creator;
	private $numImages;
	private $images;
	private $table;

	public function getHTAccess()
	{
		return "RewriteRule gallery/([0-9]+)/? index.php?mo=Gallery&me=Gallery&id=$1 [QSA]".PHP_EOL;
	}

	public function execute()
	{
		if (false !== ($error = $this->sanitize()))
		{
			return $error;
		}
		return $this->templateGallery();
	}
	
	private function sanitize()
	{
		$this->user = GWF_User::getStaticOrGuest();
		if (!($this->gallery = GWF_Gallery::getByID(Common::getGet('id'))))
		{
			return $this->module->error('err_gallery');
		}
		
		if (!($this->creator = $this->gallery->getCreator()))
		{
			return $this->module->error('err_creator');
		}
		
		if (!$this->gallery->hasPermission($this->user))
		{
			return GWF_HTML::err('ERR_PERMISSION');
		}
		
		$this->table = GDO::table('GWF_GalleryImage');
		$where = sprintf('gi_gid=%s AND gi_deleted_at IS NULL', $this->gallery->getID());
		$this->numImages = $this->table->countRows($where);
		if (!($this->images = $this->table->select('*', $where)))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		return false;
	}

	private function templateGallery()
	{
		$tVars = array(
			'user' => $this->user,
			'gallery' => $this->gallery,
			'images' => $this->images,
			'table' => $this->table,
			'numImages' => $this->numImages,
		);
		return $this->module->template('gallery.php', $tVars);
	}
}
