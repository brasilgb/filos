    <div class="bg-gray-800 text-gray-600 mx-auto w-[210.1mm] h-[297mm]">
      
        <main class="ml-[5.7mm] mt-[12.5mm] bg-white">
            <section class="w-full flex flex-row flex-wrap items-start grow-1">
                @for ($x = $tagi; $x <= $tagf; $x++)
                    <div class="w-[33mm] h-[17mm] border border-gray-800 flex flex-col items-center justify-around">
                        <div class="text-[8]">
                            {{ $company->shortname }}
                        </div>
                        <div class="text-[12] font-bold">
                            {{ $x }}
                        </div>
                        <div class="text-[8]">
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