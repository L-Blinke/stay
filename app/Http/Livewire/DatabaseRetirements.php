<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\retirement;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class DatabaseRetirements extends LivewireDatatable
{
    public $model = User::class;

    public $exportable = true;
    public Team $course;

    public function builder()
    {
        return retirement::query()->leftJoin('users', 'users.id', 'retirements.student_id')->where('users.current_team_id', '=', $this->course->id);
    }

    public function columns()
    {
        return [
            Column::name('users.name')->filterable()->label('Name'),

            Column::name('users.email')->label('Email'),

            DateColumn::name('retirements.created_at')->defaultSort('desc')->label('Date'),

            TimeColumn::name('retirements.updated_at')->label('Time'),

            NumberColumn::name('users.id')->label('Student ID')
        ];
    }
}
