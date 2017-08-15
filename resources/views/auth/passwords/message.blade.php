<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Redefini&ccedil;&atilde;o de senha</title>
</head>
<body>
<table border="0" align="center" style="font-family: Arial, Helvetica, sans-serif; font-color: #2A3F54;">
    <tr>
        <td style="background: #2A3F54;">
            <img src="{{ asset('images/if5-logo.jpg') }}" width="120" alt="IF5" style="float: left;">
            <h2 style="float: left; color: #FFFFFF; padding: 0px 30px;">
                Redefini&ccedil;&atilde;o de senha
            </h2>
        </td>
    </tr>
    <tr>
        <td style="border: dashed #73879C 2px; padding: 20px; color: #2A3F54;">
            <h4>Olá {{ $name }},</h4>
            <p>Você está recebendo este e-mail porque recebemos um pedido de redefinição de senha para sua conta.</p>
            <p>
                <a href="{{ $link }}" style="color: #2A3F54;">
                    <strong>Clique aqui para redefinir sua senha:</strong>
                </a>
            </p>
            <p>
                <small>Se você não solicitou uma redefini&ccedil;&atilde;o de senha, desconsidere este e-mail.</small>
            </p>
        </td>
    </tr>
</table>
</body>
</html>

