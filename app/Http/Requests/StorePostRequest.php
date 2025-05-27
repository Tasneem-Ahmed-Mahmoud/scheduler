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


        return[
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:1024', // moved 'nullable' first (optional but preferred style)
            'platform_ids' => 'required|array|min:1',
            'platform_ids.*' => 'required|integer|exists:platforms,id',
            'content' => 'required|string|max:1000|min:10',
            'scheduled_time' => 'required|date|after_or_equal:now',
            'status' => 'required|string|in:scheduled,published,draft',
        ];

      
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

               //  dd($this->platform_ids);
                $platforms = Platform::whereIn('id', $this->platform_ids)->get();

                // dd($platforms);
                // if ($this->checkImageIsRequiredForPlatforms($platforms) && !$this->hasFile('image')) {
                //     $validator->errors()->add('image', 'Image is required for the selected platform(s).');
                // }


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
        return str_word_count($this->content, ) > $maxPlatformPostWordsCount;
    }

//     protected function prepareForValidation()
// {
//     if (is_string($this->platform_ids)) {
//         $decoded = json_decode($this->platform_ids, true);
//         if (is_array($decoded)) {
//             $this->merge([
//                 'platform_ids' => $decoded,
//             ]);
//         }
//     }
// }

}
