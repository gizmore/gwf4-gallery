<!-- Gallery Info -->

<md-card>
	<md-card-header>
		<md-card-avatar><?php echo GWF_Avatar::userAvatar($creator);  ?></md-card-avatar>
		<md-card-header-text>
			<span class="md-title"><?php echo $gallery->displayName(); ?></span>
			<span class="md-subhead"><?php echo $lang->lang('gallery_subtitle', array($numImages, $creator->displayName())); ?></span>
		</md-card-header-text>
	</md-card-header>
</md-card>

<!-- Thumbnails -->

<md-list>
<?php
while ($image = $table->fetch($images, GDO::ARRAY_O))
{
	$image instanceof GWF_GalleryImage;
?>
	<md-list-item>
		<md-card>
			<md-card-header>
				<md-card-header-text>
					<span class="md-title"><?php echo $image->displayTitle(); ?></span>
					<span class="md-subhead"><?php echo $lang->lang('image_subtitle', array($image->displayType(), $image->displaySize())); ?></span>
				</md-card-header-text>
			</md-card-header>
			
			<gwf4-thumbnail><img src="<?php echo $image->hrefThumbnail(); ?>" /></gwf4-thumbnail>

		</md-card>
	</md-list-item>
<?php
}
?>
</md-list>
