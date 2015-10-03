<?php

namespace Bixie\Download\Cart;

use Bixie\Cart\Cart\CartItem;
use Bixie\Cart\Model\Order;
use Bixie\Cart\Model\Product;
use Pagekit\Application as App;
use Pagekit\Event\Event;
use Bixie\Cart\Event\ProductListenerInterface;
use Pagekit\Event\EventSubscriberInterface;
use Bixie\Download\Model\File;
use Pagekit\View\View;

class FileListener implements EventSubscriberInterface, ProductListenerInterface {

	static $periods = [
		'PT3H' => '3 hours',
		'P1D' => '1 days',
		'P2D' => '2 days',
		'P3D' => '3 days',
		'P1W' => '1 week',
		'P2W' => '2 weeks',
		'P1M' => '1 month',
		'P2M' => '2 months',
		'P3M' => '3 months',
		'P6M' => '6 months',
		'P1Y' => '1 year',
		'P2Y' => '2 years',
		'P3Y' => '3 years',
		'P5Y' => '5 years'
	];

	/**
	 * add tab to product edit
	 * @param Event $event
	 * @param $scripts
	 */
	public function onViewScripts ($event, $scripts) {
		$scripts->register('download-section-cart', 'bixie/download:app/bundle/download-section-cart.js', ['~bixie-downloads']);
	}

	/**
	 * Product displayed in admin
	 * @param      $event
	 * @param View $view
	 */
	public function onProductView ($event, View $view) {
		$product = new \stdClass();
		$id = $event['file']->id;
		if (!empty($id)) {

			if (!$product = Product::where(['item_id = ?', 'item_model = ?'], [$id, 'Bixie\Download\Model\File'])->first()) {

				$product = Product::createNew([
					'item_id' => $id,
					'item_model' => 'Bixie\Download\Model\File'
				]);
			}
		}

		$view->data('$cart', [
			'product' => $product,
			'periods' => self::$periods
		]);
	}

	/**
	 * product shown in frontend
	 * @param Event $event
	 * @param File $file
	 * @param View $view
	 */
	public function onProductPrepare ($event, $file, View $view) {
		static $products;
		if (!$products) {
			$products = [];
		}

		if (!empty($file->id) && $file->get('cart_active')) {

			if (!$product = Product::where(['item_id = ?', 'item_model = ?'], [$file->id, 'Bixie\Download\Model\File'])->first()) {

				$product = Product::createNew([
					'item_id' => $file->id,
					'item_model' => 'Bixie\Download\Model\File'
				]);
			}
			$file->product = $product;
			$products[$file->id] = $product;
			$view->script('bixie-cart');
			$view->data('$cart', [
				'products' => $products,
				'periods' => self::$periods,
			]);
		}
	}

	/**
	 * cartItem displayed to user/admin
	 * @param Event    $event
	 * @param Order    $order
	 * @param CartItem $cartItem
	 */
	public function onOrderitem (Event $event, Order $order, CartItem $cartItem) {
		if ($cartItem->item_model == 'Bixie\Download\Model\File') {
			/** @var File $file */
			$file = $cartItem->loadItemModel();
			$orderValid = $this->validateOrder($order, $cartItem, $file);

			$event->addParameters([
				'bixie.admin.order' => App::view('bixie/download/templates/file_admin.php', compact('order', 'cartItem', 'file', 'orderValid')),
				'bixie.cart.order_item' => App::view('bixie/download/templates/file_cart_order_item.php', compact('order', 'cartItem', 'file', 'orderValid'))
			]);

		}
	}

	/**
	 * purchase key calculated from the cartitem
	 * @param Event    $event
	 * @param Order    $order
	 * @param CartItem $cartItem
	 */
	public function onCartPurchaseKey (Event $event, Order $order, CartItem $cartItem) {
		/** @var File $file */
		$file = $cartItem->loadItemModel();
		$orderValid = $this->validateOrder($order, $cartItem, $file);
		$event->addParameters([
			'invalidPurchaseKey' => !empty($event['allowPurchaseKey']) ? $event['allowPurchaseKey'] : !$orderValid
		], true);
	}

	/**
	 * CartItem calculated on checkout
	 * @param Event    $event
	 * @param Order    $order
	 * @param CartItem $cartItem
	 */
	public function onCalculateOrder (Event $event, Order $order, CartItem $cartItem) {
		if ($validity_period = $cartItem->get('validity_period')) {
			$date = (new \DateTime($order->created->format(\DateTime::ISO8601)))->add(new \DateInterval($validity_period));
			$cartItem->set('valid_until', $date->format(\DateTime::ISO8601));
			$cartItem->set('validity_text', self::$periods[$validity_period]);
		} else {
			$cartItem->set('validity_text', 'No end date');
		}
	}

	/**
	 * save event
	 * @param Event $event
	 * @param File $file
	 */
	public function onProductChange ($event, $file) {
		$data = App::request()->request->get('product', []);

		if (!empty($data)) {
			// is new ?
			if (!$product = Product::find($data['id'])) {

				if ($data['id']) {
					App::abort(404, __('Product not found.'));
				}

				$product = Product::createNew($data);
			}

			$product->save($data);

			$file->product = $product;
		}
	}

	/**
	 * @param Event $event
	 * @param File $file
	 */
	public function onProductDeleted ($event, $file) {
		foreach (Product::where(['item_id = :id', 'item_model = :item_model'], [':id' => $file->id, ':item_model' => 'Bixie\Download\Model\File'])->get() as $product) {
			$product->delete();
		}
	}

	/**
	 * @param Order    $order
	 * @param CartItem $cartItem
	 * @param File     $file
	 * @return bool
	 */
	protected function validateOrder (Order $order, CartItem $cartItem, $file) {
		if ($order->isValid()
			and $file->status == File::STATUS_PUBLISHED
			and $file->get('cart_active')) {

			if (!$cartItem->get('validity_period')) {
				return true;
			}

			try {
				$now = new \DateTime();
				$expiry_date = new \DateTime($cartItem->get('valid_until'));
				if ($now < $expiry_date) {
					return true;
				}

			} catch (\Exception $ignore) {
			}

		}
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function subscribe () {
		return [
			'view.scripts' => 'onViewScripts',
			'view.bixie/download/admin/file' => 'onProductView',
			'bixie.prepare.file' => 'onProductPrepare',
			'bixie.calculate.order' => 'onCalculateOrder',
			'bixie.cart.purchaseKey' => 'onCartPurchaseKey',
			'bixie.admin.orderitem' => 'onOrderitem',
			'bixie.cart.orderitem' => 'onOrderitem',
			'model.file.saved' => 'onProductChange',
			'model.file.deleted' => 'onProductDeleted'
		];
	}
}
