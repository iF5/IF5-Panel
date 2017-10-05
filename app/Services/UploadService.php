<?php

namespace App\Services;

class UploadService
{

    private $file;

    private $dir;

    private $extensions = [];

    private $response = (object)[
        'error' => false
    ];

    public function createDir($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    public function move($dir, $file)
    {

    }

    public function a()
    {
        $referenceDate = $referenceDate . "-01";

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        if (!in_array($extension, $this->extensions)) {
            return response()->json([
                'message' => 'Só são permitidos arquivos do tipo ' . implode(', ', $this->extensions) . '.'
            ]);
        }

        $date = $this->explodeDate($referenceDate);
        $employeeId = session('employee')->id;
        $providerId = session('provider') ? session('provider')->id : \Auth::user()->providerId;

        $finalFileName = sha1($employeeId . "-" . $documentId . "-" . $referenceDate);
        $originalFileName = $file->getClientOriginalName();

        $dir = storage_path() . "/upload/documents/{$providerId}/{$employeeId}/{$documentId}/{$date['year']}/{$date['month']}";
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $finalFileName = sprintf('%s.%s', $finalFileName, $extension);
        $isMoved = $file->move($dir, $finalFileName);
        if (!$isMoved) {
            return response()->json([
                'message' => "Falha ao enviar o arquivo <b>{$originalFileName}</b> por favor tente novamente!"
            ]);
        }

        $documentData =
            ['employeeId' => $employeeId,
                'documentId' => $documentId,
                'status' => 1,
                'referenceDate' => $referenceDate,
                'finalFileName' => $finalFileName,
                'originalFileName' => $originalFileName];

        $this->createLog('Checklist upload', 'PUT', $documentData);
        $this->documentRepository->saveDocument($documentData);
        return response()->json([
            'message' => "O arquivo <b>{$originalFileName}</b> foi enviado com sucesso!"
        ]);
    }

}