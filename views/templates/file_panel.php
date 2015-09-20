<?php
/**
 * @var $view
 * @var array $config
 * @var Bixie\Download\Model\File $file
 */
?>
<div data-uk-filter="<?= implode(',', $file->tags) ?>">
	<div class="uk-panel <?= $config['teaser']['panel_style'] ?> uk-text-<?= $config['teaser']['content_align'] ?>">

		<?php if ($config['teaser']['show_image'] && !empty($file->image['src'])) : ?>
			<div class="uk-panel-teaser">
				<img src="<?= $file->image['src'] ?>" alt="<?= $file->image['alt'] ?>">
			</div>
		<?php endif; ?>

		<?php if ($config['teaser']['show_title']) : ?>
			<h3 class="<?= $config['teaser']['title_size'] ?>"><a class="uk-link-reset <?= $config['teaser']['title_color'] ?>"
																  href="<?= $app->url('@portfolio/id', ['id' => $file->id]) ?>">
					<?= $file->title ?></a></h3>
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

		<?php if ($config['teaser']['show_readmore']) : ?>
			<div class="<?= $config['teaser']['readmore_align']; ?> uk-margin">
				<a class="<?= $config['teaser']['read_more_style'] ?>"
				   href="<?= $app->url('@download/id', ['id' => $file->id]) ?>">
					<?= $config['teaser']['read_more'] ?></a>
			</div>
		<?php endif; ?>

		<?php if ($config['teaser']['show_download']) : ?>
			<div class="<?= $config['teaser']['download_align']; ?> uk-margin">
				<a class="<?= $config['teaser']['download_style'] ?>"
				   href="<?= $app->url('@download/file/id', ['id' => $file->id]) ?>">
					<?= $config['teaser']['download'] ?></a>
			</div>
		<?php endif; ?>

	</div>

</div>
