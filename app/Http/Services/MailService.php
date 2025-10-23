<?php
namespace App\Http\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailService {
    /**
     * Envía un correo electrónico utilizando una plantilla Blade
     *
     * @param string $email Dirección de correo electrónico del destinatario
     * @param string $subject Asunto del correo electrónico
     * @param string $template Ruta de la plantilla Blade (ej: 'emails.welcome')
     * @param mixed $data Datos que se pasarán a la plantilla
     * @param bool $mustSend Si es true, lanza excepción en caso de error; si es false, solo retorna false
     * @return bool Retorna true si el correo se envió exitosamente, false en caso contrario
     * @throws Exception Si mustSend es true y ocurre un error en el envío
     */
    public function sendMail(
        string $email,
        string $subject,
        string $template,
        mixed $data,
        bool $mustSend = false
    ): bool {
        try {
            // Enviar el correo usando la facade Mail de Laravel
            Mail::send($template, $data, function($message) use ($email, $subject) {
                // Establecer el destinatario del correo
                $message->to($email);

                // Establecer el asunto del correo si está definido
                if (isset($subject)) {
                    $message->subject($subject);
                }
            });

            // Verificar si hubo fallos en el envío del correo
            if (count(Mail::failures()) > 0) {
                // Lanzar excepción si el envío falló
                throw new Exception('Error al enviar el correo a: ' . $email);
            }

            // Registrar en el log que el correo se envió exitosamente
            Log::info('Correo enviado exitosamente', [
                'email' => $email,
                'template' => $template
            ]);

            // Retornar true indicando éxito en el envío
            return true;
        } catch (Exception $e) {
            // Registrar el error en el log con detalles del fallo
            Log::error('Error al enviar correo', [
                'email' => $email,
                'template' => $template,
                'error' => $e->getMessage()
            ]);

            // Si mustSend es true, relanzar la excepción para manejo superior
            if ($mustSend) {
                throw $e;
            }

            // Retornar false indicando fallo en el envío
            return false;
        }
    }
}
