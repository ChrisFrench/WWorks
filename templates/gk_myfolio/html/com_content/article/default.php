<?php

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT .'/helpers');

// Create shortcuts to some parameters.
$params = $this->item->params;
if(version_compare( JVERSION, '1.8', 'ge' )) {
    $images = json_decode($this->item->images);
}
$attribs = json_decode($this->item->attribs);

foreach($attribs as $key => $value) {
    if($value != null) {
    $params->set($key, $value);
    }
}
$canEdit	= $this->item->params->get('access-edit');
$user		= JFactory::getUser();

$cur_url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

// OpenGraph support
$template_config = new JConfig();
$uri = JURI::getInstance();
$article_attribs = json_decode($this->item->attribs, true);

$og_title = $this->escape($this->item->title);
$og_type = 'article';
$og_url = $cur_url;
if (version_compare( JVERSION, '1.8', 'ge' ) && isset($images->image_fulltext) and !empty($images->image_fulltext)) {
     $og_image = $uri->root() . htmlspecialchars($images->image_fulltext);
     $pin_image = $uri->root() . htmlspecialchars($images->image_fulltext);
} else {
     $og_image = '';
     preg_match('/src="([^"]*)"/', $this->item->text, $matches);
     if(isset($matches[0])) {
         $pin_image = $uri->root() . substr($matches[0], 5,-1);
     }
}
$og_site_name = $template_config->sitename;
$og_desc = '';


if(isset($article_attribs['og:title'])) {
     $og_title = ($article_attribs['og:title'] == '') ? $this->escape($this->item->title) : $this->escape($article_attribs['og:title']);
     $og_type = $this->escape($article_attribs['og:type']);
     $og_url = $cur_url;
     $og_image = ($article_attribs['og:image'] == '') ? $og_image : $uri->root() . $article_attribs['og:image'];
     $og_site_name = ($article_attribs['og:site_name'] == '') ? $template_config->sitename : $this->escape($article_attribs['og:site_name']);
     $og_desc = $this->escape($article_attribs['og:description']);
}

$doc = JFactory::getDocument();
$doc->setMetaData( 'og:title', $og_title );
$doc->setMetaData( 'og:type', $og_type );
$doc->setMetaData( 'og:url', $og_url );
$doc->setMetaData( 'og:image', $og_image );
$doc->setMetaData( 'og:site_name', $og_site_name );
$doc->setMetaData( 'og:description', $og_desc );

?>
<gavern:desktop>
<div class="item-page<?php echo $params->get('pageclass_sfx')?>">
<?php if ($params->get('show_page_heading', 1)) : ?>
<h1>
    <?php echo $this->escape($params->get('page_heading')); ?>
</h1>
<?php endif; ?>
<?php if ($params->get('show_title')|| $params->get('access-edit')) : ?>
		<h2>
				<?php if ($params->get('link_titles') && !empty($this->item->readmore_link)) : ?>
				<a href="<?php echo $this->item->readmore_link; ?>">
						<?php echo $this->escape($this->item->title); ?></a>
				<?php else : ?>
						<?php echo $this->escape($this->item->title); ?>
				<?php endif; ?>
		</h2>
<?php endif; ?>


<?php if ($canEdit ||  $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
		<ul class="actions">
		<?php if (!$this->print) : ?>
				<?php if ($params->get('show_print_icon')) : ?>
				<li class="print-icon">
						<?php echo JHtml::_('icon.print_popup',  $this->item, $params); ?>
				</li>
				<?php endif; ?>

				<?php if ($params->get('show_email_icon')) : ?>
				<li class="email-icon">
						<?php echo JHtml::_('icon.email',  $this->item, $params); ?>
				</li>
				<?php endif; ?>
				<?php if ($canEdit) : ?>
						<li class="edit-icon">
							<?php echo JHtml::_('icon.edit', $this->item, $params); ?>
						</li>
					<?php endif; ?>
		<?php else : ?>
				<li>
						<?php echo JHtml::_('icon.print_screen',  $this->item, $params); ?>
				</li>
		<?php endif; ?>
		</ul>
<?php endif; ?>

	<?php  if (!$params->get('show_intro')) :
		echo $this->item->event->afterDisplayTitle;
	endif; ?>

	<?php echo $this->item->event->beforeDisplayContent; ?>

<?php $useDefList = (($params->get('show_author')) OR ($params->get('show_category')) OR ($params->get('show_parent_category'))
	OR ($params->get('show_create_date')) OR ($params->get('show_modify_date')) OR ($params->get('show_publish_date'))
	OR ($params->get('show_hits'))); ?>

<?php if ($useDefList) : ?>
 <dl class="article-info">
 <dt class="article-info-term"><?php  echo JText::_('COM_CONTENT_ARTICLE_INFO'); ?></dt>
<?php endif; ?>
<?php if ($params->get('show_parent_category') && $this->item->parent_slug != '1:root') : ?>
		<dd class="parent-category-name">
			<?php	$title = $this->escape($this->item->parent_title);
					$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->parent_slug)).'">'.$title.'</a>';?>
			<?php if ($params->get('link_parent_category') AND $this->item->parent_slug) : ?>
				<?php echo JText::sprintf('COM_CONTENT_PARENT', $url); ?>
				<?php else : ?>
				<?php echo JText::sprintf('COM_CONTENT_PARENT', $title); ?>
			<?php endif; ?>
		</dd>
