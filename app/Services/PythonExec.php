<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Process;

class PythonExec
{
    private $python;
    public function __construct()
    {
        $this->python = env('PYTHON_PATH', 'python');
    }

    public function exec($script, $args)
    {
        $path = base_path("python");
        $command = "\"$this->python\" \"$script.py\" \"$args\"";
        $process = Process::timeout(120)->env(getenv())->path(base_path('python'))->run($command)->throw();
        return $process->output();
    }

    public function prompt($message)
    {
        $path = base_path("python/exports/charts/temp_chart.png");
        $before = filemtime($path);
        logger("Before: $before");
        $result = null;
        $error = null;
        try {
            $result = $this->exec("prompt", $message);
        } catch (Exception $e) {
            $error = $e->getMessage();
            logger('error: ' . $error);
        }
        $after = filemtime($path);
        logger("After: $after");

        if ($before != $after) {
            copy($path, storage_path("app/public/charts/$after.png"));
            // $message = $error == null ? $result : "";
            return [
                'type' => 'chart',
                'image' => url("storage/charts/$after.png"),
                'message' => $message,
            ];
        } else if ($result != null) {
            return [
                'type' => 'text',
                'message' => $result
            ];
        }  else {
            return [
                'type' => 'text',
                'message' => $message
            ];
        }

    }
}
