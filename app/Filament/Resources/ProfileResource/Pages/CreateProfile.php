<?php

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Filament\Resources\ProfileResource;
use App\Models\User;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Morilog\Jalali\Jalalian;

class CreateProfile extends CreateRecord
{
    protected static string $resource = ProfileResource::class;

    protected array $dates = ['birthdate', 'start_date', 'end_date'];


    /**
     * @param array $data
     * @return array
     */
    public function deActivateUser(array $data): array
    {
        $isEndDateEmpty = empty($data['end_date']);
        $data['end_date'] = $isEndDateEmpty ? null : $data['end_date'];
        $data['employment_status'] = $isEndDateEmpty ? $data['employment_status'] : 'terminated';

        $user = User::find($data['user_id']);
        if ($user) {
            $user->status = $isEndDateEmpty ? 'active' : 'inactive';
            $user->save();
        }

        return $data;
    }

    /**
     * @param mixed $field
     * @return array|mixed|string|string[]
     */
    protected function prepareFieldTitle(mixed $field): mixed
    {
        return str_replace(['_date', 'date'], '', $field);
    }


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        foreach ($this->dates as $field) {
            $fieldTitle = $this->prepareFieldTitle($field);
            if ($data["{$fieldTitle}Year"] && $data["{$fieldTitle}Month"] && $data["{$fieldTitle}Day"]) {
                $data[$field] = Jalalian::fromFormat('Y/n/j',
                    implode('/', [$data["{$fieldTitle}Year"], $data["{$fieldTitle}Month"], $data["{$fieldTitle}Day"]]))->toCarbon();
            }
        }

        return $this->deActivateUser($data);
    }
}
