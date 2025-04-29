const styles = StyleSheet.create({
page: {
backgroundColor: "#ffffff",
color: "#3f3f3f",
marginLeft: '5.7mm',
marginTop: '12.5mm',
paddingBottom: '12.5mm',
},
section: {
width: '100%',
display: 'flex',
flexDirection: 'row',
flexWrap: 'wrap',
alignItems: 'flex-start',
// margin: 10,
// padding: 10,
flexGrow: 1,
},
etiqueta: {
width: '33mm',
height: '17mm',
// marginRight: '2mm',
// marginBottom: '0.5mm',
paddingVertical: '1.5mm',
border: 1,
borderColor: "#fff",
textAlign: 'center',
alignItems: 'center',
display: 'flex',
flexDirection: 'column',
justifyContent: 'space-around'
},
textmd: {
fontSize: 12,
fontWeight: 'bold',
},
textxs: {
fontSize: 8,
},
viewer: {
width: window.innerWidth, //the pdf viewer will take up all of the width and height
height: window.innerHeight,
},
});


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir com Parâmetros</title>
    <style>
        .page {
            size: A4;
            margin: 0;
            background-color: "#ffffff";
            color: "#3f3f3f";
            margin-left: '5.7mm';
            margin-top: '12.5mm';
            padding-bottom: '12.5mm';
        }

        .section {
            width: '100%';
        }

        .etiqueta {
            width: '33mm';
            height: '17mm';
            padding-top: '1.5mm';
            padding-bottom: '1.5mm';
            border: 1;
            border-color: "#fff";
            text-align: 'center';
            align-items: 'center';
            background-color: "#000";
        }

        .textmd {
            font-size: 12;
            font-weight: 'bold';
        }

        .textxs {
            font-size: 8;
        }
    </style>
</head>

<body>
    <div class="w-[210mm] mx-auto">
        <a href="/admin/tag-page">
            Fechar
        </a>
        <main class="page">
            <section class="section">
                @for ($x = $tagi; $x <= $tagf; $x++)
                    <div class="etiqueta">
                        <div class="textsm">
                            {{ $company->shortname }}
                        </div>
                        <div class="textmd">
                            {{ $x }}
                        </div>
                        <div class="textsm">
                            {{ $company->telephone }}
                        </div>
                    </div>
                @endfor
            </section>
        </main>
    </div>
</body>

</html>