<?php endif; ?>
<?php if ($params->get('show_category')) : ?>
		<dd class="category-name">
			<?php 	$title = $this->escape($this->item->category_title);
					$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug)).'">'.$title.'</a>';?>
			<?php if ($params->get('link_category') AND $this->item->catslug) : ?>
				<?php echo JText::sprintf('COM_CONTENT_CATEGORY', $url); ?>
				<?php else : ?>
				<?php echo JText::sprintf('COM_CONTENT_CATEGORY', $title); ?>
			<?php endif; ?>
		</dd>
<?php endif; ?>
<?php if ($params->get('show_create_date')) : ?>
		<dd class="create">
          <time datetime="<?php echo JHtml::_('date', $this->item->created, 'Y-m-d'); ?>">
		    <?php echo JText::sprintf('COM_CONTENT_CREATED_DATE_ON', JHTML::_('date',$this->item->created, JText::_('DATE_FORMAT_LC2'))); ?>
          </time>
		</dd>
<?php endif; ?>
<?php if ($params->get('show_modify_date')) : ?>
		<dd class="modified">
          <time datetime="<?php echo JHtml::_('date', $this->item->modified, 'Y-m-d'); ?>">
		    <?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHTML::_('date',$this->item->modified, JText::_('DATE_FORMAT_LC2'))); ?>
          </time>
		</dd>
<?php endif; ?>
<?php if ($params->get('show_publish_date')) : ?>
		<dd class="published">
          <time datetime="<?php echo JHtml::_('date', $this->item->publish_up, 'Y-m-d'); ?>">
		    <?php echo JText::sprintf('COM_CONTENT_PUBLISHED_DATE_ON', JHTML::_('date',$this->item->publish_up, JText::_('DATE_FORMAT_LC2'))); ?>
          </time>
		</dd>
<?php endif; ?>
<?php if ($params->get('show_author') && !empty($this->item->author)) : ?>
	<dd class="createdby">
		<?php $author = $this->item->created_by_alias ? $this->item->created_by_alias : $this->item->author; ?>
	<?php if (!empty($this->item->contactid) && $params->get('link_author') == true): ?>
	<?php
		$needle = 'index.php?option=com_contact&view=contact&id=' . $this->item->contactid;
        $menu = JFactory::getApplication()->getMenu();
        $item = $menu->getItems('link', $needle, true);
        $cntlink = !empty($item) ? $needle . '&Itemid=' . $item->id : $needle;
	?>
		<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', JHtml::_('link', JRoute::_($cntlink), $author)); ?>
	<?php else: ?>
		<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
	<?php endif; ?>
		</dd>
<?php endif; ?>
<?php if ($params->get('show_hits')) : ?>
		<dd class="hits">
		<?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $this->item->hits); ?>
		</dd>
<?php endif; ?>
<?php if ($useDefList) : ?>
 </dl>
