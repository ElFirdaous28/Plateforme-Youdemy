<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        [x-cloak] {
            display: none;
        }

        .svg-icon {
            width: 1em;
            height: 1em;
        }

        .svg-icon path,
        .svg-icon polygon,
        .svg-icon rect {
            fill: #333;
        }

        .svg-icon circle {
            stroke: #4691f6;
            stroke-width: 1;
        }
    </style>

    <title>Youdemy Platform</title>
</head>

<body>
    <div class="flex">
        <?php include(__DIR__ . '/../partials/header.php'); ?>
        <!-- Main Content -->
        <div class="flex flex-col flex-1 lg:ml-64">
            <?php include(__DIR__ . '/../partials/sidebar.php'); ?>
            <!-- Main -->
            <main class="flex-1 bg-gray-100 min-h-screen overflow-y-auto py-24 px-20">
                <h1 class="text-xl font-bold text-gray-700 my-10">Add Course</h1>

                <!-- Buttons to select course type -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Add Video Course Box -->
                    <button id="btn-video" class="relative group bg-gray-200 p-10 rounded-lg shadow-md hover:shadow-lg hover:bg-gray-300">
                        <div class="absolute inset-0 bg-[url('https://cdn-icons-png.flaticon.com/512/3022/3022931.png')] bg-no-repeat bg-right-bottom bg-contain opacity-10"></div>
                        <div class="flex flex-col items-start space-y-4">
                            <i class="bx bx-video-plus text-5xl text-gray-700"></i>
                            <span class="text-xl font-bold text-gray-700">Add Video Course</span>
                        </div>
                    </button>

                    <!-- Add Document Course Box -->
                    <button id="btn-document" class="relative group bg-gray-200 p-10 rounded-lg shadow-md hover:shadow-lg hover:bg-gray-300">
                        <div class="absolute inset-0 bg-[url('https://cdn-icons-png.flaticon.com/512/3022/3022931.png')] bg-no-repeat bg-right-bottom bg-contain opacity-10"></div>
                        <div class="flex flex-col items-start space-y-4">
                            <i class="bx bx-file-plus text-5xl text-gray-700"></i>
                            <span class="text-xl font-bold text-gray-700">Add Document Course</span>
                        </div>
                    </button>
                </div>


                <!-- Forms -->
                <div class="mt-10">
                    <!-- Video Course Form -->
                    <form id="form-video" action="addvideocourse" method="POST" enctype="multipart/form-data" class="bg-white p-6 pb-12 rounded-md shadow-md hidden">
                        <h2 class="text-lg font-bold mb-4">Video Course Details</h2>
                        <?php include(__DIR__ . '/../partials/courseFormDetails.php.php'); ?>

                        <!-- video upload input -->
                        <div class="mb-4">
                            <label for="video_file" class="block text-gray-700">Upload Video</label>
                            <input id="video_file" name="video_file" type="file" class="w-full mt-1 p-2 border rounded-md" accept="video/*" required onchange="validateVideoFile(event)">
                        </div>

                        <button type="submit" class="float-right px-4 py-2 text-sm font-bold text-white bg-[#2E5077] border-2 border-[#2E5077] rounded transition hover:bg-transparent hover:text-[#2E5077]">
                            Submit Video Course
                        </button>
                    </form>

                    <!-- Document Course Form -->
                    <form id="form-document" action="adddocumentcourse" method="POST" enctype="multipart/form-data" class="bg-white p-6 pb-12 rounded-md shadow-md hidden">
                        <h2 class="text-lg font-bold mb-4">Document Course Details</h2>
                        <?php include(__DIR__ . '/../partials/courseFormDetails.php.php'); ?>

                        <!-- Document upload input -->
                        <div class="mb-4">
                            <label for="doc-file" class="block text-gray-700">Upload Document</label>
                            <input id="doc-file" name="document" type="file" class="w-full mt-1 p-2 border rounded-md" accept=".pdf,.doc,.docx" required onchange="validateDocumentFile(event)">
                        </div>

                        <button type="submit" class="float-right px-4 py-2 text-sm font-bold text-white bg-[#2E5077] border-2 border-[#2E5077] rounded transition hover:bg-transparent hover:text-[#2E5077]">
                            Submit Document Course
                        </button>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script>
        const btnVideo = document.getElementById('btn-video');
        const btnDocument = document.getElementById('btn-document');
        const formVideo = document.getElementById('form-video');
        const formDocument = document.getElementById('form-document');

        btnVideo.addEventListener('click', () => {
            formVideo.classList.remove('hidden');
            formDocument.classList.add('hidden');
        });

        btnDocument.addEventListener('click', () => {
            formDocument.classList.remove('hidden');
            formVideo.classList.add('hidden');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <script src="/assets/js/tags.js"></script>
</body>

</html>