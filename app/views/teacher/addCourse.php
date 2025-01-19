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
                <div id="buttons_box" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Add Video Course Box -->
                    <button id="btn-video" class="relative group bg-gray-200 p-10 rounded-lg shadow-md hover:shadow-lg hover:bg-gray-300">
                        <div class="absolute inset-0 bg-[url('https://cdn-icons-png.flaticon.com/512/7359/7359402.png')] bg-no-repeat bg-right-bottom bg-contain opacity-10"></div>
                        <div class="flex flex-col items-start space-y-4">
                            <i class="bx bx-video-plus text-5xl text-gray-700"></i>
                            <span class="text-xl font-bold text-gray-700">Add Video Course</span>
                        </div>
                    </button>

                    <!-- Add Document Course Box -->
                    <button id="btn-document" class="relative group bg-gray-200 p-10 rounded-lg shadow-md hover:shadow-lg hover:bg-gray-300">
                        <div class="absolute inset-0 bg-[url('https://cdn-icons-png.flaticon.com/512/2704/2704034.png')] bg-no-repeat bg-right-bottom bg-contain opacity-10"></div>
                        <div class="flex flex-col items-start space-y-4">
                            <i class="bx bx-file-plus text-5xl text-gray-700"></i>
                            <span class="text-xl font-bold text-gray-700">Add Document Course</span>
                        </div>
                    </button>
                </div>

                <div class="mt-10">
                    <!-- Single Course Form -->
                    <form id="course-form" action="/teacher/SubmitAddCourse" method="POST" enctype="multipart/form-data" class="bg-white p-6 pb-12 rounded-md shadow-md hidden">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token); ?>">
                        <h2 id="form-title" class="text-lg font-bold mb-4">Course Details</h2>
                        <?php include(__DIR__ . '/../partials/courseFormDetails.php'); ?>

                        <!-- File upload section -->
                        <div class="mb-4" id="file-upload-section">
                            <label id="file-label" for="file-input" class="block text-gray-700">Upload File</label>
                            <input id="file-input" name="content" type="file" class="w-full mt-1 p-2 border rounded-md" required>
                        </div>

                        <input id="content-type" type="hidden" name="content_type" value="video">
                        <button type="submit" class="float-right px-4 py-2 text-sm font-bold text-white bg-[#2E5077] border-2 border-[#2E5077] rounded transition hover:bg-transparent hover:text-[#2E5077]">
                            Submit Course
                        </button>
                    </form>

                </div>

            </main>
        </div>
    </div>

    <script>
        const btnVideo = document.getElementById('btn-video');
        const btnDocument = document.getElementById('btn-document');
        const courseForm = document.getElementById('course-form');
        const formTitle = document.getElementById('form-title');
        const fileLabel = document.getElementById('file-label');
        const fileInput = document.getElementById('file-input');
        const contentType = document.getElementById('content-type');

        // Function to show the form and update its content
        const showForm = (title, label, accept, contentTypeValue) => {
            formTitle.textContent = title;
            fileLabel.textContent = label;
            fileInput.accept = accept;
            contentType.value = contentTypeValue;
            courseForm.classList.remove('hidden'); // Show the form
            document.getElementById("buttons_box").classList.add("hidden");
        };

        btnVideo.addEventListener('click', () => {
            showForm("Video Course Details", "Upload Video", "video/*", "video");
        });

        btnDocument.addEventListener('click', () => {
            showForm("Document Course Details", "Upload Document", ".pdf,.doc,.docx", "document");
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <script src="/assets/js/tags.js"></script>
</body>

</html>