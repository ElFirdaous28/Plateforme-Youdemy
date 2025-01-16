<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Youdemy Platform</title>
</head>

<body>
    <div class="flex">
        <!-- Main Content -->
        <div class="flex flex-col flex-1">
            <!-- Header -->
            <header class="fixed w-full flex items-center justify-between px-4 py-4 bg-gray-50 shadow lg:py-6 z-30">
                <a href="/" class="flex items-center justify-center h-5">
                    <img src="/assets/images/logo.png" alt="logo" class="w-32" />
                </a>
                <div class="flex items-center space-x-4">
                    <a href="/login" class="text-[#2E5077] hover:underline font-semibold">Login</a>
                    <a href="/register" class="px-4 py-2 text-sm font-bold text-white bg-[#2E5077] border-2 border-[#2E5077] rounded transition hover:bg-transparent hover:text-[#2E5077]">Sign Up</a>
                </div>
            </header>

            <!-- Main -->
            <main class="flex-1 bg-gray-100 min-h-screen overflow-y-auto pt-24 px-20">
                <h1 class="text-xl font-semibold">Main Content</h1>
                <p>This is the main content section. It has an overflow so that when the content is too long, it will scroll.</p>
            </main>
        </div>
    </div>
</body>

</html>