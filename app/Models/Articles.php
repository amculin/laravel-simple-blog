<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
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

    public $statusStyle;
    public $statusName;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::retrieved(function (Articles $articles) {
            $articles->setStatusStyle($articles->getStatusStyles()[$articles->status]);
            $articles->setStatusName($articles->getStatusNames()[$articles->status]);
        });
    }

    public function setStatusStyle(string $statusStyle): void
    {
        $this->statusStyle = $statusStyle;
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

    public function getStatusStyles(): array
    {
        return [
            1 => 'green',
            2 => 'gray',
            3 => 'yellow'
        ];
    }
}
