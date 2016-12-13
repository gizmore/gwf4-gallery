<?php
final class Gallery_Galleries extends GWF_Method
{
	private $user;
	private $ipp = 20;
	private $nItems = 0;
	private $nPages = 1;
	private $page = 1;
	private $orderby = 'g_created_at DESC';
	private $galleries = null;
	
	public function getHTAccess()
	{
		return
			"RewriteRule galleries/? index.php?mo=Gallery&me=Galleries [QSA]".PHP_EOL;
	}

	public function execute()
	{
		if (false !== ($error = $this->sanitize()))
		{
			return $error;
		}
		return $this->templateGalleries();
		
	}
	private function sanitize()
	{
		$this->user = GWF_User::getStaticOrGuest();
		if (!$this->user->isUser() || ($this->user->isGuest() && (!$this->module->cfgAllowGuestGalleries())) )
		{
			return GWF_HTML::err('ERR_PERMISSION');
		}
	
		$conditions = "g_deleted_at IS NULL";

		$table = GDO::table('GWF_Gallery');
		$this->orderby = $table->getMultiOrderby(Common::getGet('by'), Common::getGet('dir'));
		$this->nItems = $table->countRows($conditions);
		$this->nPages = GWF_PageMenu::getPagecount($this->ipp, $this->nItems);
		$this->page = Common::clamp(intval(Common::getGet('page')), 1, $this->nPages);
		$from = GWF_PageMenu::getFrom($this->page, $this->ipp);
		$this->galleries = $table->select('*', $conditions, $this->orderby, array('owner'), $this->ipp, $from);
		return false;
	}
	
	private function templateGalleries()
	{
		$hrefPage = GWF_WEB_ROOT.sprintf('friends?by=%s&dir=%s&page=%%PAGE%%', urlencode(Common::getGet('by')), urlencode(Common::getGet('dir')));
		$hrefSort = GWF_WEB_ROOT.'friends?by=%BY%&dir=%DIR%&page=1';
		$tVars = array(
			'table' => GDO::table('GWF_Gallery'),
			'galleries' => $this->galleries,
			'sort_url' => $hrefSort,
			'page_menu' => GWF_PageMenu::display($this->page, $this->nPages, $hrefPage),
			'href_add_gallery' => GWF_WEB_ROOT.'create_gallery',
			'href_my_galleries' => GWF_WEB_ROOT.'my_galleries',
		);
		return $this->module->template('galleries.php', $tVars);
	}
	
}
