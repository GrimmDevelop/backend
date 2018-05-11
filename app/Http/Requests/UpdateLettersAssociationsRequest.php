<?php

namespace App\Http\Requests;

use Grimm\Letter;
use Grimm\LetterPersonAssociation;
use Grimm\Person;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLettersAssociationsRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('letters.assign');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'person' => 'required_without:assignment_source|nullable|exists:persons,id',
            'assignment_source' => 'required_without:person|nullable|string',
        ];
    }

    /**
     * @param Letter $letter
     * @param LetterPersonAssociation $association
     */
    public function persist(Letter $letter, LetterPersonAssociation $association)
    {
        if ($letter->id != $association->letter_id) {
            throw new \InvalidArgumentException("Invalid models provided");
        }

        $assignment_source = $this->input('assignment_source');

        if ($this->input('person') === null && $association->person != null) {
            $association->person()->dissociate();
        }

        if ($this->input('person') !== null) {
            $this->updatePersonModel($association);
        }

        if ($assignment_source === null && $association->person !== null) {
            $assignment_source = $association->person->fullName();
        }

        $association->assignment_source = $assignment_source;

        $association->save();
    }

    /**
     * @param LetterPersonAssociation $association
     */
    private function updatePersonModel(LetterPersonAssociation $association)
    {
        /** @var Person $person */
        $person = Person::query()->find($this->input('person'));

        if ($association->person === null ||
            $association->person->id != $person->id) {
            $association->person()->associate($person);
        }
    }
}
