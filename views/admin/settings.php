<?php $view->style('codemirror');
$view->script('download-settings', 'bixie/download:app/bundle/download-settings.js', ['bixie-pkframework', 'uikit-nestable', 'editor']) ?>

<div id="download-settings" class="uk-form">

	<div class="uk-grid pk-grid-large" data-uk-grid-margin>
		<div class="pk-width-sidebar">

			<div class="uk-panel">

				<ul class="uk-nav uk-nav-side pk-nav-large" data-uk-tab="{ connect: '#tab-content' }">
					<li><a><i class="pk-icon-large-code uk-margin-right"></i> {{ 'Main page content' | trans }}</a></li>
					<li><a><i class="pk-icon-large-settings uk-margin-right"></i> {{ 'Main page settings' | trans }}</a></li>
					<li><a><i class="pk-icon-large-settings uk-margin-right"></i> {{ 'Category page settings' | trans }}</a></li>
					<li><a><i class="pk-icon-large-settings uk-margin-right"></i> {{ 'Detail page settings' | trans }}</a></li>
					<li><a><i class="pk-icon-large-settings uk-margin-right"></i> {{ 'General settings' | trans }}</a></li>
					<li><a><i class="pk-icon-large-database uk-margin-right"></i> {{ 'Data fields' | trans }}</a></li>
				</ul>

			</div>

		</div>
		<div class="pk-width-content">

			<ul id="tab-content" class="uk-switcher uk-margin">
				<li>

					<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
						<div data-uk-margin>

							<h2 class="uk-margin-remove">{{ 'Main page content' | trans }}</h2>

						</div>
						<div data-uk-margin>

							<button class="uk-button uk-button-primary" @click="save">{{ 'Save' | trans }}</button>

						</div>
					</div>

					<div class="uk-grid" data-uk-grid-margin="">
					    <div class="uk-width-large-3-4">
							<div class="uk-form-horizontal">

								<div class="uk-form-row">
									<label for="form-mainpagetitle" class="uk-form-label">{{ 'Main page title' | trans }}</label>

									<div class="uk-form-controls">
										<input id="form-mainpagetitle" class="uk-width-1-1" type="text" name="mainpage_title"
											   v-model="config.mainpage_title">
									</div>
								</div>
							</div>


							<div class="uk-form-stacked uk-margin">
								<div class="uk-form-row">
									<span class="uk-form-label">{{ 'Main page text' | trans }}</span>

									<div class="uk-form-controls">
										<v-editor id="form-intro" :value.sync="config.mainpage_text"
												  :options="{markdown : config.markdown_enabled, height: 250}"></v-editor>
									</div>
								</div>
							</div>

						</div>
					    <div class="uk-width-large-1-4">
							<div class="uk-form-stacked">

								<div class="uk-form-row">
									<label class="uk-form-label">{{ 'Image' | trans }}</label>
									<div class="uk-form-controls">
										<input-image :source.sync="config.mainpage_image" class="pk-image-max-height"></input-image>
									</div>
								</div>

								<div class="uk-form-row">
									<label for="form-mainpage_image_align" class="uk-form-label">{{ 'Image align' | trans }}</label>

									<div class="uk-form-controls">
										<select name="mainpage_image_align" id="form-mainpage_image_align" class="uk-form-width-small"
												v-model="config.mainpage_image_align">
											<option value="left">{{ 'Left' | trans }}</option>
											<option value="right">{{ 'Right' | trans }}</option>
											<option value="center">{{ 'Center' | trans }}</option>
										</select>
									</div>
								</div>

							</div>
						</div>
					</div>

				</li>
				<li>

					<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
						<div data-uk-margin>

							<h2 class="uk-margin-remove">{{ 'Main page settings' | trans }}</h2>

						</div>
						<div data-uk-margin>

							<button class="uk-button uk-button-primary" @click="save">{{ 'Save' | trans }}</button>

						</div>
					</div>
					<div class="uk-grid uk-grid-width-large-1-2 uk-form-horizontal" data-uk-grid-margin="">
						<div>

							<bixie-fields :config="$options.fields.download" :values.sync="config"></bixie-fields>
						</div>
						<div>
							<h3>{{ 'Teaser settings' | trans }}</h3>
							<div class="uk-form-row">
								<span class="uk-form-label">{{ 'Show content' | trans }}</span>

								<div class="uk-form-controls uk-form-controls-text">

									<bixie-fields-raw :config="$options.fields.teaser_show" :values.sync="config"></bixie-fields-raw>

								</div>
							</div>

							<bixie-fields :config="$options.fields.teaser" :values.sync="config"></bixie-fields>
						</div>
					</div>
				</li>
				<li>

					<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
						<div data-uk-margin>

							<h2 class="uk-margin-remove">{{ 'Category page settings' | trans }}</h2>

						</div>
						<div data-uk-margin>

							<button class="uk-button uk-button-primary" @click="save">{{ 'Save' | trans }}</button>

						</div>
					</div>
					<div class="uk-grid uk-grid-width-large-1-2 uk-form-horizontal" data-uk-grid-margin="">
						<div>

							<bixie-fields :config="$options.fields.category" :values.sync="config"></bixie-fields>
						</div>
						<div>
							<div class="uk-form-row">
								<span class="uk-form-label">{{ 'Show content' | trans }}</span>

								<div class="uk-form-controls uk-form-controls-text">

									<bixie-fields-raw :config="$options.fields.category_show" :values.sync="config"></bixie-fields-raw>

								</div>
							</div>

						</div>
					</div>
				</li>
				<li>

					<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
						<div data-uk-margin>

							<h2 class="uk-margin-remove">{{ 'Detail page settings' | trans }}</h2>

						</div>
						<div data-uk-margin>

							<button class="uk-button uk-button-primary" @click="save">{{ 'Save' | trans }}</button>

						</div>
					</div>
					<div class="uk-grid uk-grid-width-large-1-2 uk-form-horizontal" data-uk-grid-margin="">
						<div>

							<bixie-fields :config="$options.fields.file" :values.sync="config"></bixie-fields>
						</div>
						<div>
							<div class="uk-form-row">
								<span class="uk-form-label">{{ 'Show content' | trans }}</span>

								<div class="uk-form-controls uk-form-controls-text">

									<bixie-fields-raw :config="$options.fields.category_show" :values.sync="config"></bixie-fields-raw>

								</div>
							</div>

						</div>
					</div>
				</li>
				<li>

					<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
						<div data-uk-margin>

							<h2 class="uk-margin-remove">{{ 'General settings' | trans }}</h2>

						</div>
						<div data-uk-margin>

							<button class="uk-button uk-button-primary" @click="save">{{ 'Save' | trans }}</button>

						</div>
					</div>

					<div class="uk-form-horizontal">

						<bixie-fields :config="$options.fields.general" :values.sync="config"></bixie-fields>

						<div class="uk-form-row">
							<span class="uk-form-label">{{ 'File extensions' | trans }}</span>
							<div class="uk-form-controls">
								<input-tags :tags.sync="config.file_extensions"
											:existing="['zip', 'rar', 'tar.gz', 'exe', 'jp?g', 'png']"></input-tags>
							</div>
						</div>

						<div class="uk-form-row">
							<span class="uk-form-label">{{ 'Tags' | trans }}</span>
							<div class="uk-form-controls">
								<input-tags :tags.sync="config.tags" :existing="tags"></input-tags>
							</div>
						</div>
					</div>

				</li>
				<li>

					<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
						<div data-uk-margin>

							<h2 class="uk-margin-remove">{{ 'Custom data fields' | trans }}</h2>

						</div>
						<div data-uk-margin>

							<button class="uk-button uk-button-primary" @click="save">{{ 'Save' | trans }}</button>

						</div>
					</div>

					<div class="uk-form-horizontal">

						<ul class="uk-nestable uk-margin-remove" v-el:datafields-nestable
							v-show="config.datafields.length">
							<datafield v-for="datafield in config.datafields" :datafield="datafield"></datafield>
						</ul>

						<button type="button" class="uk-button uk-button-primary uk-button-small uk-margin"
								@click="addDatafield">{{ 'Add option' | trans }}
						</button>

					</div>
				</li>
			</ul>

		</div>
	</div>

</div>
