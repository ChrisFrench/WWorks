<?php
/**
 * @version		$Id: default_login.php 19713 2010-12-01 17:01:50Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.5
 */

defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<div class="login<?php echo $this->params->get('pageclass_sfx')?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
	<h1>
		<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
	<?php endif; ?>

	<gavern:mobile>
	<h3><?php echo JText::_('JLOGIN'); ?></h3>
	</gavern:mobile>

    <div id="gkLogin">
      <h2>Login</h2>
	<?php if ($this->params->get('logindescription_show') == 1 || $this->params->get('login_image') != '') : ?>
	<div class="login-description">
	<?php endif ; ?>

		<?php if($this->params->get('logindescription_show') == 1) : ?>
			<?php echo $this->params->get('login_description'); ?>
		<?php endif; ?>

		<?php if (($this->params->get('login_image')!='')) :?>
			<img src="<?php echo $this->params->get('login_image'); ?>" class="login-image" alt="<?php echo JTEXT::_('COM_USER_LOGIN_IMAGE_ALT')?>"/>
		<?php endif; ?>

	<?php if ($this->params->get('logindescription_show') == 1 || $this->params->get('login_image') != '') : ?>
	</div>
	<?php endif ; ?>

	<form action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post" id="com-login-form">

		<fieldset>
			<?php foreach ($this->form->getFieldset('credentials') as $field): ?>
				<?php if (!$field->hidden): ?>
					<div class="login-fields"><?php echo $field->label; ?>
					<?php echo $field->input; ?></div>
				<?php endif; ?>
			<?php endforeach; ?>
            <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
               <div class="login-fields">
                    <label id="remember-lbl" for="remember"><?php echo JText::_('JGLOBAL_REMEMBER_ME') ?></label>
                    <input id="remember" type="checkbox" name="remember" class="inputbox" value="yes"  alt="<?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>" />
               </div>
               <?php endif; ?>
		</fieldset>
		<button type="submit" class="button"><?php echo JText::_('JLOGIN'); ?></button>
        <gavern:fblogin><span id="fb-auth"><small>fb icon</small><?php echo JText::_('TPL_GK_LANG_FB_LOGIN_TEXT'); ?></span></gavern:fblogin>
		<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_url',$this->form->getValue('return'))); ?>" />
		<?php echo JHtml::_('form.token'); ?>
   </form>
    </div>
    <div id="gkReminder">
   <ul>
      <li>
         <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
         <?php echo JText::_('COM_USERS_LOGIN_RESET'); ?></a>
      </li>
      <li>
         <a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
         <?php echo JText::_('COM_USERS_LOGIN_REMIND'); ?></a>
      </li>
      <?php
      $usersConfig = JComponentHelper::getParams('com_users');
      if ($usersConfig->get('allowUserRegistration')) : ?>
      <li>
         <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
            <?php echo JText::_('COM_USERS_LOGIN_REGISTER'); ?></a>
      </li>
      <?php endif; ?>
   </ul>
   </div>
    
</div>