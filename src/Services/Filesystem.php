<?php

namespace Stitcher\Services;

class Filesystem
{
    private string $base;

    public function __construct(string $base)
    {
        $this->base = $base;
    }

    public function withBase(string $base): Filesystem
    {
        $fs = clone $this;

        $fs->base = $base;

        return $fs;
    }

    public function read(string $path): string
    {
        return file_get_contents($this->makeFullPath($path));
    }

    public function write(string $path, string $contents): Filesystem
    {
        ['dirname' => $dirname, 'basename' => $file] = pathinfo($path);

        if (! file_exists($dirname)) {
            mkdir($dirname, 0755, true);
        }

        file_put_contents($path, $contents);

        return $this;
    }

    public function exists(string $path): bool
    {
        return file_exists($path);
    }

    public function remove(string $path): Filesystem
    {
        $fullPath = $this->makeFullPath($path);

        if (! file_exists($fullPath)) {
            return $this;
        }

        if (! is_dir($fullPath)) {
            unlink($fullPath);

            return $this;
        }

        $directory = opendir($fullPath);

        while (($file = readdir($directory)) !== false) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }

            $childPath = $this->makePath($fullPath, $file);

            if (is_dir($childPath)) {
                $this->remove($childPath);

                continue;
            }

            unlink($childPath);
        }

        rmdir($fullPath);

        closedir($directory);

        return $this;
    }

    public function copy(string $source, string $destination): Filesystem
    {
        $sourcePath = $this->makeFullPath($source);

        $destinationPath = $this->makeFullPath($destination);

        if (! is_dir($sourcePath)) {
            copy($sourcePath, $destinationPath);

            return $this;
        }

        $directory = opendir($sourcePath);

        @mkdir($destinationPath);

        while (($file = readdir($directory)) !== false) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }

            $sourceChildPath = $this->makePath($sourcePath, $file);

            $destinationChildPath = $this->makePath($destinationPath, $file);

            if (is_dir($sourceChildPath)) {
                $this->copy($sourceChildPath, $destinationChildPath);

                continue;
            }

            copy($sourceChildPath, $destinationChildPath);
        }

        closedir($directory);

        return $this;
    }

    public function makeFullPath(
        string $path
    ): string {
        return $this->makePath($this->base, $path);
    }

    private function makePath(
        string $base,
        string $path
    ): string {
        if (strpos($path, $base) === 0) {
            $path = str_replace($base, '', $path);
        }

        return rtrim($base, '/') . '/' . ltrim($path, '/');
    }
}
