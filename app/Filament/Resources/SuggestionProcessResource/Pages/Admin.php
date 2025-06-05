<?php

namespace App\Filament\Resources\SuggestionProcessResource\Pages;

use App\Models\Review;
use App\Services\UserStatistics;
use Closure;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class Admin
{

    public static function getActionFormattedState($id)
    {
        return collect(self::getSelectedReview($id, 'MA'))
            ->filter(fn($review) => $review->referral !== null)
            ->map(fn($review) => "<p>ارجاع به: " . implode(' , ', json_decode($review->referral)) . "</p><p>{$review->actions}</p>")
            ->implode('');
    }


    public static function getCommentsFormattedState($id)
    {
        $reviews = self::getSelectedReview($id);
        $result = [];

        foreach ($reviews as $review) {
            $result[] = "<p><b>{$review->department}:</b></p><p> {$review->comments} </p>";
        }

        return implode('', $result);
    }

    public static function getSelectedReview($id, $department = null)
    {
        $reviews = Review::where('suggestion_id', $id);

        if ($department) {
            $reviews->where('department', $department);
        }
        return $reviews->get();
    }

    public static function getVotesFormattedState($id)
    {
        $reviews = self::getSelectedReview($id);
        $result = [];

        $view = [
            'agree' => 'موافق',
            'disagree' => 'موافق',
            'neutral' => 'نیمه موافق',
            'incomplete' => 'نیازمند تکمیل'
        ];

        foreach ($reviews as $review) {
            $result[] = "{$review->department} ({$view[$review->feedback]})";
        }

        return implode(' -- ', $result);
    }

    public static function showAbort(): IconColumn
    {
        return IconColumn::make('abort')
            ->options(['heroicon-o-x-circle' => 'no', 'heroicon-o-check-circle' => 'yes'])
            ->colors(['danger' => 'no', 'success' => 'yes'])
            ->toggleable()
            ->sortable()
            ->searchable();
    }


    public static function showAttachment(): ImageColumn
    {
        return ImageColumn::make('attachment')
            ->disk('filament')
            ->extraImgAttributes(function (Model $record) {
                if ($record->attachment) {
                    return [
                        'oncontextmenu' => "window.open('{$record->attachment}', '_blank')",
                        'title' => ' Right-click to view',
                        'style' => 'background: #f0f0f0 url(' . asset('img/user/filePlaceholder.png') . ') center center no-repeat; background-size: cover;',
                    ];
                }
                return [];
            })
            ->size(50)
//            ->defaultImageUrl(url('img/user/filePlaceholder.png'))
            ->toggleable();
    }


    public static function showDescription(): TextColumn
    {
        return TextColumn::make('description')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => substr($record->description, 0, 40))
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->description)));
    }


    public static function showSelfFill(): IconColumn
    {
        return IconColumn::make('self_fill')
            ->options(['heroicon-o-x-circle' => 0, 'heroicon-o-check-circle' => 1])
            ->colors(['danger' => 0, 'success' => 1])
            ->label('Self-filled')
            ->toggleable()
            ->sortable()
            ->searchable();
    }


    public static function showStage(): BadgeColumn
    {
        return BadgeColumn::make('stage')
            ->enum(self::showStageMessage())
            ->toggleable()
            ->sortable()
            ->searchable()
            ->tooltip(fn(Model $record): string => "last updated: {$record->updated_at}");
    }


    public static function showStageMessage(): array
    {
        return [
            'pending' => '🕒 Pending',
            'team_remarks' => '💬 Awaiting feedback',
            'dept_remarks' => '📝  Awaiting response',
            'awaiting_decision' => '🤔 Awaiting decision',
            'accepted' => '😊 Accepted',
            'rejected' => '😔 Rejected',
            'under_review' => '🔍 Awaiting review',
            'closed' => '🔒 Closed',
        ];
    }

    public static function showSuggester(): BadgeColumn
    {
        return BadgeColumn::make('user.full_name')
            ->color('primary')
            ->toggleable()
            ->sortable(['forename'])
            ->searchable(['forename', 'surname'])
            ->tooltip(fn(Model $record): string => "created {$record->created_at} in {$record->user->profile->department}")
            ->label('Suggester');
    }


    public static function showTitle(): TextColumn
    {
        return TextColumn::make('title')
            ->searchable()
            ->size('sm')
            ->html()
            ->toggleable()
            ->getStateUsing(fn(Model $record) => $record->title)
            ->tooltip(fn(Model $record): string => strip_tags(html_entity_decode($record->title)));
    }


    public static function viewAction(): MarkdownEditor
    {
        return MarkdownEditor::make('Action')
            ->disableAllToolbarButtons()
            ->formatStateUsing(fn(Closure $get) => self::getActionFormattedState($get('id')))
            ->extraAttributes(['style' => 'direction:rtl']);
    }


    public static function viewComments(): MarkdownEditor
    {
        return MarkdownEditor::make('Comments')
            ->disableAllToolbarButtons()
            ->formatStateUsing(fn(Closure $get) => self::getCommentsFormattedState($get('id')))
            ->extraAttributes(['style' => 'direction:rtl']);
    }

    public static function viewDescription(): MarkdownEditor
    {
        return MarkdownEditor::make('description')->disableAllToolbarButtons()->extraAttributes(['style' => 'direction:rtl']);
    }


    public static function viewPurpose(): TagsInput
    {
        return TagsInput::make('purpose');
    }


    public static function viewRules(): TagsInput
    {
        return TagsInput::make('rule');
    }

    public static function viewBeneficiaries(): TextInput
    {
        return TextInput::make('department')
            ->label('Beneficiaries')
            ->formatStateUsing(function (Closure $get): string {
                $department = $get('department');

                if (is_null($department)) {
                    return '-';
                }

                $departmentArray = json_decode($department, true);

                if (!is_array($departmentArray)) {
                    return $department;
                }

                $namesArray = UserStatistics::$departmentPersianNames;

                $departmentNames = [];
                foreach ($departmentArray as $deptCode) {
                    $departmentNames[] = $namesArray[$deptCode] ?? $deptCode;
                }

                return implode(', ', $departmentNames);
            })
            ->disabled();
    }


    public static function viewSuggester(): Select
    {
        return Select::make('user_id')
            ->label('Suggester')
            ->relationship('user', 'forename')
            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->forename} {$record->surname}");
    }


    public static function viewTitle(): TextInput
    {
        return TextInput::make('title')->extraAttributes(['style' => 'direction:rtl']);
    }


    public static function viewVotes(): TextInput
    {
        return TextInput::make('Votes')
            ->formatStateUsing(fn(Closure $get) => self::getVotesFormattedState($get('id')))
            ->extraAttributes(['style' => 'direction:rtl']);
    }
}
