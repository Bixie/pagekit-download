<?php  $view->style('codemirror'); $view->script('admin-file', 'bixie/download:app/bundle/admin-file.js', ['vue', 'editor', 'bixie-downloads']); ?>

<form id="file-edit" class="uk-form" name="form" v-validator="form" @submit.prevent="save | valid" v-cloak>

	<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
		<div data-uk-margin>

			<h2 class="uk-margin-remove" v-if="file.id">{{ 'Edit download' | trans }} <em>{{
					file.title | trans }}</em> <a :href="$url.route(file.url)" target="_blank"
													 class="uk-icon-external-link uk-icon-hover uk-text-small uk-margin-small-left"
													 title="{{ 'Preview download' | trans }}"
													 data-uk-tooltip="{delay:500}"></a></h2>

			<h2 class="uk-margin-remove" v-else>{{ 'Add download' | trans }}</h2>

		</div>
		<div data-uk-margin>

			<a class="uk-button uk-margin-small-right" :href="$url.route('admin/download/download')">{{ file.id ?
				'Close' :
				'Cancel' | trans }}</a>
			<button class="uk-button uk-button-primary" type="submit">{{ 'Save' | trans }}</button>

		</div>
	</div>

	<ul class="uk-tab" v-el:tab>
		<li><a>{{ 'General' | trans }}</a></li>
		<li v-for="section in sections | orderBy 'priority'"><a>{{ section.label | trans }}</a></li>
	</ul>

	<div class="uk-switcher uk-margin" v-el:content>
		<div class="uk-grid pk-grid-large" data-uk-grid-margin>
			<div class="uk-flex-item-1">
				<div class="uk-form-horizontal uk-margin">
					<div class="uk-form-row">
						<label for="form-title" class="uk-form-label">{{ 'Title' | trans }}</label>

						<div class="uk-form-controls">
							<input id="form-title" class="uk-width-1-1 uk-form-large" type="text" name="title"
								   v-model="file.title" v-validate="required">
						</div>
						<p class="uk-form-help-block uk-text-danger" v-show="form.title.invalid">
							{{ 'Please enter a title' | trans }}</p>
					</div>

					<div class="uk-form-row">
						<label for="form-subtitle" class="uk-form-label">{{ 'Subitle' | trans }}</label>

						<div class="uk-form-controls">
							<input id="form-subtitle" class="uk-width-1-1" type="text" name="subtitle"
								   v-model="file.subtitle">
						</div>
					</div>

				</div>


				<div class="uk-form-stacked uk-margin">
					<div class="uk-form-row">
						<span class="uk-form-label">{{ 'Content' | trans }}</span>

						<div class="uk-form-controls">
							<v-editor id="form-content" :value.sync="file.content"
									  :options="{markdown : file.data.markdown}"></v-editor>
						</div>
						<p class="uk-form-controls-condensed">
							<label><input type="checkbox" v-model="file.data.markdown"> {{ 'Enable
								Markdown' | trans }}</label>
						</p>
					</div>
				</div>

				<div class="uk-grid uk-margin uk-grid-width-medium-1-2 uk-form-stacked" data-uk-grid-margin="">
					<div>

						<div class="uk-form-row">
							<label class="uk-form-label">{{ 'Image' | trans }}</label>
							<div class="uk-form-controls">
								<input-image-meta :image.sync="file.image.main" class="pk-image-max-height"></input-image-meta>
							</div>
						</div>

					</div>
					<div>

						<div class="uk-form-row">
							<label class="uk-form-label">{{ 'Icon' | trans }}</label>
							<div class="uk-form-controls">
								<input-image-meta :image.sync="file.image.icon" class="pk-image-max-height"></input-image-meta>
							</div>
						</div>

					</div>
				</div>

			</div>
			<div class="pk-width-sidebar pk-width-sidebar-large uk-form-stacked">

				<div class="uk-form-row">
					<label class="uk-form-label">{{ 'File' | trans }}</label>

					<div class="uk-form-controls">
						<input-file :file.sync="file.path" :ext="config.file_extensions"></input-file>
						<input type="hidden" name="path" v-model="file.path" v-validate="required">
					</div>
					<p class="uk-form-help-block uk-text-danger" v-show="form.path.invalid">
						{{ 'Please select a file' | trans }}</p>
				</div>

				<div class="uk-form-row">
					<label for="form-slug" class="uk-form-label">{{ 'Slug' | trans }}</label>

					<div class="uk-form-controls">
						<input id="form-slug" class="uk-width-1-1" type="text" v-model="file.slug">
					</div>
				</div>

				<div class="uk-form-row">
					<label for="form-status" class="uk-form-label">{{ 'Status' | trans }}</label>
					<div class="uk-form-controls">
						<select id="form-status" class="uk-width-1-1" v-model="file.status" options="statusOptions">
							<option v-for="status in statuses" :value="$key">{{ status }}</option>
						</select>
					</div>
				</div>

				<div class="uk-form-row">
					<label for="form-status" class="uk-form-label">{{ 'Downloads' | trans }}</label>
					<div class="uk-form-controls uk-form-controls-text uk-flex uk-flex-middle uk-flex-space-between">
						<strong class="uk-h4">{{ file.downloads }}</strong>
						<button type="button" class="uk-button uk-button-small" @click="resetDownloads"
								v-confirm="'Reset download counter?' | trans">{{ 'Reset' | trans }}</button>
					</div>
				</div>

				<div class="uk-form-row">
					<span class="uk-form-label">{{ 'Restrict Access' | trans }}</span>
					<div class="uk-form-controls uk-form-controls-text">
						<p v-for="role in roles" class="uk-form-controls-condensed">
							<label><input type="checkbox" :value="role.id" v-model="file.roles" number> {{ role.name }}</label>
						</p>
					</div>
				</div>

				<div class="uk-form-row">
					<span class="uk-form-label">{{ 'Categories' | trans }}</span>
					<div class="uk-form-controls">
						<input-category :values.sync="file.category_ids" :primary.sync="file.data.primary_category" :categories="categories"></input-category>
					</div>
				</div>

				<div class="uk-form-row">
					<span class="uk-form-label">{{ 'Tags' | trans }}</span>
					<div class="uk-form-controls">
						<input-tags :tags.sync="file.tags" :existing="tags"></input-tags>
					</div>
				</div>

			</div>
		</div>

		<div v-for="section in sections | orderBy 'priority'">
			<component :is="section.name"
					   :file.sync="file"
					   :config="config"
					   :form="form"></component>
		</div>
	</div>

</form>

