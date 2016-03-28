<?php
/**
 * @var $view
 * @var array $filters
 * @var array $config
 * @var Bixie\Download\Model\Category[] $subcategories
 * @var Bixie\Download\Model\Category $category
 * @var Bixie\Download\DownloadModule $download
 */
$view->script('download', 'bixie/download:app/bundle/download.js', ['uikit-grid']);

// Grid
$grid  = 'uk-grid-width-1-'.$config['category']['columns'];
$grid .= $config['category']['columns_small'] ? ' uk-grid-width-small-1-'.$config['category']['columns_small'] : '';
$grid .= $config['category']['columns_medium'] ? ' uk-grid-width-medium-1-'.$config['category']['columns_medium'] : '';
$grid .= $config['category']['columns_large'] ? ' uk-grid-width-large-1-'.$config['category']['columns_large'] : '';
$grid .= $config['category']['columns_xlarge'] ? ' uk-grid-width-xlarge-1-'.$config['category']['columns_xlarge'] : '';

$config['image_class'] = in_array($config['category']['image_align'], ['right', 'left']) ? 'uk-align-' . $config['category']['image_align'] : 'uk-text-center'

?>

<article class="bixie-addtocart" id="download-files">

	<?php if ($config['category']['show_title']) : ?>
	    <h1 class="uk-article-title"><?= $category->title ?></h1>
	<?php endif; ?>
	<div class="uk-clearfix uk-margin">

		<?php if ($category->get('image') && $config['category']['show_image']) : ?>
			<div class="<?= $config['image_class'] ?>">
				<img src="<?= $category->get('image') ?>" alt="">
			</div>

		<?php endif; ?>

		<?php if ($category->get('description') && $config['category']['show_description']) : ?>
			<?= $category->get('description') ?>
		<?php endif; ?>

	</div>
	<?php if ($config['show_subcategories'] && count($subcategories)) : ?>
	<div class="uk-grid uk-grid-medium uk-grid-width-medium-1-<?= $config['subcategories_columns'] ?> uk-margin" data-uk-grid-margin="">
		<?php foreach ($subcategories as $subcategory) : ?>
			<div>
				<div
					class="uk-panel <?= $config['subcategories_panel_style'] ?> uk-text-<?= $config['subcategories_content_align'] ?>">
					<h3 class="<?= $config['subcategories_title_size'] ?>"><a
							href="<?= $subcategory->getUrl() ?>"><?= $subcategory->title ?></a></h3>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>

	<?php if ($category->files) : ?>
		<?php if ($config['category']['filter_items'] && count($filters)) : ?>
			<div class="uk-tab-center uk-margin">
				<ul id="download-filter" class="uk-tab">
					<li class="uk-active" data-uk-filter=""><a href=""><?= __('All') ?></a></li>
					<?php foreach ($filters as $filter) : ?>
						<li data-uk-filter="<?= $filter ?>"><a href=""><?= __($filter) ?></a></li>
					<?php endforeach; ?>

				</ul>
			</div>
		<?php endif; ?>

		<div class="uk-grid <?= $grid ?>" data-uk-grid="{gutter: <?= $config['columns_gutter'] ?>, controls: '<?= $config['filter_items'] ? '#download-filter': ''; ?>'}">

			<?php foreach ($category->files as $file) : ?>

				<div data-uk-filter="<?= implode(',', $file->getFilters('tag')) ?>">
					<?= $view->render('bixie/download/templates/file_panel.php', ['config' => $config, 'file' => $file]) ?>
				</div>

			<?php endforeach; ?>

		</div>
	<?php endif; ?>

</article>