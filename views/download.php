<?php
/**
 * @var $view
 * @var array $filters
 * @var array $config
 * @var string $mainpage_text
 * @var Bixie\Download\DownloadModule $download
 * @var Bixie\Download\Model\File[] $files
 */
$view->script('download', 'bixie/download:app/bundle/download.js', ['uikit-grid']);

// Grid
$grid  = 'uk-grid-width-1-'.$config['columns'];
$grid .= $config['columns_small'] ? ' uk-grid-width-small-1-'.$config['columns_small'] : '';
$grid .= $config['columns_medium'] ? ' uk-grid-width-medium-1-'.$config['columns_medium'] : '';
$grid .= $config['columns_large'] ? ' uk-grid-width-large-1-'.$config['columns_large'] : '';
$grid .= $config['columns_xlarge'] ? ' uk-grid-width-xlarge-1-'.$config['columns_xlarge'] : '';

$config['mainpage_image_class'] = in_array($config['mainpage_image_align'], ['right', 'left']) ? 'uk-align-' . $config['mainpage_image_align'] : 'uk-text-center'

?>

<article class="bixie-addtocart" id="download-files">

	<?php if ($config['mainpage_title']) : ?>
	    <h1 class="uk-article-title"><?= $config['mainpage_title'] ?></h1>
	<?php endif; ?>
	<div class="uk-clearfix">

		<?php if ($config['mainpage_image']) : ?>
			<div class="<?= $config['mainpage_image_class'] ?>">
				<img src="<?= $config['mainpage_image'] ?>" alt="">
			</div>

		<?php endif; ?>

		<?php if ($mainpage_text) : ?>
			<?= $mainpage_text ?>
		<?php endif; ?>

	</div>

	<?php if ($config['filter_items'] && count($filters)) : ?>
	<div class="uk-tab-center uk-margin">
			<ul id="portfolio-filter" class="uk-tab">
			<li class="uk-active" data-uk-filter=""><a href=""><?= __('All') ?></a></li>
			<?php foreach ($filters as $filter) : ?>
				<li data-uk-filter="<?= $filter ?>"><a href=""><?= __($filter) ?></a></li>
			<?php endforeach; ?>

		</ul>
	</div>
	<?php endif; ?>
	
	<div class="uk-grid <?= $grid ?>" data-uk-grid="{gutter: <?= $config['columns_gutter'] ?>, controls: '<?= $config['filter_items'] ? '#portfolio-filter': ''; ?>'}">

		<?php foreach ($files as $file) : ?>

			<div data-uk-filter="<?= implode(',', $file->getFilters($config['filter_items'])) ?>">
				<?= $view->render('bixie/download/templates/file_panel.php', ['config' => $config, 'file' => $file]) ?>
			</div>

		<?php endforeach; ?>

	</div>
</article>