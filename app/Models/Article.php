<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory, Notifiable;

    const IS_ACTIVE = 1;
    const IS_SCHEDULED = 2;
    const IS_DRAFT = 3;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = ['title', 'content', 'user_id', 'status', 'publish_at'];

    public $createdDate;
    public $publishedDate;
    public $statusName;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::retrieved(function (Article $articles) {
            $articles->setCreatedDate($articles->created_at);
            $articles->setPublishedDate($articles->publish_at);
            $articles->setStatusName($articles->getStatusNames()[$articles->status]);
        });
    }
    
    /**
     * Interact with the article's status.
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            set: function (int|null $value) {
                if ($value == 1) {
                    return $this::IS_DRAFT;
                } else {
                    if ($this->publish_at) {
                        return $this::IS_SCHEDULED;
                    } else {
                        return $this::IS_ACTIVE;
                    }
                }
            }
        );
    }

    /**
     * Get the author that owns the article.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function setCreatedDate(string $date): void
    {
        $this->createdDate = substr($date, 0, 10);
    }

    public function setPublishedDate(string|null $date): void
    {
        $this->publishedDate = is_null($date) ? null : substr($date, 0, 10);
    }

    public function setStatusName(string $statusName): void
    {
        $this->statusName = $statusName;
    }

    public function getStatusNames(): array
    {
        return [
            1 => 'Active',
            2 => 'Scheduled',
            3 => 'Draft'
        ];
    }
}
