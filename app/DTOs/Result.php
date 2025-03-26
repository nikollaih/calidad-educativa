<?php
namespace App\DTOs;
class Result
{
    public bool $success;
    public string $msg;
    public mixed $data;

    public function __construct(bool $success, string $msg, mixed $data = null)
    {
        $this->success = $success;
        $this->msg = $msg;
        $this->data = $data;
    }

    // Métodos estáticos para crear respuestas fácilmente
    public static function success(string $msg, mixed $data = null): self
    {
        return new self(true, $msg, $data);
    }

    public static function error(string $msg, mixed $data = null): self
    {
        return new self(false, $msg, $data);
    }

    // Convertir a array para respuestas JSON
    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'msg' => $this->msg,
            'data' => $this->data,
        ];
    }
}

