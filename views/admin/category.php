<?php
$view->style('codemirror');
$view->style('uikit-sortable');
$view->script('dl-admin-category', 'bixie/download:app/bundle/admin-category.js', ['vue', 'editor', 'uikit-sortable']); ?>

<form id="category-edit" class="uk-form" name="form" v-validator="form" v-on="submit: save | valid" v-cloak>

	<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
		<div data-uk-margin>

			<h2 class="uk-margin-remove" v-if="file.id">{{ 'Edit category' | trans }} <em>{{
					category.title | trans }}</em> <a v-attr="href: $url.route(category.url)" target="_blank"
													 class="uk-icon-external-link uk-icon-hover uk-text-small uk-margin-small-left"
													 title="{{ 'View category' | trans }}"
													 data-uk-tooltip="{delay:500}"></a></h2>

			<h2 class="uk-margin-remove" v-if="!file.id">{{ 'Add category' | trans }}</h2>

		</div>
		<div data-uk-margin>

			<a class="uk-button uk-margin-small-right" v-attr="href: $url.route('admin/download/categories')">{{ category.id ?
				'Close' :
				'Cancel' | trans }}</a>
			<button class="uk-button uk-button-primary" type="submit">{{ 'Save' | trans }}</button>

		</div>
	</div>


	<div class="uk-grid pk-grid-large uk-form-stacked" data-uk-grid-margin>
		<div class="uk-flex-item-1">

			<div class="uk-form-row">
				<input class="uk-width-1-1 uk-form-large" type="text" name="category[title]" placeholder="{{ 'Enter Title' | trans }}" v-model="category.title" v-validate="required" lazy>

				<div class="uk-form-help-block uk-text-danger" v-show="form['category[title]'].invalid">{{ 'Title cannot be blank.' | trans }}</div>
			</div>

			<div class="uk-form-row">
				<v-editor value="{{@ category.data.description }}" options="{{ {markdown : category.data.markdown} }}"></v-editor>
				<p>
					<label><input type="checkbox" v-model="category.data.markdown"> {{ 'Enable Markdown' | trans }}</label>
				</p>
			</div>

		</div>
		<div class="pk-width-sidebar pk-width-sidebar-large">

			<div class="uk-panel">

				<div class="uk-form-row">
					<label class="uk-form-label">{{ 'Image' | trans }}</label>
					<div class="uk-form-controls">
						<input-image source="{{@ category.data.image }}" class="pk-image-max-height"></input-image>
					</div>
				</div>

				<div class="uk-form-row">
					<label for="form-slug" class="uk-form-label">{{ 'Slug' | trans }}</label>

					<div class="uk-form-controls">
						<input id="form-slug" class="uk-form-width-large" type="text" v-model="category.slug">
					</div>
				</div>

				<div class="uk-form-row">
					<label for="form-status" class="uk-form-label">{{ 'Status' | trans }}</label>

					<div class="uk-form-controls">
						<select id="form-status" class="uk-form-width-large" v-model="category.status">
							<option value="0">{{ 'Disabled' | trans }}</option>
							<option value="1">{{ 'Enabled' | trans }}</option>
						</select>
					</div>
				</div>

				<div class="uk-form-row">
					<span class="uk-form-label">{{ 'Restrict Access' | trans }}</span>

					<div class="uk-form-controls uk-form-controls-text">
						<p v-repeat="role: roles" class="uk-form-controls-condensed">
							<label><input type="checkbox" value="{{ role.id }}" v-checkbox="category.roles" number> {{ role.name }}</label>
						</p>
					</div>
				</div>

				<h3>{{ 'Files in category' | trans }}</h3>
				<ul class="uk-sortable uk-list uk-list-line" v-el="sortable">
					<li v-repeat="file: category.files" data-id="{{file.id}}" class="uk-nestable-item uk-flex uk-visible-hover">
						<h4 class="uk-flex-item-1 uk-margin-remove uk-text-truncate"><a v-attr="href: $url.route('admin/download/file/edit', { id: file.id })">
								{{ file.title }}</a></h4>
						<div class="uk-margin-small-right"><i class="pk-icon-move pk-icon-hover uk-invisible"></i></div>
					</li>
				</ul>

			</div>

		</div>
	</div>


</form>

