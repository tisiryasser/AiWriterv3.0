<?php defined('ALTUMCODE') || die() ?>

<div class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <nav aria-label="breadcrumb">
        <ol class="custom-breadcrumbs small">
            <li>
                <a href="<?= url('documents') ?>"><?= l('documents.breadcrumb') ?></a><i class="fa fa-fw fa-angle-right"></i>
            </li>
            <li class="active" aria-current="page"><?= l('document_update.breadcrumb') ?></li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 text-truncate mb-0"><?= sprintf(l('document_update.header'), $data->document->name) ?></h1>

        <div class="d-flex align-items-center col-auto p-0">
            <?= include_view(\Altum\Plugin::get('aix')->path . 'views/documents/document_dropdown_button.php', ['id' => $data->document->document_id, 'resource_name' => $data->document->name]) ?>
        </div>
    </div>


    <div class="card">
        <div class="card-body">

            <form action="" method="post" role="form">
                <input type="hidden" name="token" value="<?= \Altum\Csrf::get() ?>" />

                <div class="form-group">
                    <label for="name"><i class="fa fa-fw fa-signature fa-sm text-muted mr-1"></i> <?= l('global.name') ?></label>
                    <input type="text" id="name" name="name" class="form-control" value="<?= $data->document->name ?>" required="required" />
                </div>

                <div class="form-group">
                    <label for="type"><i class="fa fa-fw fa-fingerprint fa-sm text-muted mr-1"></i> <?= l('documents.type') ?></label>
                    <input type="text" id="type" name="type" class="form-control" value="<?= l('documents.type.' . $data->document->type) ?>" readonly="readonly" />
                </div>

                <?php foreach($data->ai_types as $key => $value): ?>
                    <?php if($data->document->type != $key) continue; ?>

                    <?php if($value['single_input']): ?>
                        <div class="form-group">
                            <label for="<?= $key . '_input' ?>"><i class="<?= $value['input_icon'] ?> fa-fw fa-sm text-muted mr-1"></i> <?= l('documents.input.' . $key) ?></label>
                            <textarea id="<?= $key . '_input' ?>" name="<?= $key . '_input' ?>" class="form-control" rows="5" readonly="readonly"><?= $data->document->input ?></textarea>
                        </div>
                    <?php else: ?>

                        <?php if($key == 'blog_article_section'): ?>
                            <?php $data->document->input = json_decode($data->document->input); ?>
                            <div class="form-group">
                                <label for="blog_article_section_title"><i class="fa fa-fw fa-heading fa-sm text-muted mr-1"></i> <?= l('documents.input.blog_article_section_title') ?></label>
                                <textarea id="blog_article_section_title" name="blog_article_section_title" class="form-control" readonly="readonly"><?= $data->document->input->title ?? null ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="blog_article_section_keywords"><i class="fa fa-fw fa-file-word fa-sm text-muted mr-1"></i> <?= l('documents.input.blog_article_section_keywords') ?></label>
                                <textarea id="blog_article_section_keywords" name="blog_article_section_keywords" class="form-control" readonly="readonly"><?= $data->document->input->keywords ?? null ?></textarea>
                            </div>
                        <?php endif ?>

                    <?php endif ?>
                <?php endforeach ?>

                <div class="form-group">
                    <label for="content"><i class="fa fa-fw fa-pen fa-sm text-muted mr-1"></i> <?= l('documents.content') ?></label>
                    <textarea id="content" name="content" class="form-control" rows="10"><?= $data->document->content ?></textarea>
                </div>

                <div class="form-group">
                    <button
                            type="button"
                            class="btn btn-block btn-outline-primary"
                            data-toggle="tooltip"
                            title="<?= l('global.clipboard_copy') ?>"
                            aria-label="<?= l('global.clipboard_copy') ?>"
                            data-copy="<?= l('global.clipboard_copy') ?>"
                            data-copied="<?= l('global.clipboard_copied') ?>"
                            data-clipboard-target="#content"
                            data-clipboard-text
                    >
                        <i class="fa fa-fw fa-sm fa-copy"></i> <?= l('global.clipboard_copy') ?>
                    </button>
                </div>

                <div class="form-group">
                    <label for="language"><i class="fa fa-fw fa-language fa-sm text-muted mr-1"></i> <?= l('documents.language') ?></label>
                    <input type="text" id="language" name="language" class="form-control" value="<?= $data->document->settings->language ?>" />
                    <small class="form-text text-muted"><?= l('documents.language_help') ?></small>
                </div>

                <div class="form-group">
                    <label for="words"><i class="fa fa-fw fa-feather fa-sm text-muted mr-1"></i> <?= l('documents.words') ?></label>
                    <input type="text" id="words" name="words" class="form-control" value="<?= $data->document->words ?>" readonly="readonly" />
                </div>

                <div class="form-group">
                    <label for="creativity_level"><i class="fa fa-fw fa-robot fa-sm text-muted mr-1"></i> <?= l('documents.creativity_level') ?></label>
                    <input type="text" id="creativity_level" name="creativity_level" class="form-control" value="<?= l('documents.creativity_level.' . $data->document->settings->creativity_level) ?>" readonly="readonly" />
                </div>

                <div class="form-group">
                    <label for="variants"><i class="fa fa-fw fa-list-ol fa-sm text-muted mr-1"></i> <?= l('documents.variants') ?></label>
                    <input type="text" id="variants" name="variants" class="form-control" value="<?= $data->document->settings->variants ?>" readonly="readonly" />
                </div>

                <div class="form-group">
                    <label for="max_words_per_variant"><i class="fa fa-fw fa-keyboard fa-sm text-muted mr-1"></i> <?= l('documents.max_words_per_variant') ?></label>
                    <input type="text" id="max_words_per_variant" name="max_words_per_variant" class="form-control" value="<?= $data->document->settings->max_words_per_variant ?? l('global.unlimited') ?>" readonly="readonly" />
                </div>

                <div class="form-group">
                    <div class="d-flex flex-column flex-xl-row justify-content-between">
                        <label for="project_id"><i class="fa fa-fw fa-sm fa-project-diagram text-muted mr-1"></i> <?= l('projects.project_id') ?></label>
                        <a href="<?= url('project-create') ?>" target="_blank" class="small mb-2"><i class="fa fa-fw fa-sm fa-plus mr-1"></i> <?= l('projects.create') ?></a>
                    </div>
                    <select id="project_id" name="project_id" class="form-control">
                        <option value=""><?= l('global.none') ?></option>
                        <?php foreach($data->projects as $project_id => $project): ?>
                            <option value="<?= $project_id ?>" <?= $data->document->project_id == $project_id ? 'selected="selected"' : null ?>><?= $project->name ?></option>
                        <?php endforeach ?>
                    </select>
                    <small class="form-text text-muted"><?= l('projects.project_id_help') ?></small>
                </div>

                <button type="submit" name="submit" class="btn btn-block btn-primary"><?= l('global.update') ?></button>
            </form>

        </div>
    </div>
</div>

<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/partials/universal_delete_modal_form.php', [
    'name' => 'document',
    'resource_id' => 'document_id',
    'has_dynamic_resource_name' => true,
    'path' => 'documents/delete'
]), 'modals'); ?>

<?php include_view(THEME_PATH . 'views/partials/clipboard_js.php') ?>

<?php include_view(THEME_PATH . 'views/partials/color_picker_js.php') ?>
