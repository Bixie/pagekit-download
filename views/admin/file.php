<?php  $view->style('codemirror'); $view->script('admin-file', 'bixie/download:app/bundle/admin-file.js', ['vue', 'editor']); ?>

<form id="file-edit" class="uk-form" name="form" v-on="submit: save | validate" v-cloak>

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

			<a class="uk-button uk-margin-small-right" v-attr="href: $url.route('admin/download/file')">{{ file.id ?
				'Close' :
				'Cancel' | trans }}</a>
			<button class="uk-button uk-button-primary" type="submit">{{ 'Save' | trans }}</button>

		</div>
	</div>

	<ul class="uk-tab" v-el="tab">
		<li><a>{{ 'General' | trans }}</a></li>
	</ul>

	<div class="uk-switcher uk-margin" v-el="content">
		<div>
			<div class="uk-margin">
				<div class="uk-grid pk-grid-large" data-uk-grid-margin>
					<div class="uk-flex-item-1">
						<div class="uk-form-horizontal uk-margin">
							<div class="uk-form-row">
								<label for="form-title" class="uk-form-label">{{ 'Title' | trans }}</label>

								<div class="uk-form-controls">
									<input id="form-title" class="uk-width-1-1 uk-form-large" type="text" name="title"
										   v-model="file.title" v-valid="required">
								</div>
								<p class="uk-form-help-block uk-text-danger" v-show="form.title.invalid">{{ 'Please enter a
									title' | trans }}</p>
							</div>

						</div>


						<div class="uk-form-stacked uk-margin">
							<div class="uk-form-row">
								<span class="uk-form-label">{{ 'Content' | trans }}</span>

								<div class="uk-form-controls">
									<v-editor id="form-content" value="{{@ file.content }}"
											  options="{{ {markdown : file.data.markdown} }}"></v-editor>
								</div>
							</div>
						</div>

					</div>
					<div class="pk-width-sidebar pk-width-sidebar-large uk-form-stacked">

						<div class="uk-form-row">
							<label for="form-slug" class="uk-form-label">{{ 'Slug' | trans }}</label>

							<div class="uk-form-controls">
								<input id="form-slug" class="uk-width-1-1" type="text" v-model="file.slug">
							</div>
						</div>


						<div class="uk-form-row">
							<label class="uk-form-label">{{ 'File' | trans }}</label>

							<div class="uk-form-controls">
								<input-file file="{{@ file.path }}" ext="{{ ['zip', 'rar', 'tar.gz'] }}"></input-file>
							</div>
						</div>

						<div class="uk-form-row">
							<span class="uk-form-label">{{ 'Date' | trans }}</span>
							<div class="uk-form-controls">
								<input-date datetime="{{@ file.date}}"></input-date>
							</div>
						</div>

						<div class="uk-form-row">
							<span class="uk-form-label">{{ 'Tags' | trans }}</span>
							<div class="uk-form-controls">
								<input-tags tags="{{@ file.tags}}" existing="{{ tags }}"></input-tags>
							</div>
						</div>

						<div class="uk-form-row">
							<span class="uk-form-label">{{ 'Options' | trans }}</span>
							<div class="uk-form-controls uk-form-controls-text">
								<label>
									<input type="checkbox" value="markdown" v-model="file.data.markdown"> {{ 'Enable Markdown' |
									trans }}</label>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

</form>

