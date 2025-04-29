    <div class="bg-gray-white text-gray-600 container mx-auto shadow">
        <a href="/admin/tag-page" class="print:hidden">
            Fechar
        </a>
        <main class="w-[210mm] h-[297mm]">
            <section class="w-full flex flex-row flex-wrap items-start grow-1 ml-[5.7mm] mt-[12.5mm] pb-[12.5mm]">
                @for ($x = $tagi; $x <= $tagf; $x++)
                    <div class="w-[33mm] h-[17mm] py-[1.5mm] border flex flex-col items-center justify-start">
                        <div class="text-xs">
                            {{ $company->shortname }}
                        </div>
                        <div class="text-lg font-bold">
                            {{ $x }}
                        </div>
                        <div class="text-sm">
                            {{ $company->telephone }}
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