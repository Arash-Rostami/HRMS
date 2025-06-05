<?php

namespace App\Http\Livewire\suggestion;

class SuggestionValidation
{

    public static function rules(): array
    {
        return [
            'suggestion.title' => 'required|string|min:2',
            'suggestion.description.self' => 'required|string|min:6',
            'suggestion.purpose' => 'required', 'suggestion.rule' => 'required',
            'suggestion.description.*' => 'required_if:suggestion.selfFill,true',
            'suggestion.feedback.*' => 'required_if:suggestion.selfFill,true',
            'suggestion.attachment' => 'max:2500'
        ];
    }

    public static function messages(): array
    {
        return [
            'suggestion.title.required' => '* فیلد عنوان الزامی است.',
            'suggestion.title.string' => '* فیلد عنوان باید به صورت متنی باشد.',
            'suggestion.title.min' => '* فیلد عنوان باید حداقل 2 کاراکتر داشته باشد.',
            'suggestion.description.self.required' => '* فیلد شرح پیشنهاد و استدلال باید پر شود.',
            'suggestion.description.self.string' => '* فیلد شرح پیشنهاد و استدلال باید به صورت متنی باشد.',
            'suggestion.description.self.min' => '* فیلد  شرح پیشنهاد و استدلال باید حداقل 6 کاراکتر داشته باشد.',
            'suggestion.purpose.required' => '* حداقل یکی از موارد انتخاب شود.',
            'suggestion.rule.required' => '* حداقل یکی از قواعد انتخاب شود.',
            'suggestion.attachment.mimes' => '* فرمت مجاز PDF و JPG می باشد.',
            'suggestion.attachment.max' => '* سایز فایل بیش از حد مجاز است.',
            'suggestion.description.*.required_if' => '* فیلد بازخورد می بایست پر شود.',
            'suggestion.feedback.*.required_if' => '* یکی از موارد می بایست گزیتش شود.',
            'suggestion.feedback.ceo' => '* حداقل یکی از موارد انتخاب شود.',
            'suggestion.departments-ceo.required_if' => '* حداقل نظر برای پیگیری به یکی از واحد ها ارسال شود.',
            'suggestion.description.nonceo.required' => '* فیلد بازخورد می بایست پر شود.'

        ];
    }

    public static function validateAttachment(&$validator)
    {
        $validator->validate([
            'suggestion.attachment' => 'mimes:jpg,png,pdf|max:2000', // 2MB Max
        ]);
    }

    public static function validateResponse(&$validator, $suggestion)
    {
        if (!$suggestion['response']) {
            return false;
        }

        return $validator->validate(isManager() ? self::getManagerRules() : self::getDepartmentManagerRules());
    }

    private static function getDepartmentManagerRules()
    {
        return [
            'suggestion.description.nonceo' => 'required',
        ];
    }

    private static function getManagerRules()
    {
        return [
            'suggestion.feedback.ceo' => 'required',
            'suggestion.description.ceo-departments' => 'required_if:suggestion.feedback.ceo,agree',
        ];
    }
}
