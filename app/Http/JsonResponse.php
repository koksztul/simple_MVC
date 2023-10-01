<?php

namespace App\Http;

class JsonResponse
{
    protected array $data;
    protected int $statusCode;

    /**
     * __construct
     *
     * @param  array $data
     * @param  int $statusCode
     */
    public function __construct(array $data = ['success' => true], int $statusCode = 200)
    {
        $this->data = $data;
        $this->statusCode = $statusCode;
        $this->send();
    }

    /**
     * send
     *
     * @return void
     */
    public function send(): void
    {
        http_response_code($this->statusCode);

        header('Content-Type: application/json');

        echo json_encode($this->data);
    }
}
