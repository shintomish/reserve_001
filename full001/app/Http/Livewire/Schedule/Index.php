<?php

namespace App\Http\Livewire\Schedule;

use App\Models\Schedule;
use App\Models\User;
use Carbon\CarbonImmutable;
use Livewire\Component;

class Index extends Component
{
    //選択中のユーザーid群
    public array $selectedUserIds = [];

    //カレンダー更新用イベントリスナー
    protected $listeners = ['refreshCalendar'];

    public function mount(): void
    {
        $this->selectedUserIds = User::all()->pluck('id')->toArray();
    }

    //選択中のユーザーid群に更新があった時のライフサイクルイベント
    public function updatedSelectedUserIds(): void
    {
        $this->dispatchBrowserEvent('refreshCalendar');
    }


    public function render()
    {
        // return view('livewire.schedule.index');
        $users = User::all();
        return view('livewire.schedule.index', compact('users'))
            ->extends('adminlte::page')
            ->section('content');
    }

    //FullCalendarレンダリング時に取得するResources
    public function getResources(): array
    {
        return User::query()->findMany($this->selectedUserIds)
            ->map(fn($user) => $this->convertToResourceByUserForFullcalendar($user))
            ->toArray();
    }

    //FullCalendarで使えるresourceの配列に整形
    private function convertToResourceByUserForFullcalendar(User $user): array
    {
        return [
            'id' => $user->id,
            'title' => $user->name,
        ];
    }

    //FullCalendarレンダリング時に取得するEvents
    public function getEvents($start, $end): array
    {
        $range = [
            CarbonImmutable::create($start)->format('Y-m-d'),
            CarbonImmutable::create($end)->format('Y-m-d'),
        ];

        return Schedule::query()->whereIn('user_id', $this->selectedUserIds)
            ->whereBetween('day', $range)
            ->get()
            ->map(fn($schedule) => $this->convertToEventByScheduleForFullcalendar($schedule))
            ->toArray();
    }

    //FullCalendarで使えるeventの配列に整形
    private function convertToEventByScheduleForFullcalendar(Schedule $schedule): array
    {
        $startDateTime = new CarbonImmutable($schedule->day . ' ' . $schedule->start);
        $endDateTime = new CarbonImmutable($schedule->day . ' ' . $schedule->end);
        return [
            'title' => $schedule->title,
            'start' => $startDateTime->format('c'),
            'end' => $endDateTime->format('c'),
            'resourceId' => $schedule->user_id,
            'extendedProps' => [
                'schedule_id' => $schedule->id
            ]
        ];
    }

    //カレンダー更新用イベント
    public function refreshCalendar(): void
    {
        $this->dispatchBrowserEvent('refreshCalendar');
    }

}
