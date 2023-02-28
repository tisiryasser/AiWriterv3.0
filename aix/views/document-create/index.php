<?php defined('ALTUMCODE') || die() ?>


<div class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <nav aria-label="breadcrumb">
        <ol class="custom-breadcrumbs small">
            <li>
                <a href="<?= url('documents') ?>"><?= l('documents.breadcrumb') ?></a><i class="fa fa-fw fa-angle-right"></i>
            </li>
            <li class="active" aria-current="page"><?= l('document_create.breadcrumb') ?></li>
        </ol>
    </nav>

    <h1 class="h4 text-truncate mb-4"><?= l('document_create.header') ?></h1>

    <div class="card">
        <div class="card-body">

            <form id="document_create" action="" method="post" role="form">
                <input type="hidden" name="global_token" value="<?= \Altum\Csrf::get('global_token') ?>" />

                <div class="notification-container"></div>

                <div class="form-group">
                    <label for="name"><i class="fa fa-fw fa-signature fa-sm text-muted mr-1"></i> <?= l('global.name') ?></label>
                    <input type="text" id="name" name="name" class="form-control" value="<?= $data->values['name'] ?>" required="required" />
                </div>

                <div class="form-group">
                    <label for="type"><i class="fa fa-fw fa-fingerprint fa-sm text-muted mr-1"></i> <?= l('documents.type') ?></label>
                    <div class="row btn-group-toggle" data-toggle="buttons">
                        <?php foreach($data->ai_types as $key => $value): ?>
                            <?php if(settings()->aix->available_types->{$key}): ?>
                            <div class="col-12 col-lg-6">
                                <label class="btn btn-light btn-block">
                                    <input type="radio" name="type" value="<?= $key ?>" class="custom-control-input" <?= $data->values['type'] == $key ? 'checked="checked"' : null ?> />
                                    <i class="<?= $data->ai_types[$key]['icon'] ?> fa-fw fa-sm mr-1"></i> <?= l('documents.type.' . $key) ?>
                                </label>
                            </div>
                            <?php endif ?>
                        <?php endforeach ?>
                    </div>
                </div>

                <?php foreach($data->ai_types as $key => $value): ?>
                    <?php if(settings()->aix->available_types->{$key}): ?>

                        <?php if($value['single_input']): ?>
                            <div class="form-group" data-type="<?= $key ?>">
                                <label for="<?= $key . '_input' ?>"><i class="<?= $value['input_icon'] ?> fa-fw fa-sm text-muted mr-1"></i> <?= l('documents.input.' . $key) ?></label>
                                <textarea id="<?= $key . '_input' ?>" name="<?= $key . '_input' ?>" class="form-control" rows="5" required="required"></textarea>
                            </div>
                        <?php else: ?>

                            <?php if($key == 'blog_article_section'): ?>
                                <div class="form-group" data-type="blog_article_section">
                                    <label for="blog_article_section_title"><i class="fa fa-fw fa-heading fa-sm text-muted mr-1"></i> <?= l('documents.input.blog_article_section_title') ?></label>
                                    <textarea id="blog_article_section_title" name="blog_article_section_title" class="form-control" rows="5" required="required"><?= $data->values['blog_article_section_title'] ?? null ?></textarea>
                                </div>

                                <div class="form-group" data-type="blog_article_section">
                                    <label for="blog_article_section_keywords"><i class="fa fa-fw fa-file-word fa-sm text-muted mr-1"></i> <?= l('documents.input.blog_article_section_keywords') ?></label>
                                    <textarea id="blog_article_section_keywords" name="blog_article_section_keywords" class="form-control" rows="5" required="required"><?= $data->values['blog_article_section_keywords'] ?? null ?></textarea>
                                </div>
                            <?php endif ?>

                        <?php endif ?>
                    <?php endif ?>
                <?php endforeach ?>

                <div class="form-group">
                    <label for="language"><i class="fa fa-fw fa-language fa-sm text-muted mr-1"></i> <?= l('documents.language') ?></label>
                    <select id="language" name="language" class="form-control">
                        <?php foreach(settings()->aix->documents_available_languages as $key): ?>
                            <option value="<?= $key ?>" <?= $data->values['language'] == $key ? 'selected="selected"' : null ?>><?= $key ?></option>
                        <?php endforeach ?>
                    </select>
                    <small class="form-text text-muted"><?= l('documents.language_help') ?></small>
                </div>

                <div class="form-group">
                    <label for="creativity_level"><i class="fa fa-fw fa-robot fa-sm text-muted mr-1"></i> <?= l('documents.creativity_level') ?></label>
                    <div class="row btn-group-toggle" data-toggle="buttons">
                        <?php foreach(['none', 'low', 'optimal', 'high', 'maximum', 'custom'] as $key): ?>
                            <div class="col-12 col-lg-4">
                                <label class="btn btn-light btn-block">
                                    <input type="radio" name="creativity_level" value="<?= $key ?>" class="custom-control-input" <?= $data->values['creativity_level'] == $key ? 'checked="checked"' : null ?> />
                                    <?= l('documents.creativity_level.' . $key) ?>
                                </label>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <small class="form-text text-muted"><?= l('documents.creativity_level_help') ?></small>
                </div>

                <div class="form-group" data-creativity-level="custom">
                    <label for="creativity_level_custom"><i class="fa fa-fw fa-hat-wizard fa-sm text-muted mr-1"></i> <?= l('documents.creativity_level_custom') ?></label>
                    <input type="number" id="creativity_level_custom" min="0" max="1" step="0.1" name="creativity_level_custom" class="form-control" value="<?= $data->values['creativity_level_custom'] ?? 0.5 ?>" />
                    <small class="form-text text-muted"><?= l('documents.creativity_level_custom_help') ?></small>
                </div>

                <div class="form-group">
                    <label for="variants"><i class="fa fa-fw fa-list-ol fa-sm text-muted mr-1"></i> <?= l('documents.variants') ?></label>
                    <div class="row btn-group-toggle" data-toggle="buttons">
                        <?php foreach([1,2,3] as $key): ?>
                            <div class="col-12 col-lg-4">
                                <label class="btn btn-light btn-block">
                                    <input type="radio" name="variants" value="<?= $key ?>" class="custom-control-input" <?= $data->values['variants'] == $key ? 'checked="checked"' : null ?> />
                                    <?= sprintf(l('documents.x_variants'), $key) ?>
                                </label>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <small class="form-text text-muted"><?= l('documents.variants_help') ?></small>
                </div>

                <div class="form-group">
                    <label for="max_words_per_variant"><i class="fa fa-fw fa-keyboard fa-sm text-muted mr-1"></i> <?= l('documents.max_words_per_variant') ?></label>
                    <div class="input-group">
                        <input type="number" min="1" <?= $this->user->plan_settings->words_per_month_limit == -1 ? null : 'max="' . $data->available_words . '"' ?> id="max_words_per_variant" name="max_words_per_variant" class="form-control" value="<?= $data->values['max_words_per_variant'] ?>" />
                        <div class="input-group-append">
                            <span class="input-group-text"><?= sprintf(l('documents.x_words_available'), ($this->user->plan_settings->words_per_month_limit == -1 ? l('global.unlimited') : $data->available_words)) ?></span>
                        </div>
                    </div>
                    <small class="form-text text-muted"><?= l('documents.max_words_per_variant_help') ?></small>
                </div>

                <div class="form-group">
                    <div class="d-flex flex-column flex-xl-row justify-content-between">
                        <label for="project_id"><i class="fa fa-fw fa-sm fa-project-diagram text-muted mr-1"></i> <?= l('projects.project_id') ?></label>
                        <a href="<?= url('project-create') ?>" target="_blank" class="small mb-2"><i class="fa fa-fw fa-sm fa-plus mr-1"></i> <?= l('projects.create') ?></a>
                    </div>
                    <select id="project_id" name="project_id" class="form-control">
                        <option value=""><?= l('global.none') ?></option>
                        <?php foreach($data->projects as $project_id => $project): ?>
                            <option value="<?= $project_id ?>" <?= $data->values['project_id'] == $project_id ? 'selected="selected"' : null ?>><?= $project->name ?></option>
                        <?php endforeach ?>
                    </select>
                    <small class="form-text text-muted"><?= l('projects.project_id_help') ?></small>
                </div>

                <button type="submit" name="submit" class="btn btn-block btn-primary" data-is-ajax><?= l('global.create') ?></button>
            </form>

        </div>
    </div>
