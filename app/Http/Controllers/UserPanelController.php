<?php

namespace App\Http\Controllers;

use App\Events\UpdateLastSeen;
use App\Events\UserLoggedIn;
use App\Models\Delegation;
use App\Models\User;
use App\Pipes\CheckOtp;
use App\Pipes\CheckUserProfileExists;
use App\Pipes\CheckUserStatus;
use App\Pipes\DispatchUserEvents;
use App\Pipes\GenerateOtp;
use App\Pipes\LoginUser;
use App\Pipes\SendOtpMessage;
use App\Services\CachedDashBoardData;
use App\Services\Theme;
use App\Services\ViewPagination;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Storage;


class UserPanelController extends Controller
{

    public function changePresence($status)
    {
        $user = auth()->user();
        $cacheKey = 'idle_' . $user->id;

        // Dispatch the UpdateLastSeen event to change the presence to onsite
        event(new UpdateLastSeen($user));

        if ($status == 'busy' && !Cache::has($cacheKey)) {
            // Cache the idle status for 8 hours (480 minutes)
            Cache::put($cacheKey, true, 28800);
            return redirect()->back()->with('success', 'Status updated successfully :)');
        }

        if ($status != 'busy' && Cache::has($cacheKey)) {
            // Clear the idle status cache if present
            Cache::forget($cacheKey);
        }

        // Update the user's presence status
        $user->presence = $status;
        $user->save();
        // Redirect or return a response as needed
        return back()->with('success', 'Status updated successfully :)');
    }


    public function fetchData($request): array
    {
        $page = $request->input('page');

        return [
            'delegations' => CachedDashBoardData::getDelegations(),
            'faqs' => CachedDashBoardData::getFAQS(),
            'jobs' => CachedDashBoardData::getJobs(),
            'links' => CachedDashBoardData::getLinks(),
            'posts' => CachedDashBoardData::getPosts($page),
            'translatePage' => $request->boolean('translatePage'),
            'pins' => CachedDashBoardData::getPins(),
            'questions' => CachedDashBoardData::getQuestionNumber(),
            'reports' => CachedDashBoardData::getReports($page),
            'themes' => Theme::getTheme() ?? ' ',
            'users' => CachedDashBoardData::getUsers(),
        ];
    }

    public function edit()
    {
        // Cache the text for a specific duration, for example, 1 month (31 days )
        Cache::put('profile_edit_user_' . auth()->user()->id, true, now()->addDays(31));

        return redirect()->route('user.panel');
    }

    public function loadMusic()
    {
        $cacheKey = 'profile_load_music_' . auth()->user()->id;

        if (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        } else {
            // Cache for one hour (60 minutes)
            Cache::put($cacheKey, true, now()->addMinutes(60));
        }
        return back();
    }


    public static function isPaginationInvoked($page)
    {
        if (isset($page)) {
            // Clear the cache for the current page of posts
            Cache::forget('posts' . $page);
            // Clear the cache for the current page of pins
            Cache::forget('pins' . $page);
            // Clear the cache for the current page of reports
            Cache::forget('reports' . $page);
        }
    }

    public function viewAnalytics()
    {
        $cacheKey = 'profile_view_analytics_' . auth()->user()->id;

        if (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        } else {
            // Cache for one hour (60 minutes)
            Cache::put($cacheKey, true, now()->addMinutes(60));
        }
        return back();
    }

    public function index(Request $request)
    {
        $data = $this->fetchData($request);

        if ($request->ajax()) {
            $view = ViewPagination::create($request->input('table'), $data);
            return $view->render();
        }

        return view('user', $data);
    }

    public function loadDMS()
    {
        $cacheKey = 'profile_initiate_dms_' . auth()->user()->id;

        if (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        } else {
            // Cache for one hour (60 minutes)
            Cache::put($cacheKey, true, now()->addMinutes(60));
        }
        return back();
    }

    public function loadTHS()
    {
        $cacheKey = 'profile_initiate_ths_' . auth()->user()->id;

        if (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        } else {
            // Cache for one hour (60 minutes)
            Cache::put($cacheKey, true, now()->addMinutes(60));
        }
        return back();
    }

    public function loadDelegation()
    {
        $cacheKey = 'profile_initiate_delegation_' . auth()->user()->id;

        if (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        } else {
            // Cache for one hour (60 minutes)
            Cache::put($cacheKey, true, now()->addMinutes(60));
        }
        return back();
    }

    public function loadOnboarding()
    {
        $cacheKey = 'profile_initiate_onboarding_' . auth()->user()->id;

        if (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        } else {
            // Cache for one hour (60 minutes)
            Cache::put($cacheKey, true, now()->addMinutes(60));
        }
        return back();
    }

    public function loadSurvey()
    {
        $cacheKey = 'profile_initiate_surveys_' . auth()->user()->id;

        if (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        } else {
            // Cache for one hour (60 minutes)
            Cache::put($cacheKey, true, now()->addMinutes(60));
        }
        return back();
    }


    public function loadSuggestion()
    {
        $cacheKey = 'profile_initiate_suggestion_' . auth()->user()->id;

        if (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        } else {
            // Cache for one hour (60 minutes)
            Cache::put($cacheKey, true, now()->addMinutes(60));
        }
        return back();
    }

    public function updatePresence($user, $isp, $presence)
    {
        $user = User::where('email', '=', $user)->firstOrFail();

        event(new UpdateLastSeen($user));

        $cacheKey = 'idle_' . $user->id;

        switch ($presence) {
            case 'on':
                Cache::forget($cacheKey); // Clear the idle status cache if present
                if (!Cache::has($cacheKey)) {
                    event(new UserLoggedIn($user, $isp));
                }
                break;

            case 'off':
                if (!Cache::has($cacheKey)) {
                    Cache::put($cacheKey, true, 28800); // Cache the idle status for 8 hours (480 minutes)
                }
                break;
            default:
                return response()->json([
                    'message' => 'Invalid presence value',
                ]);
        }

        return response()->json([
            'message' => 'User presence updated successfully',
            'user' => [
                'presence' => $user->presence,
                'last_seen' => $user->last_seen,
            ],
        ]);
    }

    public function handleOtp(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->has('phone')) {
                return $this->sendOtp($request->phone);
            }

            if ($request->has('code')) {
                return $this->verifyOtp();
            }
        }
        return view('auth.otp');
    }

    protected function sendOtp($phone)
    {
        $response = app(Pipeline::class)
            ->send($phone)
            ->through([
                CheckUserProfileExists::class,
                GenerateOtp::class,
                SendOtpMessage::class,
            ])
            ->thenReturn();

        return $response ?: redirect()->back()->with('message', 'OTP sent to your phone.')->with('phone', $phone);
    }

    protected function verifyOtp()
    {
        $userId = session('user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'No such user found!']);
        }

        $response = app(Pipeline::class)
            ->send($user)
            ->through([
                CheckOtp::class,
                CheckUserStatus::class,
                LoginUser::class,
                DispatchUserEvents::class,
            ])
            ->thenReturn();

        return $response ?: redirect()->route('user.panel');
    }
}
