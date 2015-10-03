<?php
/**
 * @var \Pagekit\View\View $view
 * @var bool $orderValid
 * @var Bixie\Cart\Model\Order $order
 * @var Bixie\Download\Model\File $file
 * @var Bixie\Cart\Cart\CartItem $cartItem
 * @var Bixie\Cart\CartModule $cart
 */

?>

<div class="uk-panel uk-panel-box">
	<div class="uk-panel-badge uk-badge <?= ($orderValid ? 'uk-badge-success' : 'uk-badge-danger') ?>">
		<?= __(($orderValid ? 'Download valid' : 'Download expired')) ?>
</div>

	<dl class="uk-description-list uk-description-list-horizontal">
		<dt><?= __('Validity period') ?></dt>
		<dd><?= __($cartItem->get('validity_text')) ?></dd>
		<dt><?= __('Valid until') ?></dt>
		<dd>{{ '<?= $cartItem->get('valid_until', '-') ?>' | date 'medium' }}</dd>
		<dt><?= __('Package name') ?></dt>
		<dd><?= $cartItem->get('product_identifier') ?></dd>
	</dl>

</div>

