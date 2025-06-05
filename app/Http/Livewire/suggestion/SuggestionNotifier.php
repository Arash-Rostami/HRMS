<?php

namespace App\Http\Livewire\suggestion;

use App\Models\Profile;
use App\Models\Review;
use App\Models\Suggestion;
use App\Models\User;
use App\Notifications\NotifySuggester;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SuggestionNotifier
{

    public static function constructMessage($person, $suggestion, $suggester)
    {
        return [
            'suggester' => [
                'subject' => "New Suggestion Submission",
                'greeting' => "Hi {$suggester}",
                'openingLine' => "Your suggestion titled  \"{$suggestion['title']}\" has been submitted successfully.",
                'closingLine' => "Thank you for your valuable input, which is crucial in enhancing our services and ensuring we meet your expectations."
            ],
            'referent' => [
                'subject' => "New Suggestion Requiring Your Attention",
                'greeting' => "Greetings,",
                'openingLine' => "A new suggestion titled \"{$suggestion['title']}\" has been submitted that requires your attention.",
                'closingLine' => "Your review and feedback on this matter would be greatly appreciated."
            ],
            'ceo' => [
                'subject' => "Managerial Insight Requested for a New Suggestion",
                'greeting' => "To the Respected Board of Directors,",
                'openingLine' => "A new suggestion has been submitted and is awaiting your esteemed review.",
                'closingLine' => "Your insights and decisions on this matter will contribute significantly to the ongoing improvement of our services."
            ],
            'selfFill' => [
                'subject' => "New Suggestion Ready for Your View",
                'greeting' => "Greetings,",
                'openingLine' => "A new suggestion has been submitted, and your perspective has also been provided.",
                'closingLine' => "Thank you for your cooperation."
            ],
            'team' => [
                'subject' => "New Suggestion Submitted in Your Department",
                'greeting' => "Greetings Team,",
                'openingLine' => "A new suggestion titled  \"{$suggestion['title']}\" has been submitted in your team.",
                'closingLine' => "Thank you for your consideration."
            ],
            'abortion' => [
                'subject' => "Abortion Alert: Suggestion Withdrawn",
                'greeting' => "**Attention:",
                'openingLine' => "The submitted suggestion titled \"{$suggestion['title']}\" has been withdrawn.",
                'closingLine' => "Your understanding is appreciated."
            ],
            'decision' => [
                'subject' => "Suggestion Decision Made",
                'greeting' => "Dear {$suggestion['suggester']},",
                'openingLine' => "Your submitted suggestion \"{$suggestion['title']}\" has been reviewed and a decision has been made. Please log in to your profile to view the decision and any further details.",
                'closingLine' => "Thank you for your feedback and contribution to our improvement process."
            ],
            'action' => [
                'subject' => "Suggestion Decision: Implementation Required",
                'greeting' => "To the Esteemed Implementors of Suggestion,",
                'openingLine' => "Your department has been assigned the task of implementing the suggestion titled \"{$suggestion['title']}\", which has been deemed feasible for implementation.",
                'closingLine' => "Please review the suggestion carefully and provide a detailed plan for implementation. We appreciate your prompt attention to this matter.",
            ]
        ][$person];
    }

    public static function getCEOEmails($inputs)
    {
        $CEOEmails = Profile::where('department', 'MA')
            ->join('users', 'profiles.user_id', '=', 'users.id')
            ->where('users.status', 'active')
            ->where('position', 'manager')
            ->get()
            ->pluck('user.email');

        return $CEOEmails->all();
    }


//    public static function getManagerEmails($inputs)
//    {
//        // Eager load supervisors with their user emails
//        $supervisorProfiles = Profile::whereIn('department', json_decode($inputs['department']))
//            ->join('users', 'profiles.user_id', '=', 'users.id')
//            ->where('users.status', 'active')
//            ->where('position', 'supervisor')
//            ->get();
//
//        // Eager load managers with their user emails
//        $managerProfiles = Profile::whereIn('department', json_decode($inputs['department']))
//            ->join('users', 'profiles.user_id', '=', 'users.id')
//            ->where('users.status', 'active')
//            ->where('position', 'manager')
//            ->get();
//
//
//        // Merge supervisor and manager emails for each department
//        $emails = collect(json_decode($inputs['department']))
//            ->flatMap(function ($department) use ($supervisorProfiles, $managerProfiles) {
//                $supervisorEmails = $supervisorProfiles
//                    ->where('department', $department)
//                    ->pluck('user.email');
//
//                $managerEmails = $managerProfiles
//                    ->where('department', $department)
//                    ->pluck('user.email');
//
//                return $managerEmails->isNotEmpty() ? $managerEmails : $supervisorEmails;
//            });
//
//        return $emails->all();
//
//    }

    public static function getManagerEmails($inputs)
    {
        $departments = json_decode($inputs['department']);

        // Fetch all active managers and supervisors in the given departments
        $profiles = Profile::whereIn('department', $departments)
            ->join('users', 'profiles.user_id', '=', 'users.id')
            ->where('users.status', 'active')
            ->whereIn('position', ['manager', 'supervisor'])
            ->select('profiles.department', 'profiles.position', 'users.email')
            ->get();

        $emails = [];

        foreach ($departments as $department) {
            $deptProfiles = $profiles->where('department', $department);
            $managerEmails = $deptProfiles->where('position', 'manager')->pluck('email');
            if ($managerEmails->isNotEmpty()) {
                $emails = array_merge($emails, $managerEmails->toArray());
            } else {
                // If no managers, get supervisor emails
                $supervisorEmails = $deptProfiles->where('position', 'supervisor')->pluck('email');
                $emails = array_merge($emails, $supervisorEmails->toArray());
            }
        }
        return array_unique($emails);
    }


    public static function getUsersTeamEmails($inputs)
    {
        $teamProfiles = Profile::where('department', $inputs['ownDep'])
            ->join('users', 'profiles.user_id', '=', 'users.id')
            ->where('users.status', 'active')
            ->get(['users.email', 'position']);

        $finalEmails = [];

        $managerPresent = $teamProfiles->contains('position', 'manager');

        foreach ($teamProfiles as $teamProfile) {
            // Exclude manager
            if ($managerPresent && $teamProfile->position == 'manager') {
                continue;
            }
            // Exclude supervisor if no manager
            if (!$managerPresent && $teamProfile->position == 'supervisor') {
                continue;
            }
            // Include other positions
            $finalEmails[] = $teamProfile->email;
        }

        return $finalEmails;
    }

    public static function sendNotification($inputs)
    {
        try {
            $user = [auth()->user()->email];

            self::sendUserNotification($user, $inputs);
            self::sendUsersTeamNotification(self::getUsersTeamEmails($inputs), $inputs);
            self::sendManagerNotification(self::getManagerEmails($inputs), $inputs);

//            self::sendUserNotification($user, $inputs);
//            self::sendUsersTeamNotification($user, $inputs);
//            self::sendManagerNotification($user, $inputs);

            if ($inputs['self_fill']) {
//                self::sendCEONotification($user, $inputs);
                self::sendCEONotification(self::getCEOEmails($inputs), $inputs);
            }

            // Trigger modal
            showFlash("success", "Your suggestion was successfully sent.");
            return true;
        } catch (\Exception $e) {
            showFlash("error", "Your suggestion could NOT be sent!");
            return false;
        }
    }

    private static function sendCEONotification($CEOEmails, $inputs)
    {
        $notification = new NotifySuggester('ceo', $inputs);

        Notification::route('mail', $CEOEmails)->notify($notification);
    }

    private static function sendManagerNotification($managerEmails, $inputs)
    {
        if (!empty($managerEmails)) {
            $notification = new NotifySuggester(($inputs['self_fill'] ? 'selfFill' : 'referent'), $inputs);

            Notification::route('mail', $managerEmails)->notify($notification);
        }
    }

    private static function sendUserNotification($user, $inputs)
    {
        $notification = new NotifySuggester('suggester', $inputs);

        Notification::route('mail', $user)->notify($notification);
    }

    private static function sendUsersTeamNotification($users, $inputs)
    {
        $notification = new NotifySuggester('team', $inputs);

        Notification::route('mail', $users)->notify($notification);
    }

    public static function sendUpdateStageNotification(mixed $newStage, mixed $currentStage, $suggestion, mixed $referral): void
    {
//        $user = User::where('email', 'arashrostami@time-gr.com')->get();

        if ($newStage === 'awaiting_decision' && $currentStage !== 'awaiting_decision') {
//            Notification::send($user, new NotifySuggester('ceo', $suggestion));
            Notification::route('mail', self::getCEOEmails($suggestion))->notify(new NotifySuggester('ceo', $suggestion));
            self::OpenModuleProgrammatically();
        }

        if (in_array($newStage, ['accepted', 'rejected', 'under_review']) && $currentStage !== $newStage) {
            $suggester = $suggestion['main']->user;
            Notification::send($suggester, new NotifySuggester('decision', $suggestion));
        }

        if (($newStage === 'accepted') && ($currentStage !== 'accepted') && ($referral !== null)) {
//            Notification::send($user, new NotifySuggester('action', $suggestion));
            Notification::route('mail', self::getManagerEmails($suggestion))->notify(new NotifySuggester('action', $suggestion));
        }
    }

    /**
     * @return void
     */
    protected static function OpenModuleProgrammatically(): void
    {
        $users = User::where('forename', 'Pedram')
            ->where('surname', 'Soltani')
            ->whereHas('profile', function ($query) {
                $query->where('department', 'MA');
            })
            ->get(['id']);

        foreach ($users as $user) {
            $cacheKey = 'profile_initiate_suggestion_' . $user->id;
            Cache::put($cacheKey, true, now()->addDays(3));
            Log::info('module opened programmatically with ' .$cacheKey);
        }
    }
}
