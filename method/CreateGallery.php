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
		$data['images'] = array(GWF_Form::FILE_IMGS, '', $m->lang('th_images'));
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
	
	public function onSave()
	{
		$m = $this->module;
		$form = $this->form();
		return $m->message();
	}
}
