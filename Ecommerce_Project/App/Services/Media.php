<?php

namespace App\Services;

class Media
{
    private array $file;
    private array $errors = [];
    private string $fileType = '';
    private string $fileExtension = '';
    private int $fileSize;
    private string $fileName;
    private string $tmppath;



    /**
     * Set the value of file
     *
     * @return  self
     */
    public function setFile($file)
    {
        $this->file = $file;
        $typeArray = explode('/', $file['type']);
        $this->setFileType($typeArray[0]);
        $this->setFileExtension($typeArray[1]);
        $this->setFileSize($file['size']);
        $this->setTmppath($file['tmp_name']);
        return $this;
    }

    public function upload(string $path): bool
    {
        $this->fileName = uniqid() . '.' . $this->fileExtension;
        $permenatPath = $path . $this->fileName;
        return move_uploaded_file($this->tmppath, $permenatPath);
    }

    public function delete(string $path): bool
    {
        if (file_exists($path)) {
            return unlink($path);
        }
        return false;
    }


    /**
     * Get the value of fileType
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * Set the value of fileType
     *
     * @return  self
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;

        return $this;
    }

    /**
     * Get the value of fileExtension
     */
    public function getFileExtension()
    {
        return $this->fileExtension;
    }

    /**
     * Set the value of fileExtension
     *
     * @return  self
     */
    public function setFileExtension($fileExtension)
    {
        $this->fileExtension = $fileExtension;

        return $this;
    }

    /**
     * Get the value of fileSize
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }

    /**
     * Set the value of fileSize
     *
     * @return  self
     */
    public function setFileSize($fileSize)
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    public function size(int $maxSize): self
    {
        if ($this->fileSize > $maxSize) {
            $maxSize = $maxSize / 1024;
            $this->errors[__FUNCTION__] = "Max size is {$maxSize} KB";
        }
        return $this;
    }

    public function extension(array $allowedExtensions): self // [png,jpg,jpeg]
    {
        if (!in_array($this->fileExtension, $allowedExtensions)) {
            $this->errors[__FUNCTION__] = "Available Extensions are " . implode(',', $allowedExtensions);
        }
        return $this;
    }

    /**
     * Get the value of errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set the value of errors
     *
     * @return  self
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;

        return $this;
    }

    public function getMessage($message): ?string
    {
        return $message ? "<div class='alert alert-danger' role='alert'>" . $message . " </div>" : "";
    }

    /**
     * Get the value of fileName
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set the value of fileName
     *
     * @return  self
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Set the value of tmppath
     *
     * @return  self
     */
    public function setTmppath($tmppath)
    {
        $this->tmppath = $tmppath;

        return $this;
    }
}
