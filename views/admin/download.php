<?php $view->script('admin-download', 'bixie/download:app/bundle/admin-download.js', ['vue']) ?>

<div id="download-files" class="uk-form uk-form-horizontal" v-cloak>

	<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
		<div class="uk-flex uk-flex-middle uk-flex-wrap" data-uk-margin>

			<h2 class="uk-margin-remove" v-show="!selected.length">{{ '{0} %count% Downloads|{1} %count% Download|]1,Inf[ %count% Downloads' | transChoice count {count:count} }}</h2>
			<h2 class="uk-margin-remove" v-show="selected.length">{{ '{1} %count% Download selected|]1,Inf[ %count% Downloads selected' | transChoice selected.length {count:selected.length} }}</h2>

			<div class="uk-margin-left" v-show="selected.length">
				<ul class="uk-subnav pk-subnav-icon">
					<li><a class="pk-icon-delete pk-icon-hover" title="{{ 'Delete' | trans }}"
						   data-uk-tooltip="{delay: 500}" v-on="click: removeFiles"
						   v-confirm="'Delete file? All data will be deleted from the database.' | trans"></a>
					</li>
				</ul>
			</div>

			<div class="pk-search">
				<div class="uk-search">
					<input class="uk-search-field" type="text" v-model="config.filter.search" debounce="300">
				</div>
			</div>


		</div>
		<div class="uk-position-relative" data-uk-margin>

			<div data-uk-dropdown="{ mode: 'click' }">
				<a class="uk-button uk-button-primary" v-attr="href: $url.route('admin/download/file/edit')">
					{{ 'Add download' | trans }}</a>

			</div>

		</div>
	</div>

	<div class="uk-overflow-container">
		<table class="uk-table uk-table-hover uk-table-middle">
			<thead>
			<tr>
				<th class="pk-table-width-minimum"><input type="checkbox" v-check-all="selected: input[name=id]" number></th>
				<th class="pk-table-min-width-200" v-order="title: config.filter.order">{{ 'Title' | trans }}</th>
				<th class="pk-table-width-100 uk-text-center">
					<input-filter title="{{ 'Status' | trans }}" value="{{@ config.filter.status}}" options="{{ statusOptions }}"></input-filter>
				</th>
				<th class="pk-table-width-100" v-order="date: config.filter.order">{{ 'Date' | trans }}</th>
				<th class="pk-table-min-width-100">{{ 'Tags' | trans }}</th>
				<th class="pk-table-width-200">{{ 'URL' | trans }}</th>
				<th class="pk-table-width-200">{{ 'File' | trans }}</th>
			</tr>
			</thead>
			<tbody>
			<tr class="check-item" v-repeat="file: files" v-class="uk-active: active(file)">
				<td><input type="checkbox" name="id" value="{{ file.id }}"></td>
				<td>
					<a v-attr="href: $url.route('admin/download/file/edit', { id: file.id })">{{ file.title }}</a>
				</td>
				<td class="uk-text-center">
					<a title="{{ getStatusText(file) }}" v-class="
                                pk-icon-circle-danger: file.status == 0,
                                pk-icon-circle-success: file.status == 1
                            " v-on="click: toggleStatus(file)"></a>
				</td>
				<td>
					{{ file.date | date }}
				</td>
				<td>
					{{ file.tags.join(', ') }}
				</td>
				<td class="pk-table-text-break">
					<a v-attr="href: $url.route(file.url)" target="_blank">{{ file.url }}</a>
				</td>
				<td class="pk-table-text-break">
					<a v-attr="href: $url.route(file.download)" download="{{ file.fileName }}">{{ file.fileName }}</a>
				</td>
			</tr>
			</tbody>
		</table>
	</div>


	<h3 class="uk-h1 uk-text-muted uk-text-center"
		v-show="files && !files.length">{{ 'No downloads found.' | trans }}</h3>

	<v-pagination page="{{@ config.page }}" pages="{{ pages }}" v-show="pages > 1"></v-pagination>

</div>
