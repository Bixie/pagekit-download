<?php
/**
 * @var $view
 * @var array $config
 * @var Bixie\Download\Model\File $file
 */

$config['show_download'] = $config['teaser']['show_download'] && !$file->get('cart_active');
$metaData = [];
if ($config['teaser']['show_date']) {
	$metaData[] = '<li>' . $file->date->format($config['date_format']) . '</li>';
}
if ($config['teaser']['show_category'] && count($file->getCategoryNames())) {
	$metaData[] = '<li>' . implode(', ', $file->getCategoryNames()) . '</li>';
}
if ($config['teaser']['show_version'] && $file->get('version')) {
	$metaData[] = '<li>' . $file->get('version') . '</li>';
}

?>
<div class="uk-panel <?= $config['teaser']['panel_style'] ?> uk-text-<?= $config['teaser']['content_align'] ?>">

	<?php if ($config['teaser']['show_image'] && !empty($file->image['main']['src'])) : ?>
		<div class="uk-panel-teaser">
			<img src="<?= $file->image['main']['src'] ?>" alt="<?= $file->image['main']['alt'] ?>">
		</div>
	<?php endif; ?>

	<?php if ($config['teaser']['show_title']) : ?>
		<h3 class="<?= $config['teaser']['title_size'] ?>"><a class="uk-link-reset <?= $config['teaser']['title_color'] ?>"
															  href="<?= $file->getUrl() ?>">
				<?= $file->title ?></a></h3>
	<?php endif; ?>

	<?php if ($config['teaser']['show_subtitle']) : ?>
		<p class="uk-article-lead <?= $config['teaser']['subtitle_size'] ?>"><?= $file->subtitle ?></p>
	<?php endif; ?>

	<?php if (count($metaData)) : ?>
		<ul class="uk-subnav uk-subnav-line">
			<?= implode($metaData) ?>
		</ul>
	<?php endif; ?>

	<?php if ($config['teaser']['show_tags']) : ?>
		<div class="uk-flex uk-flex-wrap uk-margin <?= $config['teaser']['tags_align'] ?>" data-uk-margin="">
			<?php foreach ($file->tags as $tag) : ?>
				<div class="uk-badge uk-margin-small-right"><?= $tag ?></div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if (isset($file->product) && $file->get('cart_active')) : ?>

		<addtocart product="{{ products[<?= $file->id ?>] }}" item_id="<?= $file->id ?>" buttonHldr=""></addtocart>

	<?php endif; ?>

	<?php if ($config['teaser']['show_readmore'] || $config['show_download']) : ?>
		<div class="uk-flex uk-flex-wrap <?= $config['teaser']['button_align']; ?> uk-margin" data-uk-margin="">
		<?php if ($config['teaser']['show_readmore']) : ?>
			<a class="<?= $config['teaser']['read_more_style'] ?>"
			   href="<?= $file->getUrl() ?>">
				<?= $config['teaser']['read_more'] ?></a>
		<?php endif; ?>

		<?php if ($config['show_download']) : ?>
			<a class="<?= $config['teaser']['download_style'] ?><?= $config['teaser']['show_readmore'] && $config['teaser']['download_style'] != 'uk-flex-space-around' ? ' uk-margin-left' : '' ?>"
			   href="<?= $file->getDownloadLink() ?>">
				<?= $config['teaser']['download'] ?></a>
		<?php endif; ?>

		<?php if ($config['teaser']['show_demo'] && $file->get('demo_url')) : ?>
			<a class="uk-button uk-button-primary uk-width-1-1" target="_blank" href="<?= $file->get('demo_url') ?>">
				<i class="uk-icon-eye uk-margin-small-right"></i>Demo</a>
		<?php endif; ?>
		</div>
	<?php endif; ?>

</div>

