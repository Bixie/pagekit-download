<?php  $view->style('codemirror'); $view->script('admin-file', 'bixie/download:app/bundle/admin-file.js', ['vue', 'editor', 'bixie-downloads']); ?>

<form id="file-edit" class="uk-form" name="form" v-validator="form" v-on="submit: save | valid" v-cloak>

	<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
		<div data-uk-margin>

			<h2 class="uk-margin-remove" v-if="file.id">{{ 'Edit download' | trans }} <em>{{
					file.title | trans }}</em> <a v-attr="href: $url.route(file.url)" target="_blank"
													 class="uk-icon-external-link uk-icon-hover uk-text-small uk-margin-small-left"
													 title="{{ 'Preview download' | trans }}"
													 data-uk-tooltip="{delay:500}"></a></h2>

			<h2 class="uk-margin-remove" v-if="!file.id">{{ 'Add download' | trans }}</h2>

		</div>
		<div data-uk-margin>

			<a class="uk-button uk-margin-small-right" v-attr="href: $url.route('admin/download/download')">{{ file.id ?
				'Close' :
				'Cancel' | trans }}</a>
			<button class="uk-button uk-button-primary" type="submit">{{ 'Save' | trans }}</button>

		</div>
	</div>

	<ul class="uk-tab" v-el="tab">
		<li v-repeat="section: sections | orderBy 'priority'"><a>{{ section.label | trans }}</a></li>
	</ul>

	<div class="uk-switcher uk-margin" v-el="content">
		<div v-repeat="section: sections | active | orderBy 'priority'">
			<component is="{{ section.name }}"></component>
		</div>
	</div>

</form>

