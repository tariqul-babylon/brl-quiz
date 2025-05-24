<?php

namespace App\Livewire\List;

use App\Models\LaravelLoggerActivity as ModelsLaravelLoggerActivity;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Activity extends Component
{
    use WithPagination;

    // protected $paginationTheme = 'bootstrap';

    public $per_page = 15;
    public $description;
    public $route;
    public $method;
    public $ip;
    public $has_not_ip;
    public $user_agent;
    public $user_id;
    public $user_type;
    public $date_from;
    public $time_from;
    public $date_to;
    public $time_to;
    public $today;
    public $users = [];
    public $order_by = 'Create At DESC';
    protected $listeners = ['dataChanged'];

    public function dataChanged($key, $val)
    {
        $this->{$key} = $val;
    }
    public function updated($property)
    {
        if ($property == 'date_from') {
            $this->reset(['time_from']);
        } elseif ($property == 'date_to') {
            $this->reset(['time_to']);
        }
        $this->gotoPage(1);
    }
    public function mount()
    {
        $this->users = User::select('id', 'name')->get();

        $this->today = Carbon::now();
        $this->date_from = $this->today->format('d/m/Y');
        $this->date_to = $this->today->format('d/m/Y');
    }
    public function render()
    {
        $date_from = null;
        $date_to = null;
        if ($this->date_from) {
            $date_from = Carbon::createFromFormat('d/m/Y', $this->date_from)->toDateString();
        }
        if ($this->date_to) {
            $date_to = Carbon::createFromFormat('d/m/Y', $this->date_to)->toDateString();
        }
        // dump($date_to, $date_from);

        return view('livewire.list.activity', [
            'logs' => ModelsLaravelLoggerActivity::query()
                ->when($this->description)
                ->where('description', 'like', '%' . trim($this->description) . '%')

                ->when($this->route)
                ->where('route', 'like', '%' . trim($this->route) . '%')

                ->when($this->method)
                ->where('methodType', $this->method)

                ->when($this->ip)
                ->where('ipAddress', 'like', '%' . trim($this->ip) . '%')

                ->when($this->has_not_ip)
                ->whereNot('ipAddress', 'like', '%' . trim($this->has_not_ip) . '%')

                ->when($this->user_agent)
                ->where('userAgent', 'like', '%' . trim($this->user_agent) . '%')

                ->when($this->user_id)
                ->where('userId', $this->user_id)

                ->when($this->user_type)
                ->where('userType', $this->user_type)

                ->when($date_from, function ($query) use ($date_from) {
                    if ($this->time_from) {
                        $query->where('created_at', '>=', $date_from . ' ' . $this->time_from . ':00');
                    } else {
                        $query->whereDate('created_at', '>=', $date_from);
                    }
                })
                ->when($date_to, function ($query) use ($date_to) {
                    if ($this->time_to) {
                        $query->where('created_at', '<=', $date_to . ' ' . $this->time_to . ':59');
                    } else {
                        $query->whereDate('created_at', '<=', $date_to);
                    }
                })

                ->when($this->order_by == 'Create At ASC')
                ->orderBy('created_at', 'ASC')

                ->when($this->order_by == 'Create At DESC')
                ->orderBy('created_at', 'DESC')

                ->paginate($this->per_page),
        ]);
    }
}
