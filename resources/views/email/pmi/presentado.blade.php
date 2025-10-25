<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan de Mejoramiento Institucional Presentado</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f4f4f4;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f4f4f4;">
        <tr>
            <td style="padding: 20px 0;">
                <table role="presentation" style="width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border-collapse: collapse;">

                    <!-- Header -->
                    <tr>
                        <td style="background-color: #f39c12; padding: 30px 20px; text-align: center;">
                            <div style="font-size: 48px; margin-bottom: 10px;">📄</div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: bold;">Plan de Mejoramiento Institucional</h1>
                            <p style="margin: 10px 0 0 0; color: #ffffff; font-size: 18px; font-weight: bold;">¡PRESENTADO!</p>
                        </td>
                    </tr>

                    <!-- Saludo -->
                    <tr>
                        <td style="padding: 30px 30px 20px 30px;">
                            <p style="margin: 0 0 15px 0; color: #333333; font-size: 16px; line-height: 1.6;">
                                Estimad@ {{ $notificado?->name }},
                            </p>
                            <p style="margin: 0; color: #333333; font-size: 16px; line-height: 1.6;">
                                El rector <strong>{{ $rector->name }}</strong> ha <strong style="color: #f39c12;">PRESENTADO</strong> el <strong>Plan de Mejoramiento Institucional (PMI)</strong> correspondiente al periodo <strong>{{ $pmi->anio_inicio }} - {{ $pmi->anio_fin }}</strong>.
                            </p>
                        </td>
                    </tr>

                    <!-- Alerta de acción requerida -->
                    <tr>
                        <td style="padding: 0 30px 20px 30px;">
                            <div style="background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 20px; margin: 0;">
                                <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="width: 40px; vertical-align: top;">
                                            <span style="color: #856404; font-size: 28px;">⚠️</span>
                                        </td>
                                        <td style="vertical-align: top;">
                                            <h2 style="margin: 0 0 10px 0; color: #856404; font-size: 18px; font-weight: bold;">Acción requerida</h2>
                                            <p style="margin: 0; color: #856404; font-size: 15px; line-height: 1.6;">
                                                Por favor, ingrese a la plataforma para <strong>validar el PMI presentado</strong> y verificar que cumple con los criterios necearios.
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <!-- Detalles del PMI -->
                    <tr>
                        <td style="padding: 0 30px 20px 30px;">
                            <h2 style="margin: 0 0 15px 0; color: #2c3e50; font-size: 18px; font-weight: bold;">Detalles del PMI</h2>
                            <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f8f9fa;">
                                <tr>
                                    <td style="padding: 10px 15px; border-bottom: 1px solid #ddd; font-size: 15px;">
                                        <strong>Rector:</strong> {{ $rector->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 15px; border-bottom: 1px solid #ddd; font-size: 15px;">
                                        <strong>Vigencia:</strong> {{ $pmi->anio_inicio }} - {{ $pmi->anio_fin }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 15px; font-size: 15px;">
                                        <strong>Estado actual:</strong> <span style="color: #f39c12; font-weight: bold;">Presentado</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- CTA -->
                    <tr>
                        <td style="padding: 0 30px 30px 30px; text-align: center;">
                            <table role="presentation" style="margin: 0 auto; border-collapse: collapse;">
                                <tr>
                                    <td style="background-color: #f39c12; padding: 15px 40px; border-radius: 5px;">
                                        <a href="{{ asset('/') }}" style="color: #ffffff; text-decoration: none; font-size: 16px; font-weight: bold; display: block;">
                                            Ir a validar PMI
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Recordatorio -->
                    <tr>
                        <td style="padding: 0 30px 30px 30px;">
                            <div style="background-color: #e8f4f8; border-left: 4px solid #17a2b8; padding: 20px;">
                                <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="width: 30px; vertical-align: top;">
                                            <span style="color: #17a2b8; font-size: 20px;">ℹ️</span>
                                        </td>
                                        <td style="vertical-align: top; padding-left: 10px;">
                                            <h3 style="margin: 0 0 10px 0; color: #17a2b8; font-size: 16px; font-weight: bold;">Recordatorio</h3>
                                            <p style="margin: 0; color: #0c5460; font-size: 14px; line-height: 1.6;">
                                                Los PMIs presentados deben ser revisados oportunamente para garantizar la continuidad del proceso institucional de mejora.
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <!-- Despedida -->
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
                                Este es un correo automático del sistema de gestión de PMI.<br>
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

