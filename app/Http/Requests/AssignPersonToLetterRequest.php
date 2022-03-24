<?php

namespace App\Http\Requests;

use Grimm\LetterPersonAssociation;
use Grimm\Person;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class AssignPersonToLetterRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('letters.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'person' => 'required|exists:persons,id',
        ];
    }

    /**
     * @param LetterPersonAssociation $association
     */
    public function persist(LetterPersonAssociation $association)
    {
        /** @var Person $person */
        $person = Person::query()->find($this->input('person'));

        $association->person()->associate($person);

        $association->save();

        $person->touch();

        if ($this->input('associate_all')) {
            try {
                \DB::beginTransaction();

                LetterPersonAssociation::query()->where('assignment_source', $association->assignment_source)
                    ->whereNull('person_id')->each(function (LetterPersonAssociation $association) use ($person) {
                        $association->person()->associate($person);
                        $association->save();
                    });

                \DB::commit();
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }
}
