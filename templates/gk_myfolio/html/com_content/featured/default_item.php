<?php
/**
 * @version		$Id: default_item.php 19834 2010-12-11 14:39:40Z chdemko $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

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
?>
<gavern:desktop>
<?php if ($this->item->state == 0) : ?>
<div class="system-unpublished">
<?php endif; ?>
	<div class="article">
		<div class="article-content">
			<?php if ($params->get('show_title')) : ?>
				<h2>
					<?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
						<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>">
						<?php echo $this->escape($this->item->title); ?></a>
					<?php else : ?>
						<?php echo $this->escape($this->item->title); ?>
					<?php endif; ?>
				</h2>
			<?php endif; ?>
			
			<?php if (!$params->get('show_intro')) : ?>
				<?php echo $this->item->event->afterDisplayTitle; ?>
			<?php endif; ?>
			
			<?php echo $this->item->event->beforeDisplayContent; ?>
			
            <?php  if (version_compare( JVERSION, '1.8', 'ge' ) && isset($images->image_intro) and !empty($images->image_intro)) : ?>
                   <?php $imgfloat = (empty($images->float_intro)) ? $params->get('float_intro') : $images->float_intro; ?>
             
                   <div class="img-intro-<?php echo htmlspecialchars($imgfloat); ?>">
                   <img
                        <?php if ($images->image_intro_caption):
                             echo 'class="caption"'.' title="' .htmlspecialchars($images->image_intro_caption) .'"';
                        endif; ?>
                        src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>"/>
                   </div>
              <?php endif; ?>
             
			<div class="article-introtext">
			<?php echo $this->item->introtext; ?>
			</div>
			
			<?php if ($params->get('show_readmore') && $this->item->readmore) :
				if ($params->get('access-view')) :
					$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
				else :
					$menu = JFactory::getApplication()->getMenu();
					$active = $menu->getActive();
					$itemId = $active->id;
					$link1 = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
					$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
					$link = new JURI($link1);
					$link->setVar('return', base64_encode($returnURL));
				endif;
			?>
			<p class="readmore">
				<a href="<?php echo $link; ?>">
					<?php if (!$params->get('access-view')) :
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
		</div>
	
		<div class="article-additional-info">
			<?php if ($params->get('show_publish_date')) : ?>
				<div class="item-created">
                  <time datetime="<?php echo JHtml::_('date', $this->item->publish_up, 'Y-m-d'); ?>">
					<?php echo JHTML::_('date', $this->item->publish_up, JText::_('l, d F Y h:i')); ?>
                  </time>
				</div>
			<?php endif; ?>
			
			<?php if ($params->get('show_parent_category') && $this->item->parent_id != 1) : ?>
			<div class="item-parent-category-name">
				<?php $title = $this->escape($this->item->parent_title);
					$url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->parent_id)) . '">' . $title . '</a>'; ?>
				<?php if ($params->get('link_parent_category')) : ?>
					<?php echo JText::sprintf('COM_CONTENT_PARENT', $url); ?>
					<?php else : ?>
					<?php echo JText::sprintf('COM_CONTENT_PARENT', $title); ?>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			
			<?php if ($params->get('show_category')) : ?>
			<div class="item-category-name">
				<?php $title = $this->escape($this->item->category_title);
						$url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catid)) . '">' . $title . '</a>'; ?>
				<?php if ($params->get('link_category')) : ?>
					<?php echo JText::sprintf('COM_CONTENT_CATEGORY', $url); ?>
					<?php else : ?>
					<?php echo JText::sprintf('COM_CONTENT_CATEGORY', $title); ?>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			
			<?php if ($params->get('show_modify_date')) : ?>
			<div class="item-modified">
              <time datetime="<?php echo JHtml::_('date', $this->item->modified, 'Y-m-d'); ?>">
			    <?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHTML::_('date',$this->item->modified, JText::_('DATE_FORMAT_LC2'))); ?>
              </time>
			</div>
			<?php endif; ?>
			
			<?php if ($params->get('show_author') && !empty($this->item->author )) : ?>
			<div class="item-createdby"> 
				<?php $author =  $this->item->author; ?>
				<?php $author = ($this->item->created_by_alias ? $this->item->created_by_alias : $author);?>
					<?php if (!empty($this->item->contactid ) &&  $params->get('link_author') == true):?>
						<?php 	echo JText::sprintf('COM_CONTENT_WRITTEN_BY' , 
						 JHTML::_('link',JRoute::_('index.php?option=com_contact&view=contact&id='.$this->item->contactid),$author)); ?>
		
					<?php else :?>
						<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
					<?php endif; ?>
			</div>
			<?php endif; ?>	
			
			<?php if ($params->get('show_hits')) : ?>
			<div class="info-hits"><?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $this->item->hits); ?></div>
			<?php endif; ?>
			
			<?php if ($params->get('show_print_icon') || $params->get('show_email_icon') || $canEdit) : ?>
				<ul class="actions">
					<?php if ($params->get('show_print_icon')) : ?>
					<li class="print-icon">
						<?php echo JHtml::_('icon.print_popup', $this->item, $params); ?>
					</li>
					<?php endif; ?>
					<?php if ($params->get('show_email_icon')) : ?>
					<li class="email-icon">
						<?php echo JHtml::_('icon.email', $this->item, $params); ?>
					</li>
					<?php endif; ?>
					<?php if ($canEdit) : ?>
					<li class="edit-icon">
						<?php echo JHtml::_('icon.edit', $this->item, $params); ?>
					</li>
					<?php endif; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>

<?php if ($this->item->state == 0) : ?>
</div>
<?php endif; ?>

<div class="item-separator"></div>
<?php echo $this->item->event->afterDisplayContent; ?>
</gavern:desktop>


<gavern:mobile>
<?php if ($params->get('show_title')) : ?>
	<h2<gavern:gk_collapsible/>>
		<?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
			<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>">
			<?php echo $this->escape($this->item->title); ?></a>
		<?php else : ?>
			<?php echo $this->escape($this->item->title); ?>
		<?php endif; ?>
		<gavern:gk_collapsible_button/>
	</h2>
<?php endif; ?>

<div class="gkFeaturedItem">
    <?php if (($params->get('show_author')) or ($params->get('show_category')) or ($params->get('show_publish_date')) or ($params->get('show_parent_category'))) : ?>
    <p class="article-info">
          <?php if ($params->get('show_parent_category') && $this->item->parent_slug != '1:root') : ?>
          <span class="parent-category-name">
               <?php     $title = $this->escape($this->item->parent_title);
                         $url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->parent_slug)).'">'.$title.'</a>';?>
               <?php if ($params->get('link_parent_category') AND $this->item->parent_slug) : ?>
                    <?php echo JText::sprintf('COM_CONTENT_PARENT', $url); ?>
                    <?php else : ?>
                    <?php echo JText::sprintf('COM_CONTENT_PARENT', $title); ?>
               <?php endif; ?>
          </span>
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
           
        <?php if ($params->get('show_published_date')) : ?>
             <span class="published"><time datetime="<?php echo JHtml::_('date', $this->item->publish_up, 'Y-m-d'); ?>"><?php echo JText::sprintf('COM_CONTENT_PUBLISHED_DATE', JHTML::_('date',$this->item->publish_up, JText::_('DATE_FORMAT_LC2'))); ?></time></span>
        <?php endif; ?>
         
        <?php if ($params->get('show_author') && !empty($this->item->author )) : ?>
          <span class="createdby">
               <?php $author =  $this->item->author; ?>
               <?php $author = ($this->item->created_by_alias ? $this->item->created_by_alias : $author);?>
                    <?php if (!empty($this->item->contactid ) &&  $params->get('link_author') == true):?>
                         <?php      echo JText::sprintf('COM_CONTENT_WRITTEN_BY' ,
                         JHTML::_('link',JRoute::_('index.php?option=com_contact&view=contact&id='.$this->item->contactid),$author)); ?>
                    <?php else :?>
                         <?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
                    <?php endif; ?>
          </span>
          <?php endif; ?>    
     </p>
     <?php endif; ?>
	
	<div class="gkFeaturedItemContent">
    <?php  if (version_compare( JVERSION, '1.8', 'ge' ) && isset($images->image_intro) and !empty($images->image_intro)) : ?>
           <?php $imgfloat = (empty($images->float_intro)) ? $params->get('float_intro') : $images->float_intro; ?>
     
           <div class="img-intro-<?php echo htmlspecialchars($imgfloat); ?>">
           <img
                <?php if ($images->image_intro_caption):
                     echo 'class="caption"'.' title="' .htmlspecialchars($images->image_intro_caption) .'"';
                endif; ?>
                src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>"/>
           </div>
      <?php endif; ?>
    <?php echo $this->item->introtext; ?></div>
	
	<div class="gkFeaturedItemInfo">
		<p><?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHTML::_('date',$this->item->modified, JText::_('DATE_FORMAT_LC2'))); ?></p>
		<p><?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $this->item->hits); ?></p>
		<?php if ($params->get('show_readmore') && $this->item->readmore) :
			if ($params->get('access-view')) :
				$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
			else :
				$menu = JFactory::getApplication()->getMenu();
				$active = $menu->getActive();
				$itemId = $active->id;
				$link1 = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
				$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
				$link = new JURI($link1);
				$link->setVar('return', base64_encode($returnURL));
			endif;
		?>
			<p class="readmore">
				<a href="<?php echo $link; ?>">
				<?php 
					if (!$params->get('access-view')) : 
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
					endif; 
				?>
				</a>
			</p>
		<?php endif; ?>
	</div>
</div>
</gavern:mobile>