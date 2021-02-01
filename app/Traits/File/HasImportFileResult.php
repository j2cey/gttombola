<?php


namespace App\Traits\File;

use Illuminate\Support\Carbon;
use App\Models\ImportFileResult;
use Illuminate\Support\Facades\DB;

trait HasImportFileResult
{
    /**
     * Get the number of elements to import.
     * @return int
     */
    abstract public function getNbToImport(): int;
    /**
     * Get the number of importation processing.
     * @return int
     */
    abstract public function getNbImportProcessing(): int;
    /**
     * Get the number of importation successed.
     * @return int
     */
    abstract public function getNbImportSuccess(): int;
    /**
     * Get the number of importation failed.
     * @return int
     */
    abstract public function getNbImportFailed(): int;
    /**
     * Get the number of importation processed.
     * @return int
     */
    abstract public function getNbImportProcessed(): int;


    //protected $appends = ['importfileresult'];


    #region Eloquent Relationships

    public function importfileresults()
    {
        $elem_type = get_called_class();
        return $this->belongsToMany(ImportFileResult::class, 'model_has_import_file_result', 'model_id', 'import_file_result_id')
            ->wherePivot('model_type', $elem_type)
            ->withTimestamps();
    }

    #endregion

    public function getImportfileresultAttribute() {
        return $this->importfileresults()->first();
    }


    public function setImportResult() {
        if ($this->importfileresults->count() == 0) {
            $this->createNewResult(true);
        }

        $this->updateImportResult();

        // Import rate
        if ($this->importfileresult && ($this->importfileresult->nb_to_import > 0)) {
            $this->importfileresult->update([
                'import_rate' => round((($this->importfileresult->nb_import_processed) / $this->importfileresult->nb_to_import) * 100, 0)
            ]);
        } else {
            $this->importfileresult->update([ 'import_rate' => 0 ]);
        }
    }

    private function createNewResult($importing = false) {
        $default_values = [
            'nb_to_import' => 0,
            'nb_import_processing' => 0,
            'nb_import_success' => 0,
            'nb_import_failed' => 0,
            'nb_import_processed' => 0,
        ];
        if ($importing) {
            $default_values['importstart_at'] = Carbon::now();
        } else {
            $default_values['sendingstart_at'] = Carbon::now();
        }
        $new_result = ImportFileResult::create($default_values);

        DB::table('model_has_import_file_result')->insert([
            'import_file_result_id' => $new_result->id,
            'model_type' => get_called_class(),
            'model_id' => $this->id,
        ]);
    }

    private function updateImportResult() {
        $data_array = [
            'nb_to_import' => $this->getNbToImport(),
            'nb_import_processing' => $this->getNbImportProcessing(),
            'nb_import_success' => $this->getNbImportSuccess(),
            'nb_import_failed' => $this->getNbImportFailed(),
            'nb_import_processed' => $this->getNbImportProcessed(),
        ];

        if ($data_array['nb_to_import'] > 0 && ($data_array['nb_to_import'] == $data_array['nb_import_processed'])) {
            $data_array['importend_at'] = Carbon::now();
        }
        $upd_rslt = $this->importfileresult->update($data_array);
    }
}
