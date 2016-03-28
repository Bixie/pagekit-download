<?php
/**
 * @var \Pagekit\View\View $view
 * @var \Pagekit\Widget\Model\Widget $widget
 * @var array $files
 */

$view->script('uikit-slider');
?>

<div class="uk-slidenav-position" data-uk-slider="autoplay:true,pauseOnHover:false,autoplayInterval:8000,center:true">

	<div class="uk-slider-container">
		<ul class="uk-slider uk-grid-width-medium-1-3">
			<?php foreach ($files as $file) : ?>
				<li class="uk-flex uk-flex-center">
					<?php if (!empty($file->image['main']['src'])) : ?>
						<img src="<?= $file->image['main']['src'] ?>" alt="<?= $file->image['main']['alt'] ?>">
					<?php endif; ?>
					<a class="uk-position-cover" href="<?= $file->getUrl() ?>"></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<a href="" class="uk-slidenav uk-slidenav-previous" data-uk-slider-item="previous"></a>
	<a href="" class="uk-slidenav uk-slidenav-next" data-uk-slider-item="next"></a>

</div>