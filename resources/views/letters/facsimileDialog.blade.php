<div class="modal fade" id="add{{ ucfirst($type) }}" role="dialog" aria-labelledby="add{{ ucfirst($type) }}Title">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" aria-label="Schließen">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="add{{ ucfirst($type) }}Title">
                    {{ trans('letters.' . $type) }} hinzufügen
                </h4>
            </div>
            <div class="form-inline" id="create{{ ucfirst($type) }}Form"
                 data-url="{{ $baseUrl }}">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="create{{ ucfirst($type) }}Entry">Eintrag: </label>
                        <input type="text" id="create{{ ucfirst($type) }}Entry" class="form-control form-control-sm"
                               name="entry"
                               ref="createEntryField" v-model="createEntry">
                    </div>
                    <div class="form-group row">
                        <label for="year">Jahr: </label>
                        <input type="text" class="form-control form-control-sm" name="year"
                               v-model="createYear">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Schließen
                    </button>
                    <button type="button" class="btn btn-primary" @click.prevent="storeItem">Speichern</button>
                </div>
            </div>
        </div>
    </div>
</div>
