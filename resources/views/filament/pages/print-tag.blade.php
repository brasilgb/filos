<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir com Parâmetros</title>
    <style>
        /* Estilos CSS para impressão */
        body {
            font-family: sans-serif;
        }

        /* Adicione mais estilos conforme necessário */
    </style>
</head>

<body>
    <h1>Dados do Formulário para Impressão</h1>

    @if (count($dataForm) > 0)
        <ul>
            @foreach ($dataForm as $key => $value)
                <li><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</li>
            @endforeach
        </ul>
    @else
        <p>Nenhum dado do formulário foi recebido.</p>
    @endif

    <script>
        window.onload = function() {
            window.print();
            // Opcional: Fechar a janela após a impressão
            // window.onafterprint = function() {
            //     window.close();
            // };
        };
    </script>
</body>

</html>
