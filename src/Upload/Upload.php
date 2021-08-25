<?php

namespace App\Upload;

use Core\Controller\AController;
use mysql_xdevapi\Exception;

class Upload extends AController
{
    private array $selectedFile;
    private string $targetDir = 'upload/';
    private string $targetFile;
    private ?string $errorMsg = null;

    public function setFile($file)
    {
        if (!$file['error']) {
            $this->selectedFile = $file;
        }
    }

    /**
     * @return string
     */
    public function getTargetFile(): string
    {
        return '/' . $this->targetFile;
    }

    public function run($slug)
    {
        $fileType = strtolower(pathinfo(basename($this->selectedFile["name"]), PATHINFO_EXTENSION));
        $this->targetFile = $this->targetDir . $slug . date("-Ymd-His.") . $fileType;

        /* Check if image file is a actual image or fake image */
        $check = getimagesize($this->selectedFile["tmp_name"]);
        if ($check === false) {
            $this->errorMsg = 'Please use image file';
        }

        /* Check if file already exists */
        if (file_exists($this->targetFile)) {
            $this->errorMsg = 'File already exist on storage';
        }

        /* Check file size */
        if ($this->selectedFile["size"] > 5000000) {
            $this->errorMsg = 'File is bigger than 5 Mo';
        }

        /* Allow certain file formats */
        if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif") {
            $this->errorMsg = 'File format not allowed';
        }

        if ($this->errorMsg) {
            return false;
        }

        /* try to upload file */
        if (move_uploaded_file($this->selectedFile["tmp_name"], $this->targetFile)) {
            return true;
        }

        return false;
    }

    public function removeFile($filename)
    {
        unlink(substr($filename, 1));
    }
}