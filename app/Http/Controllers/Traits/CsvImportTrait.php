<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SpreadsheetReader;

trait CsvImportTrait
{
    // -----------------------------
    //  PROCESS CSV IMPORT (FINAL SAVE)
    // -----------------------------
    public function processCsvImport(Request $request)
    {
        try {
            $filename = $request->input('filename');
            $path     = storage_path('app/csv_import/' . $filename);

            $hasHeader = $request->input('hasHeader');
            $fields    = $request->input('fields');

            // Remove empty fields + flip key/value
            $fields = array_flip(array_filter($fields));

            // Model
            $modelName = $request->input('modelName');
            $modelPath = "App\\Models\\" . $modelName;

            $reader = new SpreadsheetReader($path);
            $importedRows = 0;

            foreach ($reader as $key => $row) {

                if ($hasHeader && $key == 0) {
                    continue;
                }

                $record = [];

                foreach ($fields as $columnName => $csvIndex) {
                    $record[$columnName] = $row[$csvIndex] ?? null;
                }

                if (!empty($record)) {

                    // Add default CSV fields
                    $record['assigned_to_id'] = $request->assigned_to_id;
                    $record['service_id']     = $request->service_id;

                    // ⭐️ FIX STATUS SAVING
                    $record['status'] = $request->status ?? 'new';
                    // ⭐ Add created_by_id (Logged-in user)
                $record['created_by_id'] = auth()->id();

                    // Save to DB
                    $modelPath::create($record);

                    $importedRows++;
                }
            }

            File::delete($path);

            session()->flash('message', "Imported {$importedRows} rows to {$modelName}");

            return redirect($request->redirect);

        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    // -----------------------------
    //  PARSE CSV BEFORE IMPORT
    // -----------------------------
    public function parseCsvImport(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
            'assigned_to_id' => 'required',
            'service_id' => 'required',
            'status' => 'required',  // ⭐️ ensure status is required
        ]);

        $file = $request->file('csv_file');

        $path      = $file->path();
        $hasHeader = $request->header ? true : false;

        $reader  = new SpreadsheetReader($path);
        $headers = $reader->current();

        // Fetch sample rows
        $lines = [];
        $i = 0;
        while ($reader->next() !== false && $i < 5) {
            $lines[] = $reader->current();
            $i++;
        }

        // Store uploaded file into storage
        $filename = Str::random(10) . '.csv';
        $file->storeAs('csv_import', $filename);

        // Model info
        $modelName = $request->model;
        $modelPath = "App\\Models\\" . $modelName;
        $model = new $modelPath();
        $fillables = $model->getFillable();

        $redirect  = url()->previous();
        $routeName = 'admin.' . strtolower(Str::plural(Str::kebab($modelName))) . '.processCsvImport';

        // Return view
        return view('csvImport.parseInput', [
            'headers'        => $headers,
            'filename'       => $filename,
            'fillables'      => $fillables,
            'hasHeader'      => $hasHeader,
            'modelName'      => $modelName,
            'lines'          => $lines,
            'redirect'       => $redirect,
            'routeName'      => $routeName,

            // Required fields
            'assigned_to_id' => $request->assigned_to_id,
            'service_id'     => $request->service_id,
            'status'         => $request->status,   // ⭐ FIX: status always passed
        ]);
    }
}
