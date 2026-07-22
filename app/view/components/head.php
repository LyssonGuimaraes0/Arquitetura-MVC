<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lentes Livres - Manager</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!--Define rota padrão para JS-->
    <script>
        // O PHP imprime a rota diretamente dentro do objeto global do JS
        window.env = {
            ROTA_RAIZ: "<?php echo $_ENV['RAIZ_URL']; ?>"
        };

        //Variavel Global JS de raiz
        const URLBASE = window.env.ROTA_RAIZ;
    </script>

</head>