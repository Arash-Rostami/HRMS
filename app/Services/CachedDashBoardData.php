<?php

namespace App\Services;

use App\Models\{Delegation, FAQ, Job, Link, Post, Question, Report, User};
use Illuminate\Support\Facades\Cache;

class CachedDashBoardData
{
    public static function getDelegations()
    {
        $cacheKey = 'delegations';

        return Cache::remember($cacheKey, 7200, function () {
            return Delegation::all();
        });
    }


    public static function getFAQS()
    {
        $cacheKey = 'faqs';

        return Cache::remember($cacheKey, 7200, function () {
            return FAQ::all();
        });
    }

    public static function getJobs()
    {
        $cacheKey = 'jobs';

        return Cache::remember($cacheKey, 7200, function () {
            return Job::where('active', 1)->get();
        });
    }

    public static function getLinks()
    {
        $cacheKey = 'links';

        return Cache::remember($cacheKey, 7200, function () {
            return Link::all()->sortBy('sequence');
        });
    }

    public static function getPosts($page)
    {
        $cacheKey = 'posts_' . $page;

        return Cache::remember($cacheKey, 7200, function () use ($page) {
            return Post::where('pinned', '<>', 1)->orderByDesc('created_at')->simplePaginate(2, ['*'], 'page', $page);
        });
    }

    public static function getPins()
    {
        return Post::where('pinned', 1)->latest()->take(1)->get();
    }

    public static function getQuestionNumber()
    {
        return data_get(Question::getUnansweredQuestions(), 'questionCount', 0);
    }

    public static function getReports($page)
    {
        $cacheKey = 'reports_' . $page;

        return Cache::remember($cacheKey, 7200, function () use ($page) {
            return Report::where('active', 1)->latest()->simplePaginate(4, ['*'], 'page', $page);
        });
    }

    public static function getUsers()
    {
        return User::with('profile')->with('desks')->where('status', 'active')
            ->orderBy('forename')->orderBy('surname')
            ->get(['id', 'forename', 'surname', 'presence', 'last_seen']);
    }
}
