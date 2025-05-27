<?php

namespace App\Http\Requests;

use App\Models\Platform;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $this->merge([
            'status' => 'scheduled',
        ]);
        
        $rules = [
            'title' => 'required|string|max:255',
            'image' => 'image',
            'platform_ids' => 'required|array|in:1,2,3',
            'content' => ['required', 'string'],
            'scheduled_time' => ['required', 'date', 'after_or_equal:now'],
        ];

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = $this->user();

            $todayScheduledCount = $user->posts()
                ->whereDate('scheduled_time', now()->toDateString())
                ->count();

            if ($todayScheduledCount >= 10) {
                $validator->errors()->add('scheduled_time', 'You can only schedule 10 posts per day.');
            }
            if ($this->filled('platform_ids')) {

                $platforms = Platform::whereIn('id', $this->platform_ids)->get();

                if ($this->checkImageIsRequiredForPlatforms($platforms) && !$this->hasFile('image')) {
                    $validator->errors()->add('image', 'Image is required for the selected platform(s).');
                }


                if ($this->checkContentIsNotMaxLengthForPlatforms($platforms)) {
                    $validator->errors()->add('content', 'Content exceeds the maximum word count for the selected platform(s).');
                }
            }
        });
    }

    public function checkImageIsRequiredForPlatforms($platforms): bool
    {
        return $platforms->where('allow_post_without_image', false)->isNotEmpty();
    }

    public function checkContentIsNotMaxLengthForPlatforms($platforms): bool
    {
        $maxPlatformPostWordsCount = $platforms->sortByDesc('max_post_words_count')->first()->max_post_words_count;
        return str_word_count($this->content) > $maxPlatformPostWordsCount;
    }
}
