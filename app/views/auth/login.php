<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Login</title>
</head>

<body>
    <!-- https://play.tailwindcss.com/MIwj5Sp9pw -->
    <div class="py-16 mt-[5%]">
        <div class="flex bg-white rounded-lg shadow-lg overflow-hidden mx-auto max-w-sm lg:max-w-4xl">
            <div class="hidden lg:block lg:w-1/2 bg-cover"
                style="background-image:url('https://i.pinimg.com/736x/26/18/08/261808461189f1a8820b97d650127a9a.jpg')">
            </div>
            <div class="w-full p-8 lg:w-1/2">
                <h2 class="text-2xl font-semibold text-gray-700 text-center">Brand</h2>
                <p class="text-xl text-gray-600 text-center">Welcome back!</p>
                <form action="/handleLogin" method="POST">
                    <div class="mt-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                        <input
                            name="email"
                            class="bg-gray-200 text-gray-700 focus:outline-none focus:shadow-outline border border-gray-300 rounded py-2 px-4 block w-full appearance-none"
                            type="email" />
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                        </div>
                        <input
                            name="password"
                            class="bg-gray-200 text-gray-700 focus:outline-none focus:shadow-outline border border-gray-300 rounded py-2 px-4 block w-full appearance-none"
                            type="password" />
                    </div>
                    <?php
                    if (isset($_SESSION["login_error"])) {
                        echo '<div class="text-red-500">' . htmlspecialchars($_SESSION["login_error"]) . '</div>';
                        unset($_SESSION["login_error"]);
                    }
                    ?>

                    <div class="mt-8">
                        <button type="submit" name="login"
                            class="bg-gray-700 text-white font-bold py-2 px-4 w-full rounded hover:bg-gray-600">Login</button>
                    </div>
                </form>
                <div class="mt-4 flex items-center justify-between">
                    <span class="border-b w-1/5 md:w-1/4"></span>
                    <a href="/register" class="text-xs text-gray-500 uppercase">or sign up</a>
                    <span class="border-b w-1/5 md:w-1/4"></span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>