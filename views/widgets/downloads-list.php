<?php
/**
 * @var \Pagekit\View\View $view
 * @var \Pagekit\Widget\Model\Widget $widget
 * @var array $files
 */

?>


<ul class="uk-list uk-list-line">
	<?php foreach ($files as $file) : ?>
		<li>
			<?=$file->title?>
		</li>
	<?php endforeach; ?>
</ul>