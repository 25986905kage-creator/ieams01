<?php

namespace App\Livewire\Import;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GraduateImport;


#[Title('Data Manager - Import Data')]
class DataManager extends Component
{
    use WithFileUploads;

    // Validate that only spreadsheets under 10MB are accepted
    #[Validate('required|file|mimes:xlsx,xls,csv|max:10240')]
    public $importFile;

    public $importSuccess = false;

    public function processImport()
    {
        $this->validate();
        try {
            // Execute the import using the temporary uploaded file
            Excel::import(new GraduateImport, $this->importFile);
            
         dd($row);
            $this->importSuccess = true;
            $this->reset('importFile'); // Clear the file input
            
        } catch (\Exception $e) {
            $this->addError('importFile', 'Import failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.import.data-manager');
    }
}
