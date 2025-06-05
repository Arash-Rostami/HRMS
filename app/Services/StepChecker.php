<?php

namespace App\Services;

trait StepChecker
{
    public $stepCompletionStatus = [
        1 => false,
        2 => false,
        3 => false,
    ];

    public function checkStepCompletionStatus()
    {
        $stepInputs = [
            // Step 1 inputs
            [
                'personnelId', 'email', 'department', 'employmentType', 'employmentStatus',
                'position', 'insurance', 'workExperience', 'startYear', 'startMonth', 'startDay',
            ],
            // Step 2 inputs
            [
                'idCardNumber', 'idBookletNumber', 'gender', 'birthYear', 'birthMonth', 'birthDay',
                'maritalStatus', 'numberOfChildren', 'degree', 'field', 'landline', 'cellphone',
                'emergencyPhone', 'emergencyRelationship', 'licensePlate', 'zipCode', 'address', 'accessibility'
            ],
            // Step 3 inputs
            [
                'interests', 'favoriteColors', 'image',
            ],
        ];

        // Loop through each step and check if all inputs have information
        foreach ($stepInputs as $step => $inputs) {
            $inputValues = array_map(fn($input) => $this->$input, $inputs);
            $stepStatus = !in_array("", $inputValues, true) && !in_array(null, $inputValues, true);
            $this->stepCompletionStatus[$step + 1] = $stepStatus;
        }

    }
}
