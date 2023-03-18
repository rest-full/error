<?php

namespace Restfull\Error\Exceptions;

use Restfull\Error\Exceptions;
use Restfull\Filesystem\File;

/**
 *
 */
class ErrorController
{

    /**
     * @param array $param
     *
     * @return array
     */
    public function handling(array $param): array
    {
        $traces = [];
        for ($a = (count($param['traces']) - 1); $a >= 0; $a--) {
            if ($param['traces'][$a]['function'] == 'call_user_func_array') {
                $param['traces'][$a - 1]['line'] = $this->identifyNextTrace(
                    $param['traces'][$a - 1]['function'],
                    $param['traces'][$a - 2]['file']
                );
                $param['traces'][$a - 1]['file'] = $param['traces'][$a
                - 2]['file'];
            }
            if (in_array(
                    $param['traces'][$a]['function'],
                    ["__construct", "__Construct", 'loadClass']
                ) === false
                || $a == 0
            ) {
                if (isset($param['traces'][$a]['class'])
                    && isset($param['traces'][$a]['type'])
                    && isset($param['traces'][$a]['function'])
                ) {
                    $function = $param['traces'][$a]['class']
                        . $param['traces'][$a]['type']
                        . $param['traces'][$a]['function'];
                    if (!in_array($function, $traces)) {
                        $arguments[$function] = $this->arguments(
                            $param['traces'][$a]['line'],
                            $param['traces'][$a]['file']
                        );
                    }
                    $traces[] = $function . " - " . $param['traces'][$a]['file']
                        . ", line: " . $param['traces'][$a]['line'];
                }
            }
        }
        return [
            'traces' => $traces,
            'msg' => $param['msg'],
            'args' => $arguments
        ];
    }

    /**
     * @param string $method
     * @param string $file
     *
     * @return int
     * @throws Exceptions
     */
    private function identifyNextTrace(string $method, string $file): int
    {
        $arq = new File($file);
        $file = $arq->read();
        $count = count($file['content']);
        for ($a = 0; $a < $count; $a++) {
            if (stripos($file['content'][$a], $method) !== false) {
                $line = $a + 1;
            }
        }
        return $line;
    }

    /**
     * @param int $count
     * @param string $file
     *
     * @return array
     * @throws Exceptions
     */
    private function arguments(int $count, string $file): array
    {
        $arq = new File($file);
        $file = $arq->read();
        for ($a = ($count - 5); $a < $count + 5; $a++) {
            if (isset($file['content'][$a])) {
                $line[$a] = $file['content'][$a];
            }
        }
        return ['line' => $line, 'identify' => $count - 1];
    }
}