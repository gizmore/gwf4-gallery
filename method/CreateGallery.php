<?php
final class Gallery_CreateGallery extends GWF_Method
{
	public function isLoginRequired()
	{
		return !$this->module->cfgAllowGuestGalleries();
	}

	public function getHTAccess()
	{
		return "RewriteRule create_gallery/? index.php?mo=Gallery&me=CreateGallery [QSA]".PHP_EOL;
	}
	
	public function execute()
	{
		$form = $this->form();
		$form->onFlowUpload();
		
// 		if (false !== ($error = $this->sanitize())
// 		{
// 			return $error;
// 		}
		
		if (isset($_POST['save']))
		{
			$back = $this->onSave();
			$form->cleanup();
			return $back;
		}
		
		return $this->templateCreateGallery();
	}
	
	public function form()
	{
		$m = $this->module;
		$data = array();
		$data['name'] = array(GWF_Form::STRING, Common::getRequestString('name'), $m->lang('th_name'));
		$data['images'] = array(GWF_Form::FILE_IMAGES, '', $m->lang('th_images'));
		$data['save'] = array(GWF_Form::SUBMIT, $m->lang('btn_save'));
		return new GWF_Form($this, $data);
	}
	
	public function templateCreateGallery()
	{
		$form = $this->form();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_create_gallery')),
		);
		return $this->module->template('create_gallery.php', $tVars);
	}
	
	##################
	### Validators ###
	##################
	// 	public function validate_images(Module_Gallery $m, $arg)
	// 	{
	
	// 	}
	
	############
	### Save ###
	############
	public function onSave()
	{
		$m = $this->module;
		$user = GWF_User::getStaticOrGuest();
		$form = $this->form();
		$back = '';
		
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error;
		}
		
		$gallery = new GWF_Gallery(array(
			'g_id' => '0',
			'g_name' => $form->getVar('name'),
			'g_user_id' => $user->getID(),
			'g_created_at' => $now,
			'g_deleted_at' => null,
		));
		
		if (!$gallery->insert())
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$files = $form->getVar('images');
		foreach ($files as $flowFile)
		{
			$back .= $this->onSaveFile($gallery, $flowFile);
		}
		
		return $back.$m->message('msg_gallery_created');
	}
	
	private function onSaveFile(GWF_Gallery $gallery, array $flowFile)
	{
		
	}
}
