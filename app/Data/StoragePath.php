<?php


namespace App\Data;


use Illuminate\Http\UploadedFile;

class StoragePath
{
    const BASE_PHOTO = 'photos/';
    const BASE_RESUME = 'resumes/';

    /**
     * @var string
     */
    protected $base;

    /**
     * @var string
     */
    protected $sub;

    /**
     * @var string
     */
    protected $fileName;

    /**
     * StoragePath constructor.
     *
     * @param string $base
     * @param string $sub
     * @param string $fileName
     */
    public function __construct($base = '', $sub = '', $fileName)
    {
        $this->base     = $base;
        $this->sub      = $sub;
        $this->fileName = $fileName;
    }

    public function get()
    {
        return $this->base . $this->sub . '/' . $this->fileName;
    }

    /**
     * @param string                                         $sub
     * @param \Illuminate\Http\UploadedFileUploadedFile|null $uploadedFile
     *
     * @return StoragePath
     */
    public static function createPhotoFromUploadedFile($sub = '', $uploadedFile)
    {
        if ($uploadedFile instanceof UploadedFile) {
            return new self(self::BASE_PHOTO, $sub, $uploadedFile->hashName());
        }
    }
}