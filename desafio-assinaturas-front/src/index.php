<?php
require_once __DIR__ . "/../config/autoload.php";

if (!isset($session->token) || empty($session->token)) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_ENV["APP_NAME"] ?></title>
    <link rel="stylesheet" href="/assets/css/tailwind.css">
    <link rel="icon" href="https://dourasoft.com.br/wp-content/uploads/2017/08/cropped-DouraSoft_Favicon-32x32.png" sizes="32x32">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/assets/js/scripts.js"></script>
    <!-- <script src="/assets/js/jquery_mask.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

    <script>
        $(function() {
            $("#tabs").tabs();

            /* $(".mask-money").mask("000.000.000.000.000,00", {
                reverse: true,
                placeholder: "0,00"
            }); */

            $('.maskMoney').maskMoney({
                prefix: 'R$ ',
                thousands: '.',
                decimal: ','
            });
        });
    </script>
</head>

<body class="w-full bg-blue-50">

    <article class="w-full grid grid-cols-1 justify-center p-8">

        <div class="spin_load">
            <div class="spin_load_box">
                <div class="spin_load_circle">
                </div>
            </div>
        </div>

        <div class="w-auto justify-center text-center whitespace-nowrap">
            <button onclick="logout()" class="transition duration-200 px-5 py-4 cursor-pointer font-normal text-sm rounded-lg text-gray-500 hover:text-white hover:bg-blue-300 focus:outline-none focus:bg-blue-200 focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 ring-inset">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 inline-block align-text-top text-blue-500 hover:bg-white">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                </svg>
                <span class="inline-block ml-1"><?= $session->name ?> - <?= $session->email ?> - <strong>Sair?</strong></span>
            </button>
        </div>

        <div class="w-full text-center">
            <h1 class="text-2xl lg:text-md font-bold text-secundary text-center pb-4"><?= $_ENV["TITLE_NAME"] ?></label>
        </div>

        <div class="w-5/6 lg:w-full m-auto justify-center bg-red-100" id="tabs" style="display: block !important">
            <ul>
                <li><a href="#tabs-1">Cadastros</a></li>
                <li><a href="#tabs-2">Assinaturas</a></li>
                <li><a href="#tabs-3">Faturas</a></li>
            </ul>
            <div id="tabs-1">
                <div class="w-auto flex justify-start items-center space-x-2 my-4">
                    <h1 class="font-bold text-center text-2xl">Novo</h1>
                    <button title="Novo registro" type="button" onclick="formularioCadastros()">
                        <svg viewBox="0 0 24 24" fill="#156805" class="w-6 h-6 hover:opacity-50">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <?php require_once __DIR__ . "/cadastros/index.php"; ?>
            </div>
            <div id="tabs-2">
                <div class="w-auto flex justify-start items-center space-x-2 my-4">
                    <h1 class="font-bold text-center text-2xl">Novo</h1>
                    <button title="Novo registro" type="button" onclick="formularioAssinaturas()">
                        <svg viewBox="0 0 24 24" fill="#156805" class="w-6 h-6 hover:opacity-50">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <?php require_once __DIR__ . "/assinaturas/index.php"; ?>
            </div>
            <div id="tabs-3">
                <div class="w-auto flex justify-start items-center space-x-2 my-4">
                    <h1 class="font-bold text-center text-2xl">Novo</h1>
                    <button title="Novo registro" type="button" onclick="formularioFaturas()">
                        <svg viewBox="0 0 24 24" fill="#156805" class="w-6 h-6 hover:opacity-50">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <?php require_once __DIR__ . "/faturas/index.php"; ?>
            </div>
        </div>

    </article>

</body>

</html>