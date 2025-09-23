<?php

namespace App\Livewire\Jobs;

use App\Models\VehicleJob;
use App\Models\Technician;
use App\Models\Vehicle;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Url;
use Livewire\Component;

class Upsert extends Component
{
    use AuthorizesRequests;

    public ?VehicleJob $job = null;
    public bool $isEditing = false;

    // Form fields
    public string $title = '';
    public string $description = '';
    public string $status = 'scheduled';
    public ?string $start_at = null;
    public ?string $end_at = null;

    public ?int $vehicle_id = null;
    public string $vehicle_registration = '';

    public array $technician_ids = [];
    public array $technician_roles = [];

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:120',
            'description' => 'nullable|string',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'vehicle_id' => 'required|exists:vehicles,id',
            'technician_ids' => 'array',
            'technician_ids.*' => 'exists:technicians,id',
        ];
    }

    public function mount(?VehicleJob $job = null): void
    {
        $this->job = $job;
        if ($job && $job->exists) {
            $this->authorize('view', $job);
            $this->isEditing = true;
            $this->fill([
                'title' => $job->title,
                'description' => $job->description ?? '',
                'status' => $job->status,
                'start_at' => optional($job->start_at)->format('Y-m-d\TH:i'),
                'end_at' => optional($job->end_at)->format('Y-m-d\TH:i'),
                'vehicle_id' => $job->vehicle_id,
                'vehicle_registration' => strtoupper(optional($job->vehicle)->registration ?? ''),
                'technician_ids' => $job->technicians()->pluck('technicians.id')->all(),
            ]);
        } else {
            $this->authorize('create', VehicleJob::class);
            $this->status = 'scheduled';
        }
    }

    public function findVehicleByRegistration(): void
    {
        $reg = strtoupper(trim($this->vehicle_registration));
        if ($reg === '') {
            $this->vehicle_id = null;
            return;
        }
        $vehicle = Vehicle::where('registration', $reg)->first();
        if ($vehicle) {
            $this->vehicle_id = $vehicle->id;
        } else {
            $this->addError('vehicle_registration', 'Vehicle not found.');
        }
    }

    public function save()
    {
        $this->findVehicleByRegistration();
        $data = $this->validate();

        try {
            if ($this->isEditing && $this->job) {
                $this->authorize('update', $this->job);
                $this->job->update([
                    'title' => $this->title,
                    'description' => $this->description ?: null,
                    'status' => $this->status,
                    'start_at' => $this->start_at ?: null,
                    'end_at' => $this->end_at ?: null,
                    'vehicle_id' => $this->vehicle_id,
                ]);
            } else {
                $this->job = VehicleJob::create([
                    'title' => $this->title,
                    'description' => $this->description ?: null,
                    'status' => $this->status,
                    'start_at' => $this->start_at ?: null,
                    'end_at' => $this->end_at ?: null,
                    'vehicle_id' => $this->vehicle_id,
                ]);
            }

            // Sync technicians with roles
            $sync = [];
            foreach ($this->technician_ids as $tid) {
                $sync[$tid] = ['role' => $this->technician_roles[$tid] ?? null];
            }
            $this->job->technicians()->sync($sync);

            session()->flash('success', 'Job saved successfully.');
            return redirect()->route('workshop.jobs.show', $this->job);
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save job.');
        }
    }

    public function getTechniciansProperty()
    {
        return Technician::orderBy('last_name')->orderBy('first_name')->get();
    }

    public function render()
    {
        return view('livewire.jobs.upsert', [
            'techniciansList' => $this->technicians,
        ])->layout('components.layouts.app', ['title' => $this->isEditing ? 'Edit Job' : 'Create Job']);
    }
}
