<?php
final class GWF_InstallGallery
{
	public static function onInstall(Module_Gallery $module, $dropTables)
	{
		return GWF_ModuleLoader::installVars($module, array(
			'gallery_guests' => array('0', 'bool'),
// 			'pm_limit' => array('6', 'int', '-1', '100'),
// 			'pm_limit_timeout' => array('18 hours', 'time', '0', GWF_Time::ONE_WEEK),
// 			'pm_maxfolders' => array('50', 'int', '0', '256'),
// 			'pm_for_guests' => array(true, 'bool'),
// 			'pm_captcha' => array(true, 'bool'),
// 			'pm_causes_mail' => array(true, 'bool'),
// 			'pm_mail_sender' => array(GWF_BOT_EMAIL, 'text', '8', 255),
// 			'pm_bot_uid' => array('0', 'int', '0', '2199999999'),
// 			'pm_per_page' => array('25', 'int', 1, 255),
// 			'pm_sent' => array('0', 'script'),
// 			'pm_welcome' => array(true, 'bool'),
// 			'pm_sig_len' => array('255', 'int', 0, '65535'),
// 			'pm_msg_len' => array('2048', 'int', 1, '65535'),
// 			'pm_fname_len' => array(GWF_User::USERNAME_LENGTH+4, 'int', GWF_User::USERNAME_LENGTH, '96'),
// 			'pm_title_len' => array('64', 'int', 1, '1024'),
// 			'pm_delete' => array(true, 'bool'),
// 			'pm_own_bot' => array(false, 'bool'),
// 			'pm_limit_per_level' => array('0', 'int', 0, 1000000),
		));
	}
}