<?php endif; ?>
	
	<div class="articleContent">
		<?php if (isset ($this->item->toc)) : ?>
			<?php echo $this->item->toc; ?>
		<?php endif; ?>
	   
       <?php if(version_compare( JVERSION, '1.8', 'ge' )) : ?>
            <?php // This loads the block of links ?>
            <?php echo $this->loadTemplate('links'); ?>
        <?php endif; ?>
        
		<?php if ($params->get('access-view')):?>
            <?php  if (version_compare( JVERSION, '1.8', 'ge' ) && isset($images->image_fulltext) and !empty($images->image_fulltext)) : ?>
               <?php $imgfloat = (empty($images->float_fulltext)) ? $params->get('float_fulltext') : $images->float_fulltext; ?>
               <div class="img-fulltext-<?php echo htmlspecialchars($imgfloat); ?>">
               <img
                    <?php if ($images->image_fulltext_caption):
                         echo 'class="caption"'.' title="' .htmlspecialchars($images->image_fulltext_caption) .'"';
                    endif; ?>
                    src="<?php echo htmlspecialchars($images->image_fulltext); ?>" alt="<?php echo htmlspecialchars($images->image_fulltext_alt); ?>"/>
               </div>
               <?php endif; ?>
			<?php echo $this->item->text; ?>
		<?php /*optional teaser intro text for guests */ ?>
		<?php elseif ($params->get('show_noauth') == true AND  $user->get('guest') ) : ?>
			<?php echo $this->item->introtext; ?>
			<?php //Optional link to let them register to see the whole article. ?>
			<?php if ($params->get('show_readmore') && $this->item->fulltext != null) :
				$link1 = JRoute::_('index.php?option=com_users&view=login');
				$link = new JURI($link1);?>
				<p class="readmore">
				<a href="<?php echo $link; ?>">
				<?php $attribs = json_decode($this->item->attribs);  ?> 
				<?php 
				if ($attribs->alternative_readmore == null) :
					echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
				elseif ($readmore = $this->item->alternative_readmore) :
					echo $readmore;
					if ($params->get('show_readmore_title', 0) != 0) :
					    echo JHTML::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
					endif;
				elseif ($params->get('show_readmore_title', 0) == 0) :
					echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');	
				else :
					echo JText::_('COM_CONTENT_READ_MORE');
					echo JHTML::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
				endif; ?></a>
				</p>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	
    <?php if (!empty($this->item->pagination) AND $this->item->pagination AND $this->item->paginationposition):
               echo $this->item->pagination;?>
     <?php endif; ?>
    
    <gavern:social><div id="gkSocialAPI"></gavern:social>
          <gavern:social><fb:like href="<?php echo $cur_url; ?>" GK_FB_LIKE_SETTINGS></fb:like></gavern:social>
        <gavern:social><g:plusone GK_GOOGLE_PLUS_SETTINGS callback="<?php echo $cur_url; ?>"></g:plusone></gavern:social>
        <gavern:social><g:plus action="share" GK_GOOGLE_PLUS_SHARE_SETTINGS href="<?php echo $cur_url; ?>"></g:plus></gavern:social>
          <gavern:social><a href="http://twitter.com/share" class="twitter-share-button" data-text="<?php echo $this->item->title; ?>" data-url="<?php $cur_url; ?>" gk_tweet_btn_settings>Tweet</a></gavern:social>
          <gavern:social><a class="DiggThisButton GK_DIGG_SETTINGS" href="<?php echo $cur_url; ?>"></a></gavern:social>
          <gavern:social><a href="http://www.delicious.com/save" onclick="window.open('http://www.delicious.com/save?v=5&noui&amp;jump=close&amp;url='+encodeURIComponent(location.href)+'&amp;title='+encodeURIComponent(document.title), 'delicious','toolbar=no,width=550,height=550'); return false;" class="deliciousBtn" title="<?php echo JText::_('TPL_GK_LANG_DELICIOUS_TITLE'); ?>"></a></gavern:social>
          <gavern:social><a href="http://www.instapaper.com/hello2?url=<?php echo urlencode($cur_url); ?>&amp;title=<?php echo urlencode($this->item->title); ?>" class="instapaperBtn" title="<?php echo JText::_('TPL_GK_LANG_INSTAPAPER_TITLE'); ?>"></a></gavern:social>
           <gavern:social><a href="http://pinterest.com/pin/create/button/?url=<?php echo $cur_url; ?>&amp;media=<?php echo $pin_image; ?>&amp;description=<?php echo str_replace(" ", "%20", $this->item->title); ?>" class="pin-it-button" count-layout="GK_PINTEREST_SETTINGS"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="<?php echo JText::_('TPL_GK_LANG_PINIT_TITLE'); ?>" /></a></gavern:social>
     <gavern:social><div class="clr"></div></div></gavern:social>
	
	<?php echo $this->item->event->afterDisplayContent; ?>
</div>
</gavern:desktop>


