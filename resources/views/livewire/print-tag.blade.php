<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir com Parâmetros</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body>
    <div class="w-[210mm] h-[297mm] mx-auto">
        <main class="bg-white ml-[5.7mm] mt-[12.5mm] pb-[12.5mm]">
            <a href="/admin/tag-page" class="print:hidden">
                Fechar
            </a>

            <section class="w-full flex flex-row items-start justify-start flex-wrap flex-grow-1 {{ $nump > 1 ? 'break-after-page' : '' }}">
                @for ($x = $tagi; $x <= $tagf; $x++)
                    <div class="w-[33mm] h-[17mm] py-1.5 border border-gray-2 flex flex-col items-center justify-around">
                        <div class="text-[12px]">
                            {{ $company->empresa }}
                        </div>
                        <div class="text-[12px] font-bold">
                            {{ $x }}
                        </div>
                        <div class="text-[12px]">
                            {{ $company->telefone }}
                        </div>
                    </div>
                @endfor
            </section>
        </main>
    </div>



    <script>
        window.onload = function() {
            window.print();
            // Opcional: Fechar a janela após a impressão
            window.onafterprint = function() {
                window.close();
            };
        };
    </script>
</body>

</html>
