<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Str;
use RuntimeException;

class UsernameSuggestionService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    /**
     * @return array<int, string>
     */
    public function suggestUsernames(string $name): array
    {
        $base = Str::slug($name, '_');

        if (empty($base)) {
            $base = 'user';
        }

        // Keep room for random suffixes.
        $base = Str::limit($base, 200, '');

        $adjectives = [
            'happy', 'little', 'sweet', 'golden',
            'cozy', 'dreamy', 'sunny', 'magic',
        ];

        $nouns = [
            'apple', 'cake', 'flower', 'cloud',
            'peach', 'moon', 'star', 'berry',
        ];

        $suggestions = [];

        // Try a limited number of times to find four available names.
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $creative = $adjectives[array_rand($adjectives)]
                .$nouns[array_rand($nouns)];

            $candidates = [
                $base,
                $base.random_int(100, 9999),
                $base.'_'.Str::lower(Str::random(8)),
                $creative,
                $creative.random_int(100, 9999),
                $creative.'_'.Str::lower(Str::random(8)),
            ];

            // Remove repeated candidates and suggestions already collected.
            $candidates = array_values(array_diff(
                array_unique($candidates),
                $suggestions
            ));
            // Find which candidates already belong to InstaNest users.
            $taken = $this->userRepository
                ->getTakenUsernames($candidates);

            foreach ($candidates as $candidate) {
                if (! in_array($candidate, $taken, true)) {
                    $suggestions[] = $candidate;
                }

                if (count($suggestions) === 4) {
                    return $suggestions;
                }
            }
        }

        throw new RuntimeException(
            'Unable to generate available username suggestions.'
        );
    }
}
