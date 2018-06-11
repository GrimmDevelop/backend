<?php

$this->resource('letters.prints', 'LetterPrintController', ['except' => ['show', 'create', 'edit']]);
$this->resource('letters.transcriptions', 'Letters\\TranscriptionController', ['except' => ['show', 'create', 'edit']]);
$this->resource('letters.attachments', 'Letters\\AttachmentController', ['except' => ['show', 'create', 'edit']]);
$this->resource('letters.facsimiles', 'LetterFacsimileController', ['except' => ['show', 'create', 'edit']]);
$this->resource('letters.drafts', 'LetterDraftController', ['except' => ['show', 'create', 'edit']]);
$this->resource('letters.information', 'LetterInformationController', ['except' => ['show', 'create', 'edit']]);

$this->resource('people.prints', 'PersonPrintController', ['except' => ['edit']]);
$this->resource('people.inheritances', 'PersonInheritanceController', ['except' => ['edit']]);

$this->post('admin/publish/trigger',
    ['as' => 'admin.deployment.trigger', 'uses' => 'DeploymentController@triggerDeployment']);
$this->get('admin/publish/status', ['as' => 'admin.deployment.status', 'uses' => 'DeploymentController@status']);
$this->post('admin/publish/blankify',
    ['as' => 'admin.deployment.blankify', 'uses' => 'DeploymentController@blankify']);