<gavern:mobile>
<div class="item-page<?php echo $params->get('pageclass_sfx')?>">
	<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	<?php endif; ?>
	<?php if ($params->get('show_title')|| $params->get('access-edit')) : ?>
		<h2>
			<?php if ($params->get('link_titles') && !empty($this->item->readmore_link)) : ?>
			<a href="<?php echo $this->item->readmore_link; ?>">
					<?php echo $this->escape($this->item->title); ?></a>
			<?php else : ?>
					<?php echo $this->escape($this->item->title); ?>
			<?php endif; ?>
		</h2>
	<?php endif; ?>

	<?php $useDefList = (($params->get('show_author')) OR ($params->get('show_category')) OR ($params->get('show_parent_category'))
	OR ($params->get('show_create_date')) OR ($params->get('show_modify_date')) OR ($params->get('show_publish_date'))
	OR ($params->get('show_hits'))); ?>

	<?php if ($useDefList) : ?>
     <p class="article-info">
     <?php endif; ?>
          <?php if ($params->get('show_category')) : ?>
          <span class="category-name">
               <?php      $title = $this->escape($this->item->category_title);
                         $url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug)).'">'.$title.'</a>';?>
               <?php if ($params->get('link_category') AND $this->item->catslug) : ?>
                    <?php echo JText::sprintf('COM_CONTENT_CATEGORY', $url); ?>
                    <?php else : ?>
                    <?php echo JText::sprintf('COM_CONTENT_CATEGORY', $title); ?>
               <?php endif; ?>
          </span>
          <?php endif; ?>
          <?php if ($params->get('show_create_date')) : ?>
          <span class="create">
            <time datetime="<?php echo JHtml::_('date', $this->item->created, 'Y-m-d'); ?>">
               <?php echo JText::sprintf('COM_CONTENT_CREATED_DATE_ON', JHTML::_('date',$this->item->created, JText::_('DATE_FORMAT_LC2'))); ?>
            </time>
          </span>
          <?php endif; ?>
          <?php if ($params->get('show_modify_date')) : ?>
          <span class="modified">
            <time datetime="<?php echo JHtml::_('date', $this->item->modified, 'Y-m-d'); ?>">
               <?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHTML::_('date',$this->item->modified, JText::_('DATE_FORMAT_LC2'))); ?>
            </time>
          </span>
          <?php endif; ?>
          <?php if ($params->get('show_publish_date')) : ?>
          <span class="published">
            <time datetime="<?php echo JHtml::_('date', $this->item->publish_up, 'Y-m-d'); ?>">
               <?php echo JText::sprintf('COM_CONTENT_PUBLISHED_DATE_ON', JHTML::_('date',$this->item->publish_up, JText::_('DATE_FORMAT_LC2'))); ?>
            </time>
          </span>
          <?php endif; ?>
          <?php if ($params->get('show_author') && !empty($this->item->author)) : ?>
          <span class="createdby">
               <?php $author = $params->get('link_author', 0) ? JHTML::_('link',JRoute::_('index.php?option=com_users&view=profile&member_id='.$this->item->created_by),$this->item->author) : $this->item->author; ?>
               <?php $author=($this->item->created_by_alias ? $this->item->created_by_alias : $author);?>
          <?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
          </span>
          <?php endif; ?>
          <?php if ($params->get('show_hits')) : ?>
          <span class="hits">
               <?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $this->item->hits); ?>
          </span>
          <?php endif; ?>
          <?php if ($useDefList) : ?>
     </p>
     <?php endif; ?>

	<?php if (isset ($this->item->toc)) : ?>
		<?php echo $this->item->toc; ?>
	<?php endif; ?>
    
    <?php if(version_compare( JVERSION, '1.8', 'ge' )) : ?>
        <?php // This loads the block of links ?>
        <?php echo $this->loadTemplate('links'); ?>
    <?php endif; ?>
    
	<?php if ($params->get('access-view')):?>
        <?php  if (version_compare( JVERSION, '1.8', 'ge' ) && isset($images->image_fulltext) and !empty($images->image_fulltext)) : ?>
           <?php $imgfloat = (empty($images->float_fulltext)) ? $params->get('float_fulltext') : $images->float_fulltext; ?>
           <div class="img-fulltext-<?php echo htmlspecialchars($imgfloat); ?>">
           <img
                <?php if ($images->image_fulltext_caption):
                     echo 'class="caption"'.' title="' .htmlspecialchars($images->image_fulltext_caption) .'"';
                endif; ?>
                src="<?php echo htmlspecialchars($images->image_fulltext); ?>" alt="<?php echo htmlspecialchars($images->image_fulltext_alt); ?>"/>
           </div>
        <?php endif; ?>
		<?php echo $this->item->text; ?>
	<?php /*optional teaser intro text for guests */ ?>
	<?php elseif ($params->get('show_noauth') == true AND  $user->get('guest') ) : ?>
		<?php echo $this->item->introtext; ?>
		<?php //Optional link to let them register to see the whole article. ?>
		<?php if ($params->get('show_readmore') && $this->item->fulltext != null) :
			$link1 = JRoute::_('index.php?option=com_users&view=login');
			$link = new JURI($link1);?>
			<p class="readmore">
			<a href="<?php echo $link; ?>">
			<?php $attribs = json_decode($this->item->attribs);  ?> 
			<?php 
			if ($attribs->alternative_readmore == null) :
				echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
			elseif ($readmore = $this->item->alternative_readmore) :
				echo $readmore;
				if ($params->get('show_readmore_title', 0) != 0) :
				    echo JHTML::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
				endif;
			elseif ($params->get('show_readmore_title', 0) == 0) :
				echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');	
			else :
				echo JText::_('COM_CONTENT_READ_MORE');
				echo JHTML::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
			endif; ?></a>
			</p>
		<?php endif; ?>
	<?php endif; ?>
</div>
</gavern:mobile>