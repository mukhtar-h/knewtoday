<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'title', 'slug', 'excerpt', 'content', 'status', 'is_featured', 'thumbnail_path', 'reading_time'];

    protected $casts = [
        'status' => PostStatus::class, // enum cast
        'is_featured' => 'boolean',
    ];

    // Relationships

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where($query->qualifyColumn('status'), PostStatus::Published->value)
            ->where($query->qualifyColumn('updated_at'), '<=', now());
    }

    public function scopeMatchingSearch(
        Builder $query,
        ?string $searchTerm,
        bool $includeRelations = false,
        bool $includeContent = true
    ): Builder {
        $terms = self::searchTerms($searchTerm);

        if ($terms === []) {
            return $query;
        }

        return $query->where(function (Builder $searchQuery) use ($terms, $includeRelations, $includeContent) {
            foreach ($terms as $term) {
                $likeTerm = '%'.self::escapeLike($term).'%';

                $searchQuery->where(function (Builder $termQuery) use ($likeTerm, $includeRelations, $includeContent) {
                    $termQuery
                        ->where('title', 'like', $likeTerm)
                        ->orWhere('excerpt', 'like', $likeTerm);

                    if ($includeContent) {
                        $termQuery->orWhere('content', 'like', $likeTerm);
                    }

                    if ($includeRelations) {
                        $termQuery
                            ->orWhereHas('category', function (Builder $categoryQuery) use ($likeTerm) {
                                $categoryQuery->where('name', 'like', $likeTerm);
                            })
                            ->orWhereHas('tags', function (Builder $tagQuery) use ($likeTerm) {
                                $tagQuery->where('name', 'like', $likeTerm);
                            });
                    }
                });
            }
        });
    }

    private static function searchTerms(?string $searchTerm): array
    {
        $searchTerm = trim((string) $searchTerm);

        if ($searchTerm === '') {
            return [];
        }

        $terms = preg_split('/\s+/', $searchTerm, -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $terms = array_filter($terms, fn (string $term): bool => mb_strlen($term) >= 2);

        if ($terms === []) {
            $terms = [$searchTerm];
        }

        return array_slice(array_values(array_unique($terms)), 0, 5);
    }

    private static function escapeLike(string $value): string
    {
        return addcslashes($value, '\\%_');
    }
}
