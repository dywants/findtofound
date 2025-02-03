<?php

namespace App\Http\Requests;

use App\Enum\PieceCondition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class FindRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'fullName' => 'required|string',
            'findCity' => 'required|string',
            'piece_id' => 'required|exists:pieces,id',
            'photos' => 'required|array',
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'amount_check' => 'required|string',
            'checkAnnonymary' => 'required|boolean',
            'discovery_date' => 'nullable|date',
            'piece_condition' => ['nullable', new Enum(PieceCondition::class)],
            'condition_details' => 'nullable|string',
            'deposit_location' => 'nullable|string',
            'deposit_city' => 'nullable|string',
            'deposit_district' => 'nullable|string',
            'contact_person' => 'nullable|string',
            'pickup_hours' => 'nullable|string',
            'special_instructions' => 'nullable|string'
        ];

        if ($this->input('checkAnnonymary')) {
            $rules['localisation'] = 'required|string';
        } else {
            $rules['name'] = 'required|string';
            $rules['email'] = 'required|email';
            $rules['phone_number'] = 'required|string';
            $rules['city'] = 'required|string';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'fullName.required' => 'Le nom inscrit sur la pièce est une information importante',
            'findCity.required' => 'La ville où la pièce a été retrouvée est une information importante',
            'piece_id.required' => 'Le choix du type de pièce est important',
            'photos.required' => "L'image est requise",
            'localisation.required' => 'Veuillez indiquer le lieu où vous avez déposé le document',
            'name.required' => 'Votre nom est requis',
            'email.required' => 'Votre email est requis',
            'email.email' => 'Veuillez entrer une adresse email valide',
            'phone_number.required' => 'Votre numéro de téléphone nous permettra de vous contacter',
            'city.required' => 'Votre ville de résidence est requise',
            'amount_check.required' => 'La validation de la rémunération est importante',
            'piece_condition.enum' => 'La condition de la pièce doit être une des valeurs suivantes : Excellent, Bon, Moyen, ou Mauvais',
        ];
    }
}
