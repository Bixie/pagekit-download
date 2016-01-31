<?php
/**
 * @var $view
 * @var array $config
 * @var Pagekit\Module\Module $download
 * @var Bixie\Download\Model\File $file
 * @var Bixie\Download\Model\File|null $previous
 * @var Bixie\Download\Model\File|null $next
 */

//$view->script('download', 'bixie/download:app/bundle/download.js', ['uikit-lightbox']);

$config['file_image_class'] = in_array($config['file']['image_align'], ['right', 'left']) ? 'uk-align-' . $config['file']['image_align'] : 'uk-text-center'
?>
<article class="bixie-addtocart" id="download-file">

	<?php if (in_array($config['file']['show_navigation'], ['both', 'top']) && ($next || $previous)) : ?>
		<ul class="uk-pagination">
			<?php if ($previous) : ?>
				<li class="uk-pagination-previous"><a href="<?= $previous->getUrl() ?>">
						<i class="uk-icon-arrow-left uk-margin-small-right"></i><?= $previous->title ?></a></li>
			<?php endif; ?>
			<?php if ($next) : ?>
				<li class="uk-pagination-next"><a href="<?= $next->getUrl() ?>">
						<?= $next->title ?><i class="uk-icon-arrow-right uk-margin-small-left"></i></a></li>
			<?php endif; ?>
		</ul>
	<?php endif; ?>

	<h1 class="uk-article-title"><?= $file->title ?></h1>

	<?php if ($file->subtitle) : ?>
	    <p class="uk-article-lead"><?= $file->subtitle ?></p>
	<?php endif; ?>

	<div class="uk-grid" data-uk-grid-margin="">
		<div class="uk-width-medium-3-4">


		<?php if ($config['file']['metadata_position'] == 'content-top' && (!empty($file->date) || $file->get('version'))) : ?>
			<p class="uk-file-meta">
				<?php if (!empty($file->date)) : ?>
					<?= $file->date->format($config['date_format']) ?>
				<?php endif; ?>
			</p>
		<?php endif; ?>
		<?php if ($file->get('version')) : ?>
			<dl class="uk-description-list uk-description-list-horizontal">
				<dt><?= __('Version') ?></dt>
				<dd><?= $file->get('version') ?></dd>
			</dl>
		<?php endif; ?>

		<div class="uk-clearfix">

			<?php if (!empty($file->image['main']['src'])): ?>
				<div class="<?= $config['file_image_class'] ?>">
					<img src="<?= $file->image['main']['src'] ?>" alt="<?= $file->image['main']['alt'] ?>">
				</div>
			<?php endif; ?>

			<?= $file->content ?>

		</div>

		<?php if ($config['file']['tags_position'] == 'content-bottom' && count($project->tags)) : ?>
			<div class="uk-flex uk-flex-wrap uk-margin <?= $config['file']['tags_align'] ?>" data-uk-margin="">
				<?php foreach ($project->tags as $tag) : ?>
					<div class="uk-badge uk-margin-small-right"><?= $tag ?></div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>


		</div>
		<div class="uk-width-medium-1-4">
			<div class="uk-panel uk-panel-box">

				<?php if ($config['file']['metadata_position'] == 'sidebar' && (!empty($file->date) || $file->get('version'))) : ?>
						<dl class="uk-description-list">
						<?php if (!empty($file->date)) : ?>
								<dt><?= __('Date') ?></dt>
								<dd><?= $file->date->format($config['date_format']) ?></dd>
						<?php endif; ?>
						<?php if ($file->get('version')) : ?>
							<dt><?= __('Version') ?></dt>
							<dd><?= $file->get('version') ?></dd>
						<?php endif; ?>
						</dl>
				<?php endif; ?>


				<?php if ($config['file']['tags_position'] == 'sidebar' && count($file->tags)) : ?>
					<div class="uk-flex uk-flex-wrap uk-margin <?= $config['file']['tags_align'] ?>" data-uk-margin="">
						<?php foreach ($file->tags as $tag) : ?>
							<div class="uk-badge uk-margin-small-right"><?= $tag ?></div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ($file->get('demo_url')) : ?>
					<div class="uk-margin">
						<a class="uk-button uk-button-primary uk-width-1-1" target="_blank" href="<?= $file->get('demo_url') ?>">
							<i class="uk-icon-cog uk-margin-small-right"></i><?= __('Demo') ?></a>
					</div>
				<?php endif; ?>

				<?php if (count($config['datafields'])) : ?>
					<dl class="uk-description-list">
						<?php foreach ($config['datafields'] as $datafield) :
							if (!$value = $file->get($datafield['name'])) continue; ?>
							<dt><?= $datafield['label'] ?></dt>
							<dd><?= $value ?></dd>
						<?php endforeach; ?>
					</dl>
				<?php endif; ?>

				<?php if (isset($file->product) && $file->get('cart_active')) : ?>
					<div class="uk-margin">
						<addtocart product="{{ products[<?= $file->id ?>] }}" item_id="<?= $file->id ?>"></addtocart>
					</div>
				<?php endif; ?>

				<div class="<?= $config['file']['download_align']; ?> uk-margin">
					<a class="<?= $config['file']['download_style'] ?>"
					   href="<?= $app->url($file->getDownloadLink()) ?>">
						<?php if (!empty($file->image['icon']['src'])): ?>
							<img src="<?= $file->image['icon']['src'] ?>" class="uk-margin-small-right" width="30" alt="<?= $file->image['icon']['alt'] ?>">
						<?php endif; ?>

						<?= $config['file']['download'] ?></a>
				</div>

			</div>
		</div>
	</div>

	<?php if (in_array($config['file']['show_navigation'], ['both', 'bottom']) && ($next || $previous)) : ?>
		<ul class="uk-pagination">
		<?php if ($previous) : ?>
			<li class="uk-pagination-previous"><a href="<?= $previous->getUrl() ?>">
					<i class="uk-icon-arrow-left uk-margin-small-right"></i><?= $previous->title ?></a></li>
		<?php endif; ?>
			<?php if ($next) : ?>
			<li class="uk-pagination-next"><a href="<?= $next->getUrl() ?>">
					<?= $next->title ?><i class="uk-icon-arrow-right uk-margin-small-left"></i></a></li>
		<?php endif; ?>
		</ul>
	<?php endif; ?>

</article>

