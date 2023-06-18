<?php

namespace App\Models\task;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = TaskFillable::TASKS;

    public function getTitleAttribute($value)
    {
        return strtoupper($value);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = strtoupper($value);
    }

    public function getFormattedDueDateAttribute()
    {
        return Carbon::parse($this->due_date)->format('M d, Y');
    }

    public function scopeActive($query, $status)
    {
        return $query->when($status != null, function (Builder $query) use ($status) {
            $query->where('status', '=', $status);
        });
    }

    public function scopeSearchValue($query, $searchValue)
    {
        return $query->where(function (Builder $q) use ($searchValue) {
            $q->orWhere('title', 'like', '%'.$searchValue.'%')
                ->orWhere('description', 'like', '%'.$searchValue.'%');
        });
    }

}
