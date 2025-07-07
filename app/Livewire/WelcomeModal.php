<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class WelcomeModal extends Component
{
    public bool $showModal = false;
    public int $currentSlide = 1;
    public int $totalSlides = 4;

    public function mount()
    {
        // Show modal only if user hasn't completed the tour
        $this->showModal = !Auth::user()->hasCompletedTour();
    }

    public function nextSlide()
    {
        if ($this->currentSlide < $this->totalSlides) {
            $this->currentSlide++;
        }
    }

    public function previousSlide()
    {
        if ($this->currentSlide > 1) {
            $this->currentSlide--;
        }
    }

    public function goToSlide($slideNumber)
    {
        if ($slideNumber >= 1 && $slideNumber <= $this->totalSlides) {
            $this->currentSlide = $slideNumber;
        }
    }

    public function completeTour()
    {
        Auth::user()->completeTour();
        $this->showModal = false;
        $this->dispatch('tour-completed');
    }

    public function skipTour()
    {
        Auth::user()->completeTour();
        $this->showModal = false;
        $this->dispatch('tour-skipped');
    }

    public function render()
    {
        return view('livewire.welcome-modal');
    }
}
