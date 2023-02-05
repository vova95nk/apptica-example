<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int    $category_id
 * @property int    $sub_category_id
 * @property Carbon $stat_date
 * @property int    $position
 *
 * @method static Builder byDate(Carbon $date)
 * @method static ApplicationChart firstOrCreate(array $params)
 */
class ApplicationChart extends Model
{
    use HasFactory;

    public $table = 'applications_chart';

    public $fillable = [
        'category_id',
        'sub_category_id',
        'stat_date',
        'position',
    ];

    public $casts = [
        'stat_date' => 'date',
    ];

    public $timestamps = false;

    public function scopeByDate(Builder $query, Carbon $date): Builder
    {
        return $query->where('stat_date', $date);
    }
}
