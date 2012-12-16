<?php



/**

 *

 * Default view

 *

 * @version             1.0.0

 * @package             Gavern Framework

 * @copyright			Copyright (C) 2010 - 2011 GavickPro. All rights reserved.

 *               

 */

 

// No direct access.

defined('_JEXEC') or die;

if($this->getParam("cwidth_position", 'head') == 'head') {

$this->generateColumnsWidth();

}

$this->addCSSRule('.gkWrap { width: ' . $this->getParam('template_width','1240px') . '!important; }');

$this->addCSSRule('html { min-width: ' . $this->getParam('template_width','1240px') . '!important; }');



$tpl_page_suffix = '';



if($this->page_suffix != '') {

	$tpl_page_suffix = ' class="'.$this->page_suffix.'"';

}

$tpl_name = str_replace(' ', '_', JText::_('TPL_GK_LANG_NAME'));



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" 

	  xmlns:og="http://ogp.me/ns#" 

	  xmlns:fb="http://ogp.me/ns/fb#"

	  xml:lang="<?php echo $this->API->language; ?>" lang="<?php echo $this->API->language; ?>">

<head>

    

    <?php if($this->getParam("chrome_frame_support", '0') == '1') : ?>

    <meta http-equiv="X-UA-Compatible" content="chrome=1"/>

    <?php endif; ?>

    

    <meta http-equiv="X-UA-Compatible" content="IE=9" />



    

    <jdoc:include type="head" />

    <?php $this->loadBlock('head'); ?>

    <?php $this->loadBlock('cookielaw'); ?>

</head>

<body<?php echo $tpl_page_suffix; ?>>

	<!--[if IE 6]>

   <div id="gkInfobar"><a href="http://browsehappy.com"><?php echo JText::_('TPL_GK_LANG_IE6_BAR'); ?></a></div>

   <![endif]-->

	

    <?php if(isset($_COOKIE['gkGavernMobile'.$tpl_name]) &&

          $_COOKIE['gkGavernMobile'.$tpl_name] == 'desktop') : ?>

          <div class="mobileSwitch gkWrap">

        <a href="javascript:setCookie('gkGavernMobile<?php echo $tpl_name; ?>', 'mobile', 365);window.location.reload();"><?php echo JText::_('TPL_GK_LANG_SWITCH_TO_MOBILE'); ?></a>

         </div>

    <?php endif; ?>

       

	<?php $this->messages('message-position-1'); ?>

			

	<div id="gkPage" class="gkMain gkWrap">

		<div id="gkPageWrap">

	        <div id="gkPageTop" class="clearfix">

		        <?php $this->loadBlock('logo'); ?>

		       	<?php if($this->getParam('show_menu', 1)) : ?>



		        <div id="gkMainMenu">

		  			<?php

		  				$this->menu->loadMenu($this->getParam('menu_name','mainmenu')); 

		  			    $this->menu->genMenu($this->getParam('startlevel', 0), $this->getParam('endlevel',-1));

		  			?>

		        </div>

                <?php endif; ?>

	        </div>

	  

		    <div id="mainContent" class="clear">

		    	<?php if( $this->modules('header')) : ?>

		    	<div id="gkHeader" class="clear clearfix">

		    		<jdoc:include type="modules" name="header" style="<?php echo $this->module_styles['header']; ?>" />

		    	</div>

		    	<?php endif; ?>

		    	

		    	<?php $this->messages('message-position-2'); ?>

		    	

		    	<?php $this->loadBlock('top'); ?>

		    	

		    	<?php $this->loadBlock('main'); ?>

		    	

		    	<?php $this->loadBlock('user'); ?>

		    </div>

	    </div>

    </div>

    

    <div id="gkBottomWrap" class="gkWrap clear">

        <?php $this->loadBlock('bottom'); ?>

    </div>

    

    <div id="gkFooter" class="gkWrap">

    	<?php $this->loadBlock('footer'); ?> 

    </div>

   

	<jdoc:include type="modules" name="debug" />

</body>

</html>