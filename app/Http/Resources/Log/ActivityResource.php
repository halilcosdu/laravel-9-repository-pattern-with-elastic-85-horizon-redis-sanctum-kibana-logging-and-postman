<?php

namespace App\Http\Resources\Log;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request) + [
                'browser' => empty(agent($this->agent)->browser->toString()) ? null :
                    [
                        'family' => agent($this->agent)->browser?->getName() ?? 'Invalid',
                        'version' => agent($this->agent)->browser?->getVersion() ?? 'Invalid',
                    ],
                'os' => empty(agent($this->agent)->os?->toString()) ? null :
                    [
                        'family' => agent($this->agent)->os?->getName() ?? 'Invalid',
                        'version' => agent($this->agent)->os?->getVersion() ?? 'Invalid',
                    ],
            ];
    }
}
