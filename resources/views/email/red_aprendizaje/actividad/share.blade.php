<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación de Actividad - Red aprendizaje</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f4f4f4;">
<table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f4f4f4;">
    <tr>
        <td style="padding: 20px 0;">
            <table role="presentation" style="width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border-collapse: collapse;">
                <!-- Header -->

                <!-- Saludo -->
                <tr>
                    <td style="padding: 30px 30px 20px 30px;">
                        <p style="margin: 0 0 15px 0; color: #333333; font-size: 16px; line-height: 1.6;">
                            Estimad@ {{$nombre}},
                        </p>
                        <p style="margin: 0; color: #333333; font-size: 16px; line-height: 1.6;">
                            Le informamos que ha sido notificado(a) en relación con una actividad asociada a una red de aprendizaje:
                        </p>
                    </td>
                </tr>

                <!-- Mensaje personalizado -->
                <tr>
                    <td style="padding: 0 30px 20px 30px;">
                        <div style="background-color: #eaf2fb; border-left: 4px solid #2980b9; padding: 20px; margin: 0;">
                            <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td style="width: 40px; vertical-align: top;">
                                        <span style="color: #1c5a85; font-size: 24px;">✉️</span>
                                    </td>
                                    <td style="vertical-align: top;">
                                        <h2 style="margin: 0 0 10px 0; color: #1c5a85; font-size: 16px; font-weight: bold;">Mensaje</h2>
                                        <p style="margin: 0; color: #1c5a85; font-size: 15px; line-height: 1.6;">
                                            {{$mensaje}}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>

                <!-- Datos de la red de aprendizaje -->
                <tr>
                    <td style="padding: 0 30px 20px 30px;">
                        <h2 style="margin: 0 0 15px 0; color: #2c3e50; font-size: 18px; font-weight: bold;">Red de aprendizaje</h2>
                        <table role="presentation" style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="padding: 15px; background-color: #f8f9fa; border-left: 3px solid #2980b9;">
                                    <p style="margin: 0 0 8px 0; color: #2c3e50; font-size: 15px; line-height: 1.5;">
                                        <strong>Nombre:</strong> {{data_get($redAprendizaje,'nombre')}}
                                    </p>
                                    <p style="margin: 0; color: #333333; font-size: 15px; line-height: 1.6;">
                                        <strong>Descripción:</strong> {{data_get($redAprendizaje,'descripcion')}}
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Datos de la Actividad -->
                <tr>
                    <td style="padding: 0 30px 30px 30px;">
                        <h2 style="margin: 0 0 15px 0; color: #2c3e50; font-size: 18px; font-weight: bold;">Actividad</h2>
                        <table role="presentation" style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="padding: 15px; background-color: #f8f9fa; border-left: 3px solid #27ae60;">
                                    <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                        <tr>
                                            <td style="width: 40px; vertical-align: top;">
                                                <span style="color: #27ae60; font-size: 24px;">📝</span>
                                            </td>
                                            <td style="vertical-align: top; padding-left: 15px;">
                                                <p style="margin: 0; color: #333333; font-size: 15px; line-height: 1.6;">
                                                    {{data_get($actividad,'descripcion')}}
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding: 0 30px 30px 30px;">
                        <p style="margin: 0 0 15px 0; color: #333333; font-size: 15px; line-height: 1.6;">
                            Si tiene alguna duda o requiere asistencia, no dude en contactarnos.
                        </p>
                        <p style="margin: 0; color: #333333; font-size: 15px; line-height: 1.6;">
                            Atentamente,<br>
                            <strong>Equipo de dirección de calidad educativa</strong>
                            <br>
                            <strong>Secretaría de educación departamental del quindío</strong>
                        </p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background-color: #34495e; padding: 20px 30px; text-align: center;">
                        <p style="margin: 0 0 10px 0; color: #ecf0f1; font-size: 13px; line-height: 1.5;">
                            Este es un correo automático del sistema de gestión de proyectos transversales.<br>
                            Por favor, no responda a este mensaje.
                        </p>
                        <p style="margin: 0; color: #95a5a6; font-size: 12px;">
                            © 2025 - Todos los derechos reservados
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
