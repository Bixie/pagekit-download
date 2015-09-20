<?php $view->style('codemirror'); $view->script('download-settings', 'bixie/download:app/bundle/download-settings.js', ['vue', 'editor']) ?>

<div id="download-settings" class="uk-form">

	<div class="uk-grid pk-grid-large" data-uk-grid-margin>
		<div class="pk-width-sidebar">

			<div class="uk-panel">

				<ul class="uk-nav uk-nav-side pk-nav-large" data-uk-tab="{ connect: '#tab-content' }">
					<li><a><i class="pk-icon-large-settings uk-margin-right"></i> {{ 'Download settings' | trans }}</a></li>
				</ul>

			</div>

		</div>
		<div class="uk-flex-item-1">

			<ul id="tab-content" class="uk-switcher uk-margin">
				<li>

					<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
						<div data-uk-margin>

							<h2 class="uk-margin-remove">{{ 'General settings' | trans }}</h2>

						</div>
						<div data-uk-margin>

							<button class="uk-button uk-button-primary" v-on="click: save">{{ 'Save' | trans }}</button>

						</div>
					</div>

					<div class="uk-form-horizontal">
						<div class="uk-form-row">
							<label class="uk-form-label">{{ 'Projects per page' | trans }}</label>

							<div class="uk-form-controls uk-form-controls-text">
								<p class="uk-form-controls-condensed">
									<input type="number" v-model="config.files_per_page" class="uk-form-width-small">
								</p>
							</div>
						</div>

						<div class="uk-form-row">
							<span class="uk-form-label">{{ 'Markdown' | trans }}</span>

							<div class="uk-form-controls uk-form-controls-text">
								<p class="uk-form-controls-condensed">
									<label><input type="checkbox" v-model="config.markdown_enabled"> {{ 'Enable
										Markdown' | trans }}</label>
								</p>
							</div>
						</div>

						<div class="uk-form-row">
							<label for="form-date_format" class="uk-form-label">{{ 'Date format' | trans }}</label>

							<div class="uk-form-controls">
								<select name="date_format" id="form-date_format" class="uk-form-width-small"
										v-model="config.date_format">
									<option value="F Y">{{ 'January 2015' | trans }}</option>
									<option value="F d Y">{{ 'January 15 2015' | trans }}</option>
									<option value="d F Y">{{ '15 January 2015' | trans }}</option>
									<option value="M Y">{{ 'Jan 2015' | trans }}</option>
									<option value="m Y">{{ '1 2015' | trans }}</option>
									<option value="m-d-Y">{{ '1-15-2015' | trans }}</option>
									<option value="d-m-Y">{{ '15-1-2015' | trans }}</option>
								</select>
							</div>
						</div>

						<div class="uk-form-row">
							<span class="uk-form-label">{{ 'Tags' | trans }}</span>
							<div class="uk-form-controls">
								<input-tags tags="{{@ config.tags}}" existing="{{ tags }}"></input-tags>
							</div>
						</div>
					</div>

				</li>
			</ul>

		</div>
	</div>

</div>
