<?php

namespace App\Services;

trait StepChecker
{

    public array $stepCompletionStatus = [
        1 => false,
        2 => false,
        3 => false,
    ];


    public static array $stepProperties = [
        // Step 1: Professional Information
        1 => [
            'personnelId', 'email', 'department', 'employmentType', 'employmentStatus',
            'position', 'insurance', 'workExperience', 'startYear', 'startMonth', 'startDay',
        ],
        // Step 2: Personal Information
        2 => [
            'idCardNumber', 'idBookletNumber', 'gender', 'birthYear', 'birthMonth', 'birthDay',
            'maritalStatus', 'numberOfChildren', 'degree', 'field', 'landline', 'cellphone',
            'emergencyPhone', 'emergencyRelationship', 'licensePlate', 'zipCode', 'address', 'accessibility'
        ],
        // Step 3: Other Information
        3 => [
            'interests', 'favoriteColors', 'image',
        ],
    ];


    public function checkStepCompletionStatus(): void
    {
        foreach (self::$stepProperties as $step => $properties) {
            $this->stepCompletionStatus[$step] = $this->isStepComplete($properties);
        }
    }


    private function isStepComplete(array $properties): bool
    {
        foreach ($properties as $property) {
            $value = $this->{$property};

            // The check for 'numberOfChildren' specifically allows 0 as a valid, complete value.
            if ($property === 'numberOfChildren' && $value !== null) {
                continue;
            }

            if ($value === null || $value === '') {
                return false;
            }
        }

        return true;
    }
}
