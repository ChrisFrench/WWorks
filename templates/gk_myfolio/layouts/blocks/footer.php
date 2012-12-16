<?php

// No direct access.
defined('_JEXEC') or die;
$tpl_name = str_replace(' ', '_', JText::_('TPL_GK_LANG_NAME'));
?>

<div id="gkFooterWrap">
      <div id="gkCopyrights">
            <?php if($this->modules('footer_nav')) : ?>
            <div id="gkFooterNav">
                  <jdoc:include type="modules" name="footer_nav" style="<?php echo $this->module_styles['footer_nav']; ?>" />
            </div>
            <?php endif; ?>
            <?php if($this->getParam('copyrights', '') !== '') : ?>
                <span>
        		<?php echo $this->getParam('copyrights', ''); ?>
        	 </span>
            <?php else : ?>
            	<span>
            	Template Design &copy; <a href="http://www.gavick.com" title="Joomla Templates">Joomla Templates</a> | GavickPro. All rights reserved.
            	</span>
            <?php endif; ?>
            
            <?php if(isset($_COOKIE['gkGavernMobile'.$tpl_name]) && 
	    	$_COOKIE['gkGavernMobile'.$tpl_name] == 'desktop') : ?>
            <span class="mobileSwitcher"><a href="javascript:setCookie('gkGavernMobile<?php echo $tpl_name; ?>', 'mobile', 365);window.location.reload();"><?php echo JText::_('TPL_GK_LANG_SWITCH_TO_MOBILE'); ?></a></span>
            <?php endif; ?>
            
            <?php if($this->getParam('stylearea', '0') == '1') : ?>
            <div id="gkStyleArea">
                  <div id="gkPatterns">
                        <a href="#" id="gkPattern1">pattern1</a>
                        <a href="#" id="gkPattern2">pattern2</a>
                        <a href="#" id="gkPattern3">pattern3</a>
                        <a href="#" id="gkPattern4">pattern4</a>
                        <a href="#" id="gkPattern5">pattern5</a>
                        <a href="#" id="gkPattern6">pattern6</a>
                        <a href="#" id="gkPattern7">pattern7</a>
                        <a href="#" id="gkPattern8">pattern8</a>
                  </div>
                  <div id="gkColors">
                        <a href="#" id="gkColor1">color1</a>
                        <a href="#" id="gkColor2">color2</a>
                        <a href="#" id="gkColor3">color3</a>
                  </div>
            </div>
            <?php endif; ?>
            
      </div>
</div>
<?php if($this->getParam('framework_logo', '0') == '1') : ?>
<div id="gkFrameworkLogo">Framework logo</div>
<?php endif; ?>
<?php $this->loadBlock('social'); ?>
