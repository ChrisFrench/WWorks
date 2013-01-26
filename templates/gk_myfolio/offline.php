<?php

/**
 *
 * offline view
 *
 * @version             1.0.0
 * @package             Gavern Framework
 * @copyright			Copyright (C) 2010 - 2011 GavickPro. All rights reserved.
 *               
 */
 
// No direct access.
defined('_JEXEC') or die;
jimport('joomla.factory');
$app = JFactory::getApplication();

$uri = JURI::getInstance();


// get necessary template parameters
$templateParams = JFactory::getApplication()->getTemplate(true)->params;
$pageName = JFactory::getDocument()->getTitle();

// get logo configuration
$logo_type = $templateParams->get('logo_type');
$logo_image = $templateParams->get('logo_image');

if(($logo_image == '') || ($templateParams->get('logo_type') == 'css')) {
     $logo_image = JURI::base() . '../images/logo.png';
} else {
     $logo_image = JURI::base() . $logo_image;
}
$logo_text = $templateParams->get('logo_text', '');
$logo_slogan = $templateParams->get('logo_slogan', '');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<jdoc:include type="head" />
<link rel="stylesheet" href="<?php echo JURI::base(); ?>templates/<?php echo $this->template; ?>/css/system/offline.css" type="text/css" />
<!--[if IE]>
	<style type="text/css">
	p#username input,
	p#password input { height:20px; width:240px; }
	
	input[type="submit"] { padding: 0 10px!important; height:20px; line-height:28px!important; }
	</style>
	<![endif]-->
</head>
<body>
<div id="gkPageWrap">
     <?php if ($logo_type !== 'none' && !$app->getCfg('offline_image')): ?>
              <?php if($logo_type == 'css') : ?>
                  <h1 id="gkLogo">
                       <a href="./" class="cssLogo"></a>
                  </h1>
              <?php elseif($logo_type =='text') : ?>
                  <h1 class="gkLogo text">
                      <a href="./">
                           <span><?php echo $logo_text; ?></span>
                           <small class="gkLogoSlogan"><?php echo $logo_slogan; ?></small>
                      </a>
                  </h1>
             <?php elseif($logo_type =='image') : ?>
                 <h1 id="gkLogo">
                       <a href="./">
                       <img src="<?php echo $logo_image; ?>" alt="<?php echo $pageName; ?>" />
                       </a>
                  </h1>
              <?php endif; ?>
         <?php else : ?>
              <?php if($app->getCfg('offline_image')) : ?>
              <h1 id="gkLogo">
                  <a href="./">
                        <img src="<?php echo $app->getCfg('offline_image'); ?>" alt="<?php echo $app->getCfg('sitename'); ?>" />
                   </a>
              </h1>
              <?php endif; ?>
         <?php endif; ?>
      <div id="frame">
            <jdoc:include type="message" />
            <h2><?php echo $app->getCfg('offline_message'); ?></h2>
            <form action="index.php" method="post" name="login" id="form-login">
                  <fieldset class="input">
                        <p id="username">
                              <label for="username"><?php echo JText::_('JGLOBAL_USERNAME') ?></label>
                              <br />
                              <input name="username" id="username" type="text" class="inputbox" alt="<?php echo JText::_('JGLOBAL_USERNAME') ?>" size="53" />
                        </p>
                        <p id="password">
                              <label for="passwd"><?php echo JText::_('JGLOBAL_PASSWORD') ?></label>
                              <br />
                              <input type="password" name="password" class="inputbox" size="53" alt="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" id="passwd" />
                        </p>
                        <!-- <p id="remember">
                              <input type="checkbox" name="remember" class="inputbox" value="yes" alt="<?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>" id="remember" />
                              <label for="remember"><?php echo JText::_('JGLOBAL_REMEMBER_ME') ?></label>
                        </p> -->
                        <div class="buttons">
                              <input type="submit" name="Submit" class="button" value="<?php echo JText::_('JLOGIN') ?>" />
                        </div>
                        <input type="hidden" name="option" value="com_users" />
                        <input type="hidden" name="task" value="user.login" />
                        <input type="hidden" name="return" value="<?php echo base64_encode(JURI::base()) ?>" />
                        <?php echo JHtml::_('form.token'); ?>
                  </fieldset>
            </form>
      </div>
</div>
</body>
</html>
