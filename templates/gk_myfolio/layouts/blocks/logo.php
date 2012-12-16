<?php

// No direct access.
defined('_JEXEC') or die;
$logo_image = $this->getParam('logo_image', '');

if(($logo_image == '') || ($this->getParam('logo_type', '') == 'css')) {
     $logo_image = $this->URLtemplate() . '/images/logo.png';
} else {
     $logo_image = $this->URLbase() . $logo_image;
}

$logo_text = $this->getParam('logo_text', '');
$logo_slogan = $this->getParam('logo_slogan', '');

?>

<?php if ($this->getParam('logo_type', 'image')!=='none'): ?>
     <?php if($this->getParam('logo_type', 'image') == 'css') : ?>
     <h1 id="gkLogo">
          <a href="./" class="cssLogo"></a>
     </h1>
     <?php elseif($this->getParam('logo_type', 'image')=='text') : ?>
     <h1 id="gkLogo" class="text">
         <a href="./">
              <span><?php echo $this->getParam('logo_text', ''); ?></span>
               <small class="gkLogoSlogan"><?php echo $this->getParam('logo_slogan', ''); ?></small>
         </a>
     </h1>
    <?php elseif($this->getParam('logo_type', 'image')=='image') : ?>
    <h1 id="gkLogo">
          <a href="./">
          <img src="<?php echo $logo_image; ?>" alt="<?php echo $this->getPageName(); ?>" />
          </a>
     </h1>
     <?php endif; ?>
<?php endif; ?>

