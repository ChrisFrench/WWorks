<?php

	// no direct access
	defined('_JEXEC') or die('Restricted access');

	$url = JURI::getInstance();	
	$user = JFactory::getUser();
	$userID = $user->get('id');
	$popup_class = '';
	
	if(!($this->modules('register') && $userID == 0)) {
		$popup_class = ' class="only-one"';
	}

?>

<?php if($this->modules('login')) : ?>		
<div id="loginForm"<?php echo $popup_class; ?>>
	<h3><?php echo JText::_(($userID == 0) ? 'TPL_GK_LANG_LOGIN' : 'TPL_GK_LANG_LOGOUT'); ?> <small><?php echo JText::_('TPL_GK_LANG_OR'); ?><a href="<?php echo $this->URLbase(); ?>index.php?option=com_users&amp;view=registration"><?php echo JText::_('TPL_GK_LANG_REGISTER'); ?></a></small></h3>
	<div class="clear overflow">
		<jdoc:include type="modules" name="login" style="<?php echo $this->module_styles['login']; ?>" />
	</div>
</div>
<?php endif; ?>	