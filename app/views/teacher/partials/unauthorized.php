<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen">
    <div class="text-center bg-red-200 border border-red-400 text-red-700 p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-4">Access Denied</h1>
        <p class="text-lg mb-6">You do not have permission to access this page.</br>Or page does not exist</p>
        <button onclick="history.back()" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">
            Go Back
        </button>        
    </div>
</body>
</html>
