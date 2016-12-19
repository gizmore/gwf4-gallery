<?php
$user = GWF_Session::getUser();
$headers = array(
		array($lang->lang('th_g_id'), 'g_id'),
		array($lang->lang('th_g_created_at'), 'g_created_at'),
		array($lang->lang('th_g_name'), 'g_name'),
		array($lang->lang('th_user_name'), 'owner.user_name'),
		array($lang->lang('th_images'), 'num_images'),
		array(), # actions
);

echo $page_menu;

echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);

while ($gallery = $table->fetch($galleries, GDO::ARRAY_O))
{
	$gallery instanceof GWF_Gallery;

	$buttons = '';
	// 	$buttons .= GWF_Button::generic($lang->lang('btn_quit'), $friendship->hrefCancel());

	echo GWF_Table::rowStart();
	echo GWF_Table::column($gallery->getID(), 'gwf-num');
	echo GWF_Table::column($gallery->displayDate(), 'gwf-date');
	echo GWF_Table::column($gallery->displayNameLinkShow(), 'gwf-label');
	echo GWF_Table::column($gallery->displayCreatorNameLinkProfile(), 'gwf-label');
	echo GWF_Table::column($gallery->getVar('num_images'), 'gwf-num');
	echo GWF_Table::column($buttons, 'gwf-buttons');
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();

echo GWF_Button::add($lang->lang('btn_create_gallery'), $href_create_gallery);
echo GWF_Button::generic($lang->lang('btn_my_galleries'), $href_my_galleries);
