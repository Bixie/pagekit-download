<?php $view->script('dl-admin-categories', 'bixie/download:app/bundle/admin-categories.js', ['vue', 'uikit-nestable']) ?>


<div id="download-categories" class="uk-form" v-cloak>


			<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
				<div class="uk-flex uk-flex-middle uk-flex-wrap" data-uk-margin>

					<h2 class="uk-margin-remove">{{ 'Categories' | trans }}</h2>

					<div class="uk-margin-left" v-show="selected.length">
						<ul class="uk-subnav pk-subnav-icon">
							<li><a class="pk-icon-check pk-icon-hover" title="{{ 'Publish' | trans }}" data-uk-tooltip="{delay: 500}" v-on="click: status(1)"></a></li>
							<li><a class="pk-icon-block pk-icon-hover" title="{{ 'Unpublish' | trans }}" data-uk-tooltip="{delay: 500}" v-on="click: status(0)"></a></li>
							<li v-show="showDelete"><a class="pk-icon-delete pk-icon-hover" title="{{ 'Delete' | trans }}" data-uk-tooltip="{delay: 500}" v-on="click: removeCategories" v-confirm="'Delete category?'"></a></li>
						</ul>
					</div>

				</div>
				<div class="uk-position-relative" data-uk-margin>

					<div data-uk-dropdown="{ mode: 'click' }">
						<a class="uk-button uk-button-primary" v-attr="href: $url.route('admin/download/category/edit')">{{ 'Add category' | trans }}</a>
					</div>

				</div>
			</div>

			<div class="uk-overflow-container">

				<div class="pk-table-fake pk-table-fake-header" v-class="pk-table-fake-border: !tree[0]">
					<div class="pk-table-width-minimum pk-table-fake-nestable-padding"><input type="checkbox" v-check-all="selected: input[name=id]" number></div>
					<div class="pk-table-min-width-100">{{ 'Title' | trans }}</div>
					<div class="pk-table-width-100 uk-text-center">{{ 'Status' | trans }}</div>
					<div class="pk-table-width-100">{{ 'Items' | trans }}</div>
					<div class="pk-table-width-200">{{ 'path' | trans }}</div>
				</div>

				<ul class="uk-nestable uk-margin-remove" v-el="nestable" v-show="tree[0]">
					<category v-repeat="category: tree[0]"></category>
				</ul>

			</div>

			<h3 class="uk-h1 uk-text-muted uk-text-center" v-show="!tree[0]">{{ 'No categories found.' | trans }}</h3>


</div>

<script id="category" type="text/template">

	<li class="uk-nestable-item" v-class="uk-parent: tree[category.id], uk-active: isSelected(category)" data-id="{{ category.id }}">
		<div class="uk-nestable-panel pk-table-fake uk-form uk-visible-hover">
			<div class="pk-table-width-minimum pk-table-collapse">
				<div class="uk-nestable-toggle" data-nestable-action="toggle"></div>
			</div>
			<div class="pk-table-width-minimum"><input type="checkbox" name="id" value="{{ category.id }}"></div>
			<div class="pk-table-min-width-100">
				<a v-attr="href: $url.route('admin/download/category/edit', { id: category.id })">{{ category.title }}</a>
			</div>
			<div class="pk-table-width-100 uk-text-center">
				<td class="uk-text-center">
					<a v-class="pk-icon-circle-danger: !category.status, pk-icon-circle-success: category.status" v-on="click: toggleStatus(category)"></a>
				</td>
			</div>
			<div class="pk-table-width-100">
				<a v-attr="href: $url.route('admin/download/download', { filter: {category_id: category.id} })">{{ category.files.length }}</a>
			</div>
			<div class="pk-table-width-200 pk-table-max-width-150 uk-text-break">
				<span>{{ category.path }}</span>
			</div>
		</div>

		<ul class="uk-nestable-list" v-if="tree[category.id]">
			<category v-repeat="category: tree[category.id]" track-by="category.id"></category>
		</ul>

	</li>

</script>


