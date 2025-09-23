<?php

namespace App\Livewire\Jobs;

use App\Models\VehicleJob;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, AuthorizesRequests;

    public string $search = '';
    public string $status = 'all';
    public ?string $technicianId = null;
    public ?string $dateFrom = null;
    public ?string $dateTo = null;

    public string $sortBy = 'start_at';
    public string $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => 'all'],
        'technicianId' => ['except' => null],
        'dateFrom' => ['except' => null],
        'dateTo' => ['except' => null],
        'sortBy' => ['except' => 'start_at'],
        'sortDirection' => ['except' => 'desc'],
        'page' => ['except' => 1],
    ];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatus() { $this->resetPage(); }
    public function updatingTechnicianId() { $this->resetPage(); }

    public function sort(string $field): void
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function getJobsProperty()
    {
        $q = VehicleJob::query()->with(['vehicle', 'technicians']);

        if ($this->status !== 'all') {
            $q->where('status', $this->status);
        }

        if ($this->technicianId) {
            $q->whereHas('technicians', function ($sub) {
                $sub->where('technicians.id', $this->technicianId);
            });
        }

        if ($this->dateFrom) {
            $q->whereDate('start_at', '>=', $this->dateFrom);
        }
        if ($this->dateTo) {
            $q->whereDate('end_at', '<=', $this->dateTo);
        }

        if ($this->search) {
            $term = '%' . trim($this->search) . '%';
            $q->where(function ($sub) use ($term) {
                $sub->where('job_number', 'like', $term)
                    ->orWhere('title', 'like', $term)
                    ->orWhereHas('vehicle', fn($v) => $v->where('registration', 'like', $term))
                    ->orWhereHas('technicians', function ($t) use ($term) {
                        $t->where('first_name', 'like', $term)->orWhere('last_name', 'like', $term);
                    });
            });
        }

        $sortable = ['job_number', 'title', 'status', 'start_at', 'end_at'];
        if (!in_array($this->sortBy, $sortable, true)) {
            $this->sortBy = 'start_at';
        }
        $q->orderBy($this->sortBy, $this->sortDirection);

        return $q->paginate(25);
    }

    public function render()
    {
        return view('livewire.jobs.index', [
            'jobs' => $this->jobs,
        ])->layout('components.layouts.app', ['title' => 'Jobs']);
    }
}
