<?php
/**
 * @var $view
 * @var array $config
 * @var Bixie\Download\Model\File $file
 */

$config['show_download'] = $config['teaser']['show_download'] && !$file->get('cart_active');

?>
<div data-uk-filter="<?= implode(',', $file->tags) ?>">
	<div class="uk-panel <?= $config['teaser']['panel_style'] ?> uk-text-<?= $config['teaser']['content_align'] ?>">

		<?php if ($config['teaser']['show_image'] && !empty($file->image['main']['src'])) : ?>
			<div class="uk-panel-teaser">
				<img src="<?= $file->image['main']['src'] ?>" alt="<?= $file->image['main']['alt'] ?>">
			</div>
		<?php endif; ?>

		<?php if ($config['teaser']['show_title']) : ?>
			<h3 class="<?= $config['teaser']['title_size'] ?>"><a class="uk-link-reset <?= $config['teaser']['title_color'] ?>"
																  href="<?= $app->url('@download/id', ['id' => $file->id]) ?>">
					<?= $file->title ?></a></h3>
		<?php endif; ?>

		<?php if ($config['teaser']['show_subtitle']) : ?>
			<p class="uk-article-lead <?= $config['teaser']['subtitle_size'] ?>"><?= $file->subtitle ?></p>
		<?php endif; ?>

		<?php if ($config['teaser']['show_date']) : ?>
			<p class="uk-article-meta">
				<?php if ($config['teaser']['show_date']) : ?>
					<?= $file->date->format($config['date_format']) ?>
				<?php endif; ?>
			</p>
		<?php endif; ?>

		<?php if ($config['teaser']['show_tags']) : ?>
			<div class="uk-flex uk-flex-wrap uk-margin <?= $config['teaser']['tags_align'] ?>" data-uk-margin="">
				<?php foreach ($file->tags as $tag) : ?>
					<div class="uk-badge uk-margin-small-right"><?= $tag ?></div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if (isset($file->product) && $file->get('cart_active')) : ?>

			<addtocart product="{{ products[<?= $file->id ?>] }}" item_id="<?= $file->id ?>"></addtocart>

		<?php endif; ?>

		<?php if ($config['teaser']['show_readmore'] || $config['show_download']) : ?>
			<div class="uk-flex uk-flex-wrap <?= $config['teaser']['button_align']; ?> uk-margin" data-uk-margin="">
			<?php if ($config['teaser']['show_readmore']) : ?>
				<a class="<?= $config['teaser']['read_more_style'] ?>"
				   href="<?= $app->url('@download/id', ['id' => $file->id]) ?>">
					<?= $config['teaser']['read_more'] ?></a>
			<?php endif; ?>

			<?php if ($config['show_download']) : ?>
				<a class="<?= $config['teaser']['download_style'] ?><?= $config['teaser']['show_readmore'] && $config['teaser']['download_style'] != 'uk-flex-space-around' ? ' uk-margin-left' : '' ?>"
				   href="<?= $app->url($file->getDownloadLink()) ?>">
					<?= $config['teaser']['download'] ?></a>
			<?php endif; ?>
			</div>
		<?php endif; ?>

	</div>

</div>
