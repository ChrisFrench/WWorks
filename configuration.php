<?php
class JConfig {
	public $offline = '0';
	public $offline_message = 'This site is down for maintenance.<br /> Please check back again soon.';
	public $display_offline_message = '1';
	public $offline_image = '';
	public $sitename = 'Wayans Works';
	public $editor = 'tinymce';
	public $captcha = '0';
	public $list_limit = '20';
	public $access = '1';
	public $debug = '0';
	public $debug_lang = '0';
	public $dbtype = 'mysqli';
<<<<<<< HEAD
	public $host = 'mysql51-028.wc2.dfw1.stabletransit.com';
	public $user = '789326_wayans';
	public $password = 'F0rgetting01';
	public $db = '789326_wayans';
=======
	public $host = 'localhost';
	public $user = 'root';
	public $password = 'F0rgetting01';
	public $db = 'wayansworks';
>>>>>>> 939b46ef696acfd287fe6ab5521657eab5527828
	public $dbprefix = 'msivr_';
	public $live_site = '';
	public $secret = 'yqHltNlJqDCw06CW';
	public $gzip = '0';
	public $error_reporting = 'maximum';
	public $helpurl = 'http://help.joomla.org/proxy/index.php?option=com_help&keyref=Help{major}{minor}:{keyref}';
	public $ftp_host = '127.0.0.1';
	public $ftp_port = '21';
	public $ftp_user = '';
	public $ftp_pass = '';
	public $ftp_root = '';
	public $ftp_enable = '0';
	public $offset = 'UTC';
	public $mailer = 'mail';
	public $mailfrom = 'chris@ammonitenetworks.com';
	public $fromname = 'Wayans Works';
	public $sendmail = '/usr/sbin/sendmail';
	public $smtpauth = '0';
	public $smtpuser = '';
	public $smtppass = '';
	public $smtphost = 'localhost';
	public $smtpsecure = 'none';
	public $smtpport = '25';
	public $caching = '0';
	public $cache_handler = 'file';
	public $cachetime = '15';
	public $MetaDesc = '';
	public $MetaKeys = '';
	public $MetaTitle = '1';
	public $MetaAuthor = '1';
	public $MetaVersion = '0';
	public $robots = '';
	public $sef = '1';
	public $sef_rewrite = '1';
	public $sef_suffix = '0';
	public $unicodeslugs = '0';
	public $feed_limit = '10';
<<<<<<< HEAD
	public $log_path = '/mnt/stor2-wc2-dfw1/441462/789326/www.wayansworks.com/web/content/logs';
	public $tmp_path = '/mnt/stor2-wc2-dfw1/441462/789326/www.wayansworks.com/web/content/tmp';
=======
	public $log_path = '/var/projects/wworks/logs';
	public $tmp_path = '/var/projects/wworks/tmp';
>>>>>>> 939b46ef696acfd287fe6ab5521657eab5527828
	public $lifetime = '15';
	public $session_handler = 'database';
	public $MetaRights = '';
	public $sitename_pagetitles = '0';
	public $force_ssl = '0';
	public $feed_email = 'author';
	public $cookie_domain = '';
	public $cookie_path = '';
}