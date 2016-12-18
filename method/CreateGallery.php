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
		$this->form()->onFlowUpload();
		
		if (isset($_POST['save']))
		{
			return $this->onSave().$this->templateCreateGallery();
		}
		
		return $this->templateCreateGallery();
	}
	
	public function form()
	{
		$m = $this->module;
		$data = array();
		$data['name'] = array(GWF_Form::STRING, Common::getRequestString('name'), $m->lang('th_name'));
		$data['images'] = array(GWF_Form::FILE_IMAGES, '', $m->lang('th_images'), '', $this->fileUploadParameters());
		$data['save'] = array(GWF_Form::SUBMIT, $m->lang('btn_save'));
		return new GWF_Form($this, $data);
	}
	
	private function fileUploadParameters()
	{
		return array(
			'maxSize' => $this->module->cfgMaxImageSize(),
			'maxWidth' => $this->module->cfgMaxImageWidth(),
			'maxHeight' => $this->module->cfgMaxImageHeight(),
			'mimeTypes' => GWF_FormImage::$IMAGE_MIME_TYPES,
		);
	}
	
	public function templateCreateGallery()
	{
		$form = $this->form();
		$form->cleanup();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_create_gallery')),
		);
		return $this->module->template('create_gallery.php', $tVars);
	}
	
	##################
	### Validators ###
	##################
	public function validate_name(Module_Gallery $m, $arg)
	{
		$len = mb_strlen($arg);
		if ( ($len < 2) || ($len > 64) )
		{
			return $m->lang('err_name_length', array(2, 64));
		}

		return false;
	}
	
	public function validate_images(Module_Gallery $m, $arg)
	{
		var_dump($arg);
		$form = $this->form();
		$files = $form->getVar('images');
		if (count($files) < 1)
		{
			return $m->lang('err_no_files_uploaded');
		}
		return false;
	}
	
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
			'g_created_at' => GWF_Time::getDate(),
			'g_deleted_at' => null,
		));
		
		if (!$gallery->insert())
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (!GWF_File::createDir($gallery->galleryPath()))
		{
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}
		
		$files = $form->getVar('images');
		foreach ($files as $flowFile)
		{
			$back .= $this->onSaveFile($gallery, $flowFile);
		}
		
		$form->cleanup();
		
		return $back.$m->message('msg_gallery_created');
	}

	private function onSaveFile(GWF_Gallery $gallery, array $flowFile)
	{
		$image = new GWF_GalleryImage(array(
			'gi_id' => '0',
			'gi_gid' => $gallery->getID(),
			'gi_file_name' => $flowFile['name'],
			'gi_file_mime' => $flowFile['mime'],
			'gi_file_size' => $flowFile['size'],
			'gi_file_version' => '1',
			'gi_uploaded_at' => GWF_Time::getDate(),
			'gi_deleted_at' => null,
		));
		
		if (!@copy($flowFile['path'], $image->galleryImagePath()))
		{
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}
		
		if (!$image->insert())
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return '';
	}
}
