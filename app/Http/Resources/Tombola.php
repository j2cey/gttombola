<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Tombola
 * @package App\Http\Resources
 *
 * @property int $id
 * @property string $uuid
 * @property string $titre
 * @property string $fichier_reglement
 * @property bool $participation_unique
 * @property string $participation_unite
 * @property integer $participation_valeurunitaire
 */
class Tombola extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'participation_unique' => $this->participation_unique,
            'participation_unite' => $this->participation_unite,
            'participation_valeurunitaire' => $this->participation_valeurunitaire,
            'fichierreglement_url' => '/uploads/tombolas/reglements/' . $this->fichier_reglement,
            'edit_url' => route('tombolas.show', $this->uuid),
            'destroy_url' => route('tombolas.destroy', $this->id),
        ];
    }
}
