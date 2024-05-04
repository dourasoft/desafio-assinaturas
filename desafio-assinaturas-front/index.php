<?php require_once __DIR__ . "/config/autoload.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_ENV["APP_NAME"] ?></title>
    <link rel="stylesheet" href="/assets/css/tailwind.css">
    <link rel="icon" href="https://dourasoft.com.br/wp-content/uploads/2017/08/cropped-DouraSoft_Favicon-32x32.png" sizes="32x32">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/assets/js/scripts.js"></script>
</head>

<body class="h-screen overflow-hidden flex items-center justify-center" style="background: #c4d5ef;">
    <div class="min-h-screen flex flex-col justify-center sm:py-12">
        <div class="spin_load">
            <div class="spin_load_box">
                <div class="spin_load_circle">
                </div>
            </div>
        </div>
        <div class="p-10 xs:p-0 mx-auto md:w-full md:max-w-md">
            <h1 class="font-bold text-center text-2xl mb-5"><?= $_ENV["TITLE_NAME"] ?></h1>
            <div class="bg-white shadow w-full rounded-lg divide-y divide-gray-200">
                <?php if (!isset($session->token)) : ?>
                    <div class="px-5 py-7">
                        <label class="font-semibold text-sm text-gray-600 pb-1 block">E-mail</label>
                        <input type="email" name="email" id="email" class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />
                        <label class="font-semibold text-sm text-gray-600 pb-1 block">Password</label>
                        <input type="password" name="password" id="password" class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />
                        <button type="button" onclick="login()" class="btn_login transition duration-200 bg-blue-500 hover:bg-blue-800 focus:bg-blue-700 focus:shadow-sm focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50 text-white w-full py-2.5 rounded-lg text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block">
                            <span class="inline-block mr-2">Login</span>
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 inline-block">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </button>
                    </div>
                <?php endif; ?>
                <div class="py-5">
                    <?php if (isset($session->token)) : ?>
                        <div class="text-center sm:text-left whitespace-nowrap">
                            <a href="/src/index.php">
                                <button class="transition duration-200 mx-5 px-5 py-4 cursor-pointer font-normal text-sm rounded-lg text-gray-500 hover:bg-gray-200 focus:outline-none focus:bg-gray-300 focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 ring-inset">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 inline-block align-text-top">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    <span class="inline-block ml-1">Return to List</span>
                                </button>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="grid grid-cols-1 gap-1">
                        <div class="text-center whitespace-nowrap">
                            <div class="box_message whitespace-normal hidden">
                                <span class="break-words message_validation text-red-500 text-md inline-block ml-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>