<?php

namespace Source\Support;

use Exception;

class FileHandler
{
    private $projectUrl;
    private $fileName;
    private $fileType;
    private $directory;
    private $fail;

    public function __construct(string $projectUrl, string $directory, string $fileType = 'json')
    {
        $this->projectUrl = mb_strtolower($projectUrl);
        $this->fileType = str_replace('.', '', mb_strtolower($fileType));
        $this->setDirectory($directory);
    }

    public function setDirectory(string $directory): void
    {
        try {
            $directoryPath = $this->projectUrl . '/' . mb_strtolower($directory);
            if (!is_dir($directoryPath)) {
                if (!mkdir($directoryPath, 0755, true) && !is_writable($directory)) {
                    throw new Exception('Você não tem permissão para criar o diretório: ' . $directory);
                }
            }
            $this->directory = $directoryPath;
        } catch (Exception $e) {
            $this->fail = $e;
        }
    }

    public function setFileName(string $fileName): void
    {
        try {
            $fileName = trim($fileName);
            $fileName = str_replace('.' . $this->fileType, "", $fileName);
            $fileName = preg_replace("/[^\p{L}\p{N}_]/u", "", $fileName);
            $fileName = mb_strtolower($fileName, 'UTF-8');

            if (empty($fileName)) {
                throw new Exception("Nome de arquivo está vazio ou contém apenas caracteres inválidos");
            }

            $this->filename = $fileName . '.' . $this->fileType;
        } catch (Exception $e) {
            $this->fail = $e;
        }
    }

    public function getDirectory(): string
    {
        return $this->directory;
    }

    public function getFullPath(): string
    {
        return $this->getDirectory() . '/' . $this->filename;
    }

    public function writeData(array|object|string $data): bool
    {
        try {
            if ($this->fileType === 'json') $data = json_encode($data, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
            if (file_put_contents($this->getFullPath(), $data) === false) {
                throw new Exception("Erro ao escrever no arquivo " . $this->getFullPath());
            }
            return true;
        } catch (Exception $e) {
            $this->fail = $e;
            return false;
        }
    }

    public function readData(): array|null
    {
        try {
            $fullPath = $this->getFullPath();
            if (file_exists($fullPath) && !is_dir($fullPath)) {
                $fileContent = file_get_contents($fullPath);
                if ($this->fileType === 'json') {
                    return json_decode($file, true, 512, JSON_THROW_ON_ERROR);
                }
                return $fileContent;
            }
            throw new Exception("Erro ao ler o arquivo " . $fullPath);
        } catch (Exception $e) {
            $this->fail = $e;
            return null;
        }
    }

    public function deleteData(): bool
    {
        try {
            if (file_exists($this->getFullPath())) {
                if (!unlink($this->getFullPath())) {
                    throw new Exception("Erro ao apagar o arquivo " . $this->getFullPath());
                }
                return true;
            }
            throw new Exception("Arquivo não encontrado: " . $this->getFullPath());
        } catch (Exception $e) {
            $this->fail = $e;
            return false;
        }
    }

    public function fail(): Exception|null
    {
        return $this->fail ?? null;
    }
}