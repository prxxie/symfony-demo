<?php

namespace App\Service;

interface FileUploadServiceInterface
{
    public function setFile(mixed $file): self;
    public function upload(): string;
    public function delete(): bool;
}
