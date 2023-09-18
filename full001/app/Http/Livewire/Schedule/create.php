<?php

namespace App\Http\Livewire\Schedule;

use App\Models\Schedule;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Create extends Component
{
    //アラート表示用
    use LivewireAlert;

    public Schedule $schedule;

    public function mount(): void
    {
        $this->schedule = new Schedule();
    }

    public function render()
    {
        $users = User::all();
        return view('livewire.schedule.create', compact('users'));
    }

    public function openModal(): void
    {
        $this->dispatchBrowserEvent('showCreateScheduleModal');
    }

    //開始時間が終了時間より遅い時間の時に終了時間をリセットする
    public function setScheduleStart($start): void
    {
        $this->schedule->start = $start;
        if ($this->isStartTimeExceededEndTime()) {
            $this->schedule->end = null;
        }
    }

    //開始時間が終了時間より遅い時間かどうか
    private function isStartTimeExceededEndTime(): bool
    {
        return strtotime($this->schedule->start) >= strtotime($this->schedule->end);
    }

    public function create(): void
    {
        $this->validate();
        $this->schedule->save();
        $this->schedule = new Schedule();
        $this->dispatchBrowserEvent('closeCreateScheduleModal');
        $this->emitUp('refreshCalendar');
        $this->alert('success', '登録完了');
    }

    protected function rules(): array
    {
        return [
            'schedule.user_id' => 'required',
            'schedule.title' => 'required',
            'schedule.day' => 'required',
            'schedule.start' => 'required',
            'schedule.end' => 'required',
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'schedule.user_id' => 'ユーザー',
            'schedule.title' => 'タイトル',
            'schedule.day' => '日付',
            'schedule.start' => '開始時間',
            'schedule.end' => '終了時間',
        ];
    }
}
