<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devolución Plan de Mejoramiento Institucional</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f4f4f4;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f4f4f4;">
        <tr>
            <td style="padding: 20px 0;">
                <table role="presentation" style="width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border-collapse: collapse;">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #e74c3c; padding: 30px 20px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: bold;">Plan de Mejoramiento Institucional</h1>
                            <p style="margin: 10px 0 0 0; color: #ffffff; font-size: 16px;">PMI Remitido para ajuste
                        </td>
                    </tr>

                    <!-- Saludo -->
                    <tr>
                        <td style="padding: 30px 30px 20px 30px;">
                            <p style="margin: 0 0 15px 0; color: #333333; font-size: 16px; line-height: 1.6;">
                                Estimad@ {{$usuario->name}} ,
                            </p>
                            <p style="margin: 0; color: #333333; font-size: 16px; line-height: 1.6;">
                                Le informamos que su <strong>Plan de Mejoramiento Institucional (PMI)</strong> con vigencia desde {{$pmi->anio_inicio}} hasta {{$pmi->anio_fin}} ha sido revisado y <strong>remitido</strong> para que realice los ajustes necesarias.
                            </p>
                        </td>
                    </tr>

                    <!-- Alerta de Comentarios -->
                    <tr>
                        <td style="padding: 0 30px 20px 30px;">
                            <div style="background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 20px; margin: 0;">
                                <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="width: 40px; vertical-align: top;">
                                            <span style="color: #856404; font-size: 28px; font-weight: bold;">⚠</span>
                                        </td>
                                        <td style="vertical-align: top;">
                                            <h2 style="margin: 0 0 10px 0; color: #856404; font-size: 18px; font-weight: bold;">Comentarios pendientes de atención</h2>
                                            <p style="margin: 0; color: #856404; font-size: 15px; line-height: 1.6;">
                                                Se han registrado <strong style="font-size: 18px;">{{$cantidadComentariosPendientes}} observaciones</strong> que requieren su atención inmediata.
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <!-- Instrucciones -->
                    <tr>
                        <td style="padding: 0 30px 20px 30px;">
                            <h2 style="margin: 0 0 20px 0; color: #2c3e50; font-size: 18px; font-weight: bold;">Acciones a realizar:</h2>

                            <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td style="padding: 15px; background-color: #f8f9fa; border-left: 3px solid #3498db; margin-bottom: 10px;">
                                        <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="width: 40px; vertical-align: top;">
                                                    <div style="background-color: #3498db; color: #ffffff; width: 30px; height: 30px; border-radius: 50%; text-align: center; line-height: 30px; font-weight: bold; font-size: 16px;">1</div>
                                                </td>
                                                <td style="vertical-align: top; padding-left: 15px;">
                                                    <p style="margin: 0; color: #333333; font-size: 15px; line-height: 1.5;">
                                                        <strong style="color: #2c3e50;">Ingrese al aplicativo</strong><br>
                                                        Acceda al sistema con sus credenciales habituales.
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 10px;"></td>
                                </tr>
                                <tr>
                                    <td style="padding: 15px; background-color: #f8f9fa; border-left: 3px solid #3498db;">
                                        <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="width: 40px; vertical-align: top;">
                                                    <div style="background-color: #3498db; color: #ffffff; width: 30px; height: 30px; border-radius: 50%; text-align: center; line-height: 30px; font-weight: bold; font-size: 16px;">2</div>
                                                </td>
                                                <td style="vertical-align: top; padding-left: 15px;">
                                                    <p style="margin: 0; color: #333333; font-size: 15px; line-height: 1.5;">
                                                        <strong style="color: #2c3e50;">Revise los comentarios</strong><br>
                                                        Lea cuidadosamente cada observación realizada.
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 10px;"></td>
                                </tr>
                                <tr>
                                    <td style="padding: 15px; background-color: #f8f9fa; border-left: 3px solid #3498db;">
                                        <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="width: 40px; vertical-align: top;">
                                                    <div style="background-color: #3498db; color: #ffffff; width: 30px; height: 30px; border-radius: 50%; text-align: center; line-height: 30px; font-weight: bold; font-size: 16px;">3</div>
                                                </td>
                                                <td style="vertical-align: top; padding-left: 15px;">
                                                    <p style="margin: 0; color: #333333; font-size: 15px; line-height: 1.5;">
                                                        <strong style="color: #2c3e50;">Atienda las observaciones</strong><br>
                                                        Realice los ajustes solicitados en su PMI.
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 10px;"></td>
                                </tr>
                                <tr>
                                    <td style="padding: 15px; background-color: #f8f9fa; border-left: 3px solid #27ae60;">
                                        <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="width: 40px; vertical-align: top;">
                                                    <div style="background-color: #27ae60; color: #ffffff; width: 30px; height: 30px; border-radius: 50%; text-align: center; line-height: 30px; font-weight: bold; font-size: 16px;">4</div>
                                                </td>
                                                <td style="vertical-align: top; padding-left: 15px;">
                                                    <p style="margin: 0; color: #333333; font-size: 15px; line-height: 1.5;">
                                                        <strong style="color: #27ae60;">Vuelva a presentar el PMI</strong><br>
                                                        Una vez realizados los ajustes, haga clic en el botón "Presentar".
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Nota Importante -->
                    <tr>
                        <td style="padding: 0 30px 30px 30px;">
                            <div style="background-color: #e8f4f8; border-left: 4px solid #17a2b8; padding: 20px; margin: 0;">
                                <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="width: 30px; vertical-align: top;">
                                            <span style="color: #17a2b8; font-size: 20px; font-weight: bold;">ℹ</span>
                                        </td>
                                        <td style="vertical-align: top; padding-left: 10px;">
                                            <h3 style="margin: 0 0 10px 0; color: #17a2b8; font-size: 16px; font-weight: bold;">Nota importante</h3>
                                            <p style="margin: 0; color: #0c5460; font-size: 14px; line-height: 1.6;">
                                                Es fundamental que atienda todos los comentarios antes de volver a presentar el documento. De lo contrario, su PMI podría ser remitido nuevamente.
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <!-- CTA Button -->
                    <tr>
                        <td style="padding: 0 30px 30px 30px; text-align: center;">
                            <table role="presentation" style="margin: 0 auto; border-collapse: collapse;">
                                <tr>
                                    <td style="background-color: #28a745; padding: 15px 40px; border-radius: 5px;">
                                        <a href="#" style="color: #ffffff; text-decoration: none; font-size: 16px; font-weight: bold; display: block;">Ajustar PMI</a>
                                    </td>
                                </tr>
                            </table>
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
                                Este es un correo automático.<br>
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
