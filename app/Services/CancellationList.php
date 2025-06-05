<?php

namespace App\Services;

use Illuminate\Support\Collection;

class CancellationList
{
    public array $unfilteredNumbers;

    public array $filteredNumbers;

    public array $originalKeys;

    public array $valueDiff;

    public array $keyDiff;

    public array $users;


    /**
     * @param array $users
     */
    public function __construct(array $users)
    {
        $this->users = $users;
        $this->unfilteredNumbers = [];
        $this->filteredNumbers = [];
        $this->originalKeys = [];
    }


    /**
     * @return int[]|string[]
     */
    public function getKeyDifference(): array
    {
        return array_keys(array_diff_key($this->unfilteredNumbers, $this->filteredNumbers));
    }

    /**
     * @return void
     * this is to get the ID of the place and of those users who have reserved in place of cancellation
     */
    public function getIds()
    {
        $this->valueDiff = $this->getValueDifference();

        $this->keyDiff = $this->getKeyDifference();

        foreach ($this->valueDiff as $value) {
            $this->originalKeys[] = array_search($value, $this->filteredNumbers);
        };
    }

    /**
     * @return void
     * this is to make a list of all places which were taken for comparison purposes
     */
    public function getNumbers()
    {
        foreach ($this->users as $user) {
            $this->unfilteredNumbers[] = $user['number'];

            if (!in_array($user['number'], $this->filteredNumbers)) {
                $this->filteredNumbers[] = $user['number'];
            }
        }
    }

    /**
     * @return array
     */
    public function getValueDifference(): array
    {
        return array_values(array_diff_key($this->unfilteredNumbers, $this->filteredNumbers));
    }


    /**
     * @return Collection
     * this is to see which user has a longer period of reservation for the sake of priorities
     */
    public function showCollection(): Collection
    {
        for ($i = 0; $i < count($this->originalKeys); $i++) {

            if (intval($this->users[$this->originalKeys[$i]]['end_date']) > intval($this->users[$this->keyDiff[$i]]['end_date'])) {
                unset($this->users[$this->keyDiff[$i]]);
            } else {
                unset($this->users[$this->originalKeys[$i]]);
            }
        }
        return collect($this->users)
            ->sortBy('fullName')
            ->pluck('fullName', 'id');
    }

    /**
     * @return Collection
     * this is to operate the entire methods of class
     */
    public function listUsers(): \Illuminate\Support\Collection
    {
        $this->getNumbers();

        $this->getIds();

        return $this->showCollection();
    }
}
