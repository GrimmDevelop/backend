<?php

namespace App\Http\Requests;

use Grimm\Letter;
use Grimm\LetterPersonAssociation;
use Grimm\Person;
use Illuminate\Foundation\Http\FormRequest;

class StoreLettersAssociationsRequest extends FormRequest
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
     * Persists association to database
     *
     * @param Letter $letter
     */
    public function persist(Letter $letter)
    {
        $association = new LetterPersonAssociation();

        $association->letter()->associate($letter);

        if ($this->input('type', 'sender') === 'receiver') {
            $association->makePersonReceiver();
        } else {
            $association->makePersonSender();
        }

        $assignment_source = $this->input('assignment_source');

        if ($this->input('person')) {
            /** @var Person $person */
            $person = Person::query()->find($this->input('person'));

            $association->person()->associate($person);

            if ($assignment_source === null) {
                $assignment_source = $person->stdName();
            }
        }

        $association->assignment_source = $assignment_source;

        $association->save();
    }
}
