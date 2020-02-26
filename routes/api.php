<?php

Route::group(['prefix' => 'api'], function () {
    Route::resource('letters.prints', 'LetterPrintController', ['except' => ['show', 'create', 'edit']]);
    Route::resource('letters.transcriptions', 'Letters\\TranscriptionController',
        ['except' => ['show', 'create', 'edit']]);
    Route::resource('letters.attachments', 'Letters\\AttachmentController', ['except' => ['show', 'create', 'edit']]);
    Route::resource('letters.facsimiles', 'LetterFacsimileController', ['except' => ['show', 'create', 'edit']]);
    Route::resource('letters.drafts', 'LetterDraftController', ['except' => ['show', 'create', 'edit']]);
    Route::resource('letters.auction-catalogues', 'Letters\\AuctionCataloguesController', ['except' => ['show', 'create', 'edit']]);
    Route::resource('letters.information', 'LetterInformationController', ['except' => ['show', 'create', 'edit']]);
    Route::resource('letters.codes', 'LetterCodeController', ['except' => ['show', 'create', 'edit']]);

    Route::resource('letters.apparatuses', 'Letters\\ApparatusesController', ['only' => ['index', 'update', 'delete']]);
    Route::resource('letters.comments', 'Letters\\CommentsController', ['only' => ['index', 'update', 'delete']]);

    Route::resource('letters.letter-text', 'Letters\\TextController', ['only' => ['index', 'update', 'delete']]);

    Route::resource('people.prints', 'PersonPrintController', ['except' => ['edit']]);
    Route::resource('people.inheritances', 'PersonInheritanceController', ['except' => ['edit']]);
    Route::resource('people.references', 'PersonReferenceController', ['except' => ['edit']]);

    Route::post('admin/publish/trigger',
        ['as' => 'admin.deployment.trigger', 'uses' => 'DeploymentController@triggerDeployment']);
    Route::get('admin/publish/status', ['as' => 'admin.deployment.status', 'uses' => 'DeploymentController@status']);
    Route::post('admin/publish/blankify',
        ['as' => 'admin.deployment.blankify', 'uses' => 'DeploymentController@blankify']);
});
