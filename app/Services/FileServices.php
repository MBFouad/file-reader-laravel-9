<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use App\Exceptions\CustomException;

class FileServices
{
    /**
     * @param string $file_path
     * @throws CustomException
     */
    private function checkIsExists(string $file_path)
    {
        if (!File::exists(trim($file_path))) {
            throw new CustomException('unable to find this file', 500);
        }
    }

    /**
     * @param string $file_path
     * @throws CustomException
     */
    private function checkIsDirectory(string $file_path)
    {
        if (File::isDirectory(trim($file_path))) {
            throw new CustomException('unable to handle directory path', 500);
        }
    }

    /**
     * @param string $file_path
     * @throws CustomException
     */
    private function checkIsReadable(string $file_path)
    {
        if (!File::isReadable(trim($file_path))) {
            throw new CustomException('unable to read this file', 500);
        }
    }

    /**
     * @param string $file_path
     * @throws CustomException
     */
    public function checkFile(string $file_path)
    {
        $this->checkIsExists($file_path);
        $this->checkIsDirectory($file_path);
        $this->checkIsReadable($file_path);
    }

    /**
     * Read file line and return custom pagination service
     * @param string $file_path
     * @param int $linecount
     * @param int $page
     * @return PaginatorService
     */
    public function readFile(string $file_path, $linecount = 10, $page = 1): PaginatorService
    {
        $lines = [];
        $spl = new \SplFileObject($file_path);
        $skipped_line = ($page > 1) ? $page * $linecount : 0;
        /** check file lines total with seek to last line  */
        $spl->seek($spl->getSize());
        $total_lines = $spl->key();

        /** set cursor to target page  */
        if ($page > 1) {
            $spl->seek($skipped_line);
        } else {
            $spl->seek(0);
        }

        for ($i = 0; $i < $linecount; $i++) {
            $line_number = $skipped_line + $i + 1;
            $lines[$line_number] = $spl->current();
            if ($line_number >= $total_lines) { #break on end file
                break;
            }
            $spl->next();
        }

        $paginator = new PaginatorService($lines, $linecount, $page, $total_lines);
        $paginator->setPath(route('file.reader'))->withQueryString();
        return $paginator;
    }
}