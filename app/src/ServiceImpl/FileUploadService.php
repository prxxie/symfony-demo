<?php

namespace App\ServiceImpl;

use App\Service\FileUploadServiceInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\AbstractUnicodeString;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploadService implements FileUploadServiceInterface
{
    protected ParameterBagInterface $params;
    protected UploadedFile $file;
    protected SluggerInterface $slugger;

    public string $originalFilename;
    public AbstractUnicodeString $safeFilename;

    public function __construct(SluggerInterface $slugger, ParameterBagInterface $params)
    {
        $this->slugger = $slugger;
        $this->params = $params;
    }

    public function setFile(mixed $file): self
    {
        $this->file = $file;

        $this->originalFilename = pathinfo($this->file->getClientOriginalName(), PATHINFO_FILENAME);
        $this->safeFilename = $this->slugger->slug($this->originalFilename);

        return $this;
    }

    public function upload(): string
    {
        $newFilename = $this->safeFilename . '-' . uniqid() . '.' . $this->file->guessExtension();

        try {
            $this->file->move(
                $this->params->get('upload_dir'),
                $newFilename
            );
        } catch (FileException $e) {
            throw $e;
        }

        return $newFilename;
    }

    public function delete(): bool
    {
        return true;
    }
}
