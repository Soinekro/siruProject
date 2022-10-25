<!-- Formato de cambio de contraseña

(IMAGEN DE LA EMPRESA O SISTEMA)
Cambio de contraseña

Estimado/a usuario/a:

Hemos recibido una notificación de cambio de contraseña, para completar el proceso de cambio te pedimos ingresar con la siguiente contraseña temporal:
    #HASHHASH

Link : https://google.com/changepass

*Recuerda que al ingresar, se te solicitará cambiar tu contraseña nuevamente.

¡Muchas gracias, [Nombre de cliente]!

Atentamente,
Equipo de SiruProject

########3blablablblab

#banner de la empresa -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChangePass</title>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#f5f6fa">
            <tr>
               <td style="padding: 40px 0;">
                    <table style="width:100%;max-width:620px;margin:0 auto;">
                        <tbody>
                            <tr>
                                <td style="text-align: center; padding-bottom:25px">
                                    <a href="#"><img style="height: 40px" src="images/bannerconsigueventas.png" alt="logo"></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
<center style="width: 100%; background-color: #f5f6fa;">
<h1>Cambio de contraseña</h1>
<p><h4>Estimado/a usuario/a:</h4>

Hemos recibido una notificación de cambio de contraseña, para completar el proceso de cambio te pedimos ingresar con la siguiente contraseña</p>
   <div style="text-align:center; background-color:#ccc; padding: 10px 50px 10px;">{{ $password }}</div>

<p style="font-weight:bold;">*Recuerda que al ingresar, se te solicitará cambiar tu contraseña nuevamente*</p>
<p>¡Muchas gracias, {{ $user->name_complete() }}!<br>

Atentamente,
Equipo de SiruProjectt</p>

</center>
</body>
</html>




