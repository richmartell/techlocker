<?php

namespace App\Livewire\Dashboard;

use Carbon\Carbon;
use Livewire\Component;

class PerformanceChart extends Component
{
    public array $chartData = [];

    public function mount()
    {
        $this->generateChartData();
    }

    private function generateChartData()
    {
        // In a real application, you would fetch this data from your database
        // For now, we'll generate some sample data
        $months = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];
        
        $this->chartData = [];
        
        // Generate data for the current year
        $currentYear = Carbon::now()->year;
        
        foreach ($months as $index => $month) {
            // Generate some random data for demonstration
            $revenue = rand(5000, 15000);
            $expenses = rand(3000, 8000);
            $profit = $revenue - $expenses;
            
            // Create a date for the first of each month
            $date = Carbon::createFromDate($currentYear, $index + 1, 1)->format('Y-m-d');
            
            $this->chartData[] = [
                'date' => $date,
                'revenue' => $revenue,
                'expenses' => $expenses,
                'profit' => $profit,
                'jobs' => rand(20, 50),
            ];
        }
    }

    public function render()
    {
        return view('livewire.dashboard.performance-chart');
    }
}