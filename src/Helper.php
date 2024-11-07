<?php

namespace CArena\EloquentStalker;

use Exception;

class Helper
{
    /**
     * Convierte un path a un namespace considerando que se corresponden entre ellos
     */
    public static function app_path_to_namespace(string $relativePathToAppPath, string $appNamespace = 'App\\'): string
    {
        $pathinfo = pathinfo($relativePathToAppPath);
        if ($pathinfo['extension'] != 'php') {
            throw new Exception('Not a php file', 1);
        }
        $namespace = substr($relativePathToAppPath, 0, -4); // Le quito la extensión
        $namespace = str_replace('/', '\\', $namespace); // Armo el namespace con barra invertida
        $namespace = str_replace('.\\', '', $namespace); // Dejo sólo el path relativo
        $namespace = ltrim($namespace, '\\');

        return $appNamespace.$namespace;
    }

    public static function get_all_php_files_in_directory($directoryPath, $relativeToPath = ''): array
    {
        $directoryAbsolutePath = realpath($directoryPath);
        $phpFiles = [];
        foreach (scandir($directoryAbsolutePath) as $contentName) {
            if ($contentName == '.' || $contentName == '..') {
                continue;
            }

            $contentPath = $directoryAbsolutePath.'/'.$contentName;

            if (is_dir($contentPath)) {
                $childPhpFiles = self::get_all_php_files_in_directory($contentPath, $relativeToPath);
                $phpFiles = array_merge($phpFiles, $childPhpFiles);

                continue;
            }

            $pathinfo = pathinfo($contentPath);

            if (! array_key_exists('extension', $pathinfo)) {
                continue;
            }

            if ($pathinfo['extension'] != 'php') {
                continue;
            }

            $phpFiles[] = str_replace($relativeToPath, '', $contentPath);
        }

        return $phpFiles;
    }
}
