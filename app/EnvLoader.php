<?php

namespace App;

class EnvLoader
{
    protected array $data = [];

    /**
     * __construct
     *
     * @param  string $envFilePath
     * @return void
     */
    public function __construct(string $envFilePath)
    {
        if (file_exists($envFilePath)) {
            $envFileContents = file_get_contents($envFilePath);
            $lines = explode(PHP_EOL, $envFileContents);

            foreach ($lines as $line) {
                if (!strlen($line)) {
                    continue;
                }
                list($key, $value) = explode('=', $line, 2);
                $value = trim($value);
                $this->data[$key] = $value;
            }
        }
    }

    /**
     * get
     *
     * @param  string $key
     * @param  string $defaultValue
     * @return string
     */
    public function get(string $key, string $defaultValue = ''): string
    {
        return isset($this->data[$key]) ? $this->data[$key] : $defaultValue;
    }
}
