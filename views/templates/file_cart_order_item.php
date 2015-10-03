<?php
/**
 * @var \Pagekit\View\View $view
 * @var bool $orderValid
 * @var Bixie\Cart\Model\Order $order
 * @var Bixie\Download\Model\File $file
 * @var Bixie\Cart\Cart\CartItem $cartItem
 * @var Bixie\Cart\CartModule $cart
 */

use Pagekit\Application as App;

?>

<?php if ($orderValid) : ?>
	<div class="uk-margin">
		<h4><?= __('Download your file %fileName% here', ['%fileName%' => $file->getFileName()]) ?></h4>
		<a href="<?= $file->getDownloadLink($cartItem->purchaseKey($order)) ?>" class="uk-button uk-button-primary"
		   download="<?= $file->getFileName() ?>">
			<i class="uk-icon-download uk-margin-small-right"></i>
			<?= __('Download file') ?>
		</a>
		<?php if ($cartItem->get('valid_until')) : ?>
			<br/><small><?= __('You have access to this file until %date%.', ['%date%' => App::module('bixie/cart')->formatDate($cartItem->get('valid_until'))]) ?></small>
		<?php endif; ?>
	</div>
<?php else: ?>
	<div class="uk-margin">
		<span class="uk-text-danger"><i class="uk-icon-history uk-margin-small-right"></i><?= __('Download expired') ?></span>
		<?php if ($cartItem->get('valid_until')) : ?>
			<br/><small><?= __('You had access to this file until %date%.', ['%date%' => App::module('bixie/cart')->formatDate($cartItem->get('valid_until'))]) ?></small>
		<?php endif; ?>
	</div>
<?php endif; ?>

