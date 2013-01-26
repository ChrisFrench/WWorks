<?php

/**
 *
 * Error view
 *
 * @version             1.0.0
 * @package             Gavern Framework
 * @copyright			Copyright (C) 2010 - 2011 GavickPro. All rights reserved.
 *               
 */
 
// No direct access.
defined('_JEXEC') or die;

$uri = JURI::getInstance();
jimport('joomla.factory');

// get necessary template parameters
$templateParams = JFactory::getApplication()->getTemplate(true)->params;
if($templateParams->get('webmaster_contact_type') != 'none') {
     // get the webmaster e-mail value
     $webmaster_contact = $templateParams->get('webmaster_contact', '');
     if($templateParams->get('webmaster_contact_type') == 'email') {
          // e-mail cloak
          $searchEmail = '([\w\.\-]+\@(?:[a-z0-9\.\-]+\.)+(?:[a-z0-9\-]{2,4}))';
          $searchText = '([\x20-\x7f][^<>]+)';
          $pattern = '~(?:<a [\w "\'=\@\.\-]*href\s*=\s*"mailto:' . $searchEmail . '"[\w "\'=\@\.\-]*)>' . $searchText . '</a>~i';   
          preg_match($pattern, '<a href="mailto:'.$webmaster_contact.'">'.JText::_('TPL_GK_LANG_CONTACT_WEBMASTER').'</a>', $regs, PREG_OFFSET_CAPTURE);
          $replacement = JHtml::_('email.cloak', $regs[1][0], 1, $regs[2][0], 0);
          $webmaster_contact_email = substr_replace($webmaster_contact, $replacement, $regs[0][1], strlen($regs[0][0]));
     }
}
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
<title><?php echo $this->error->getCode(); ?>-<?php echo $this->title; ?></title>
<link rel="stylesheet" href="<?php echo JURI::base(); ?>templates/<?php echo $this->template; ?>/css/system/error.css" type="text/css" />
</head>
<body>
<div id="gkPageWrap">
      <?php if ($logo_type !=='none'): ?>
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
    <?php endif; ?>
      <div id="frame">
            <div id="errorNumber">
                  <h1><?php echo $this->error->getCode(); ?></h1>
                  <h2><?php echo $this->error->getMessage(); ?></h2>
            </div>
            <div id="errorboxbody">
                  <p><strong><?php echo JText::_('JERROR_LAYOUT_NOT_ABLE_TO_VISIT'); ?></strong></p>
                  <ol>
                        <li><?php echo JText::_('JERROR_LAYOUT_AN_OUT_OF_DATE_BOOKMARK_FAVOURITE'); ?></li>
                        <li><?php echo JText::_('JERROR_LAYOUT_SEARCH_ENGINE_OUT_OF_DATE_LISTING'); ?></li>
                        <li><?php echo JText::_('JERROR_LAYOUT_MIS_TYPED_ADDRESS'); ?></li>
                        <li><?php echo JText::_('JERROR_LAYOUT_YOU_HAVE_NO_ACCESS_TO_THIS_PAGE'); ?></li>
                        <li><?php echo JText::_('JERROR_LAYOUT_REQUESTED_RESOURCE_WAS_NOT_FOUND'); ?></li>
                        <li><?php echo JText::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></li>
                  </ol>
                  <p><strong><?php echo JText::_('JERROR_LAYOUT_PLEASE_TRY_ONE_OF_THE_FOLLOWING_PAGES'); ?></strong></p>
                  <ol>
                        <li>
                              <a href="<?php echo $this->baseurl; ?>/index.php" title="<?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?>"><?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?></a>
                        </li>
                        <?php if($templateParams->get('webmaster_contact_type') == 'email') :
                              echo '<li>' . $webmaster_contact_email . '</li>';
                         ?>
                         <?php elseif($templateParams->get('webmaster_contact_type') == 'url') : ?>
                              <li><a href="<?php echo $webmaster_contact; ?>"><?php  echo JText::_('TPL_GK_LANG_CONTACT_WEBMASTER'); ?></a></li>
                         <?php endif; ?>

                  </ol>
            </div>
      </div>
</div>
</body>
</html>