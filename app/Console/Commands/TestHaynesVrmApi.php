<?php

namespace App\Console\Commands;

use App\Services\HaynesPro;
use Illuminate\Console\Command;
use Exception;

class TestHaynesVrmApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:haynes-vrm-api {vrm?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the HaynesPro VRM API with a vehicle registration mark';

    /**
     * Execute the console command.
     */
    public function handle(HaynesPro $haynesPro)
    {
        $vrm = $this->argument('vrm') ?? 'MS02 MUD';
        
        $this->info("Testing HaynesPro VRM API with registration: {$vrm}");
        $this->info('---');

        try {
            $vehicleDetails = $haynesPro->getVehicleDetailsByVrm($vrm);
            
            $this->info('✅ Success! Vehicle details retrieved:');
            $this->newLine();
            
            if (isset($vehicleDetails['VehicleInfo'])) {
                $vehicleInfo = $vehicleDetails['VehicleInfo'];
                
                $this->line("Make: " . ($vehicleInfo['CombinedMake'] ?? 'N/A'));
                $this->line("Model: " . ($vehicleInfo['CombinedModel'] ?? 'N/A'));
                $this->line("Engine Capacity: " . ($vehicleInfo['CombinedEngineCapacity'] ?? 'N/A'));
                $this->line("Fuel Type: " . ($vehicleInfo['CombinedFuelType'] ?? 'N/A'));
                $this->line("Forward Gears: " . ($vehicleInfo['CombinedForwardGears'] ?? 'N/A'));
                $this->line("Transmission: " . ($vehicleInfo['CombinedTransmission'] ?? 'N/A'));
                $this->line("Combined VIN: " . ($vehicleInfo['CombinedVin'] ?? 'N/A'));
                $this->line("Haynes Model Variant Description: " . ($vehicleInfo['HaynesModelVariantDescription'] ?? 'N/A'));
                $this->line("VRM Current: " . ($vehicleInfo['VrmCurr'] ?? 'N/A'));
                $this->line("DVLA Date of Manufacture: " . ($vehicleInfo['DvlaDateofManufacture'] ?? 'N/A'));
                $this->line("DVLA Last Mileage: " . ($vehicleInfo['DvlaLastMileage'] ?? 'N/A'));
                $this->line("DVLA Last Mileage Date: " . ($vehicleInfo['DvlaLastMileageDate'] ?? 'N/A'));
                $this->line("Haynes Maximum Power at RPM: " . ($vehicleInfo['HaynesMaximumPowerAtRpm'] ?? 'N/A'));
                $this->line("Tecdoc Ktype: " . ($vehicleInfo['TecdocKType'] ?? $vehicleInfo['TecdocID'] ?? $vehicleInfo['TecdocKtype'] ?? $vehicleInfo['TecDocKType'] ?? $vehicleInfo['TecDocID'] ?? $vehicleInfo['TecdocNType'] ?? 'N/A'));
            } else {
                $this->warn('No VehicleInfo found in response');
            }
            
            $this->newLine();
            $this->comment('Full response:');
            $this->line(json_encode($vehicleDetails, JSON_PRETTY_PRINT));
            
        } catch (Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            $this->newLine();
            $this->comment('Check the logs for more details.');
            
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
} 