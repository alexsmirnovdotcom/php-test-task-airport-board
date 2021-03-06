<?php

namespace App\Service;

class JsonParser
{
    private string $sourceDir;

    public function __construct(string $sourceDir)
    {
        $this->sourceDir = rtrim($sourceDir, DIRECTORY_SEPARATOR);
    }

    public function load(string $fileName): array
    {
        $path = $this->buildPath($fileName);
        $this->assertFileExists($path);

        return $this->prepareResult(
            $path,
            file_get_contents($path)
        );
    }

    private function buildPath(string $fileName): string
    {
        return implode(
            DIRECTORY_SEPARATOR,
            [
                $this->sourceDir,
                $fileName
            ]
        );
    }

    private function assertFileExists(string $path): void
    {
        if (!file_exists($path)) {
            throw new \Exception(
                sprintf(
                    'File "%s" not exists.',
                    $path
                )
            );
        }
    }

    private function prepareResult(string $path, string $content): array
    {
        try {
            $result = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable $exception) {
            throw new \Exception(
                sprintf(
                    'Fail parse json file: "%s". Error: "%s".',
                    $path,
                    $exception->getMessage()
                ),
                0,
                $exception
            );
        }

        if (!is_array($result)) {
            throw new \Exception(
                sprintf(
                    'File content should be array. "%s" given. File path: "%s".',
                    gettype($content),
                    $path
                )
            );
        }

        return $result;
    }
}