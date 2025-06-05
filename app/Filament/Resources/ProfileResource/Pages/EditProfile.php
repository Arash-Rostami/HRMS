<?php

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Filament\Resources\ProfileResource;
use App\Models\User;
use Carbon\Carbon;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Morilog\Jalali\Jalalian;

class EditProfile extends EditRecord
{
    protected static string $resource = ProfileResource::class;

    protected array $dateFields = ['birthdate', 'start_date', 'end_date'];

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
    protected function prepareField(mixed $field): mixed
    {
        return str_replace(['_date', 'date'], '', $field);
    }


    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        foreach ($this->dateFields as $field) {
            $fieldName = $this->prepareField($field);
            if (isset($data[$field])) {
                $persianDate = Jalalian::fromCarbon(Carbon::parse($data[$field]));
                $data["{$fieldName}Year"] = $persianDate->getYear();
                $data["{$fieldName}Month"] = $persianDate->getMonth();
                $data["{$fieldName}Day"] = $persianDate->getDay();
            }
        }
        return $data;
    }


    protected function mutateFormDataBeforeSave(array $data): array
    {
        foreach ($this->dateFields as $field) {
            $fieldName = $this->prepareField($field);
            if ($data["{$fieldName}Year"] && $data["{$fieldName}Month"] && $data["{$fieldName}Day"]) {
                $data[$field] = Jalalian::fromFormat('Y/n/j',
                    implode('/', [$data["{$fieldName}Year"], $data["{$fieldName}Month"], $data["{$fieldName}Day"]]))->toCarbon();
            }
        }

        return $this->deActivateUser($data);
    }
}
