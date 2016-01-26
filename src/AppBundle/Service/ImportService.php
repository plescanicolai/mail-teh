<?php

namespace AppBundle\Service;

use Ddeboer\DataImport\Reader\CsvReader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ImportService
 * @package AppBundle\Service
 */
class ImportService
{
    /** @var  array $errors */
    protected $errors;

    /** @var string $rootDir */
    private $rootDir;

    /**
     * ImportService constructor.
     * @param string $rootDir
     */
    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
    }

    /**
     * @param string $type
     * @return string
     */
    public function getUploadRootDir($type = 'csv/')
    {
        return $this->rootDir.'/../var/'.$type;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getUploadedCsvName($name = 'import_mail')
    {
        return $this->getUploadRootDir().$name.'.';
    }

    /**
     * @param string $header
     * @return mixed
     */
    public function getFileDelimiter($header)
    {
        $delimiters = $this->getDelimiter();
        $results = [];

        foreach ($delimiters as $key => $delimiter) {
            $regExp = '/['.$key.']/';
            $fields = preg_split($regExp, $header);
            if (count($fields) > 1) {
                if (!empty($results[$key])) {
                    $results[$key]++;
                } else {
                    $results[$key] = 1;
                }
            }
        }
        if (count($results)) {
            $results = array_keys($results, max($results));

            return $results[0];
        }
        $this->setError('error delimiter');

        return false;
    }

    /**
     * @return array
     */
    public function getDelimiter()
    {
        return [
            "\t"    => 'tab',
            ";"     => "semicolon",
            ","     => "comma",
            "#"     => "hash",
            '|'     => 'pipe',
            '\|'    => 'pipe2',
            " "     => "space",
            "\""    => "quotes",
        ];
    }

    /**
     * @param \SplFileObject $file
     * @param array          $data
     * @return array
     */
    public function getCsvHeader(\SplFileObject $file, &$data)
    {
        $csvReader = new CsvReader($file, $data['delimiter']);
        $csvReader->setHeaderRowNumber(0, 1);
        $csvReader->setStrict(false);
        $data['count'] = $csvReader->count();
        $data['header'] = $csvReader->getColumnHeaders();

        if ($csvReader->hasErrors() || count($csvReader->getFields()) <= 1) {
            $this->setError('error read file');
        } else {
            $row = $csvReader->getRow(1);
            foreach ($row as $key => $value) {
                $data['first'][$key] = $value;
            }
        }

        return $data;
    }

    /**
     * @param UploadedFile $file
     */
    public function uploadFile($file)
    {
        $uploadedFileInfo = pathinfo($file->getClientOriginalName());
        $ext = isset($uploadedFileInfo['extension'])?$uploadedFileInfo['extension']:'csv';

        if ($ext != 'csv' && $ext != 'txt') {
            $this->setError('invalid file extension');

            return;
        }
        $fileName = $this->getUploadedCsvName().$ext;
        $file->move($this->getUploadRootDir(), $fileName);
//        rename($fileName, $this->getUploadedCsvName().'csv');
    }

    /**
     * @param array $error
     */
    public function setError($error)
    {
        $this->errors[] = $error;
    }
}