</div>

<?php ob_start() ?>
<script>
    /* Form submission */
    document.querySelector('#document_create').addEventListener('submit', async event => {
        event.preventDefault();

        pause_submit_button(document.querySelector('#document_create').querySelector('[type="submit"][name="submit"]'));

        /* Notification container */
        let notification_container = event.currentTarget.querySelector('.notification-container');
        notification_container.innerHTML = '';

        /* Prepare form data */
        let form = new FormData(document.querySelector('#document_create'));

        /* Send request to server */
        let response = await fetch(`${url}document-create/create_ajax`, {
            method: 'post',
            body: form
        });

        let data = null;
        try {
            data = await response.json();
        } catch (error) { /* :) */ }

        if(!response.ok) {
            enable_submit_button(document.querySelector('#document_create').querySelector('[type="submit"][name="submit"]'));
            display_notifications(<?= json_encode(l('global.error_message.basic')) ?>, 'error', notification_container);
            notification_container.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        if (data.status == 'error') {
            enable_submit_button(document.querySelector('#document_create').querySelector('[type="submit"][name="submit"]'));
            display_notifications(data.message, 'error', notification_container);
            notification_container.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else if (data.status == 'success') {
            /* Redirect */
            redirect(data.details.url, true);
        }
    });
</script>

<script>
    'use strict';

    /* Type handler */
    let type_handler = (selector, data_key) => {
        if(!document.querySelector(selector)) {
            return;
        }

        let type = null;
        if(document.querySelector(selector).type == 'radio') {
            type = document.querySelector(`${selector}:checked`) ? document.querySelector(`${selector}:checked`).value : null;
        } else {
            type = document.querySelector(selector).value;
        }

        document.querySelectorAll(`[${data_key}]:not([${data_key}="${type}"])`).forEach(element => {
            element.classList.add('d-none');
            let input = element.querySelector('input,select,textarea');

            if(input) {
                if(input.getAttribute('required')) {
                    input.setAttribute('data-is-required', 'true');
                }
                // if(input.getAttribute('disabled')) {
                //     input.setAttribute('data-is-disabled', 'true');
                // }
                input.setAttribute('disabled', 'disabled');
                input.removeAttribute('required');
            }
        });

        document.querySelectorAll(`[${data_key}="${type}"]`).forEach(element => {
            element.classList.remove('d-none');
            let input = element.querySelector('input,select,textarea');

            if(input) {
                input.removeAttribute('disabled');
                if(input.getAttribute('data-is-required')) {
                    input.setAttribute('required', 'required')
                }
                // if(input.getAttribute('data-is-disabled')) {
                //     input.setAttribute('disabled', 'required')
                // }
            }
        });
    }

    type_handler('[name="type"]', 'data-type');
    document.querySelector('[name="type"]') && document.querySelectorAll('[name="type"]').forEach(element => element.addEventListener('change', () => { type_handler('[name="type"]', 'data-type'); }));

    type_handler('[name="creativity_level"]', 'data-creativity-level');
    document.querySelector('[name="creativity_level"]') && document.querySelectorAll('[name="creativity_level"]').forEach(element => element.addEventListener('change', () => { type_handler('[name="creativity_level"]', 'data-creativity-level'); }));

</script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>

