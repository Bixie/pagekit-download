<?php $view->script('admin-download', 'bixie/download:app/bundle/admin-download.js', ['bixie-pkframework']) ?>

<div id="download-files" class="uk-form uk-form-horizontal" v-cloak>

	<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
		<div class="uk-flex uk-flex-middle uk-flex-wrap" data-uk-margin>

			<h2 class="uk-margin-remove" v-show="!selected.length">{{ '{0} %count% Downloads|{1} %count% Download|]1,Inf[ %count% Downloads' | transChoice count {count:count} }}</h2>
			<h2 class="uk-margin-remove" v-else>{{ '{1} %count% Download selected|]1,Inf[ %count% Downloads selected' | transChoice selected.length {count:selected.length} }}</h2>

			<div class="uk-margin-left" v-show="selected.length">
				<ul class="uk-subnav pk-subnav-icon">
					<li><a class="pk-icon-check pk-icon-hover" title="Publish" data-uk-tooltip="{delay: 500}" @click.prevent="status(1)"></a></li>
					<li><a class="pk-icon-block pk-icon-hover" title="Unpublish" data-uk-tooltip="{delay: 500}" @click.prevent="status(0)"></a></li>
					<li><a class="pk-icon-delete pk-icon-hover" title="{{ 'Delete' | trans }}"
						   data-uk-tooltip="{delay: 500}" @click.prevent="removeFiles"
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
				<a class="uk-button uk-button-primary" :href="$url.route('admin/download/file/edit')">
					{{ 'Add download' | trans }}</a>

			</div>

		</div>
	</div>

	<div class="uk-overflow-container">
		<table class="uk-table uk-table-hover uk-table-middle">
			<thead>
			<tr>
				<th class="pk-table-width-minimum"><input type="checkbox" v-check-all:selected.literal="input[name=id]" number></th>
				<th class="pk-table-min-width-200" v-order:title="config.filter.order">{{ 'Title' | trans }}</th>
				<th class="pk-table-width-100 uk-text-center">
					<input-filter :title="$trans('Status')" :value.sync="config.filter.status" :options="statusOptions"></input-filter>
				</th>
				<th class="pk-table-width-100" v-order:downloads="config.filter.order">{{ 'Downloads' | trans }}</th>
				<th class="pk-table-width-100" v-order:date="config.filter.order">{{ 'Date' | trans }}</th>
				<th class="pk-table-min-width-100">
					<input-filter :title="$trans('Categories')" :value.sync="config.filter.category_id" :options="categoryOptions"></input-filter>
				</th>
				<th class="pk-table-min-width-100">{{ 'Tags' | trans }}</th>
				<th class="pk-table-width-200">{{ 'URL' | trans }}</th>
			</tr>
			</thead>
			<tbody>
			<tr class="check-item" v-for="file in files" :class="{'uk-active': active(file)}">
				<td><input type="checkbox" name="id" value="{{ file.id }}"></td>
				<td>
					<a :href="$url.route('admin/download/file/edit', { id: file.id })">{{ file.title }}</a><br>
					<small>
						{{ 'File' | trans }}: <a :href="$url.route(file.download)" download="{{ file.fileName }}">{{ file.fileName }}</a>
					</small>
				</td>
				<td class="uk-text-center">
					<a title="{{ getStatusText(file) }}" :class="{
                                'pk-icon-circle-danger': file.status == 0,
                                'pk-icon-circle-success': file.status == 1
                            }" @click.prevent="toggleStatus(file)"></a>
				</td>
				<td>
					{{ file.downloads }}
				</td>
				<td>
					{{ file.date | date }}
				</td>
				<td>
					{{ file.category_titles.join(', ') }}
				</td>
				<td>
					{{ file.tags.join(', ') }}
				</td>
				<td class="pk-table-text-break">
					<a :href="$url.route(file.url)" target="_blank">{{ file.url }}</a>
				</td>
			</tr>
			</tbody>
		</table>
	</div>


	<h3 class="uk-h1 uk-text-muted uk-text-center"
		v-show="files && !files.length">{{ 'No downloads found.' | trans }}</h3>

	<v-pagination :page.sync="config.page" :pages="pages" v-show="pages > 1"></v-pagination>

</div>
