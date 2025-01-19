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

    <title>Youdemy Platform - Edit Course</title>
</head>

<body>
    <div class="flex">
        <?php include(__DIR__ . '/../partials/header.php'); ?>
        <!-- Main Content -->
        <div class="flex flex-col flex-1 lg:ml-64">
            <?php include(__DIR__ . '/../partials/sidebar.php'); ?>
            <!-- Main -->
            <main class="flex-1 bg-gray-100 min-h-screen overflow-y-auto py-24 px-20">
                <h1 class="text-xl font-bold text-gray-700 my-10 capitalize">Edit Course - <?= htmlspecialchars($course['content_type']) ?></h1>

                <div class="mt-10">
                    <!-- Edit Course Form -->
                    <form id="course-form" action="/teacher/SubmitEditCourse/<?= htmlspecialchars($course['course_id']) ?>" method="POST" enctype="multipart/form-data" class="bg-white p-6 pb-12 rounded-md shadow-md">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token); ?>">
                        <h2 id="form-title" class="text-lg font-bold mb-4">Course Details</h2>
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700">Title</label>
                            <input id="title" name="title" type="text" class="w-full mt-1 p-2 border rounded-md" value="<?= htmlspecialchars($course['title']) ?>" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700">Description</label>
                            <input id="description" name="description" type="text" class="w-full mt-1 p-2 border rounded-md" value="<?= htmlspecialchars($course['description']) ?>" required>
                        </div>
                        <!-- Category Select -->
                        <div class="mb-4">
                            <label for="category_select" class="block text-gray-700">Category</label>
                            <select id="category_select" name="category_id" class="w-full mt-1 p-2 border rounded-md text-black" required>
                                <option value="" disabled>Select a category</option>
                                <?php foreach ($categories as $categorie): ?>
                                    <option value="<?= htmlspecialchars($categorie["category_id"]) ?>" <?= $course['category_id'] == $categorie["category_id"] ? 'selected' : '' ?>><?= htmlspecialchars($categorie["category_name"]) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        
                        <!-- tags select -->
                        <div class="mb-4">
                            <label for="tags_select" class="block text-gray-700">Tags</label>
                            <select x-cloak id="tags_select">
                                <option value="" disabled class="text-gray-400">Select tags</option>
                                <?php foreach ($tags as $tag): ?>
                                    <option
                                        value="<?= htmlspecialchars($tag["tag_id"]) ?>"
                                        <?= in_array($tag["tag_name"], $course['tags']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($tag["tag_name"]) ?>
                                    </option>
                                <?php endforeach ?>
                            </select>


                            <div x-data="dropdown()" x-init="loadOptions()" class="flex flex-col items-center">
                                <input name="values" type="hidden" x-bind:value="selectedValues()">
                                <div class="relative w-full">
                                    <div class="flex flex-col items-center relative">
                                        <div x-on:click="open" class="w-full">
                                            <div class="my-2 p-1 flex border border-gray-200 bg-white rounded">
                                                <div class="flex flex-auto flex-wrap">
                                                    <template x-for="(option,index) in selected" :key="options[option].value">
                                                        <div class="flex justify-center items-center m-1 font-medium py-1 px-1 rounded bg-gray-100 border">
                                                            <div class="text-xs font-normal leading-none max-w-full flex-initial x-model=" options[option] x-text="options[option].text"></div>
                                                            <div class="flex flex-auto flex-row-reverse">
                                                                <div x-on:click.stop="remove(index,option)">
                                                                    <svg class="fill-current h-4 w-4 " role="button" viewBox="0 0 20 20">
                                                                        <path d="M14.348,14.849c-0.469,0.469-1.229,0.469-1.697,0L10,11.819l-2.651,3.029c-0.469,0.469-1.229,0.469-1.697,0 c-0.469-0.469-0.469-1.229,0-1.697l2.758-3.15L5.651,6.849c-0.469-0.469-0.469-1.228,0-1.697s1.228-0.469,1.697,0L10,8.183 l2.651-3.031c0.469-0.469,1.228-0.469,1.697,0s0.469,1.229,0,1.697l-2.758,3.152l2.758,3.15 C14.817,13.62,14.817,14.38,14.348,14.849z" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </template>
                                                    <div x-show="selected.length == 0" class="flex-1">
                                                        <input name="tags" placeholder="Select tags" class="bg-transparent p-1 px-2 appearance-none outline-none h-full w-full text-gray-800" x-bind:value="selectedValues()">
                                                    </div>
                                                </div>
                                                <div class="text-gray-300 py-1 pl-2 pr-1 border-l flex items-center border-gray-200 svelte-1l8159u">

                                                    <button type="button" x-show="isOpen() === true" x-on:click="open" class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                                                        <svg version="1.1" class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                                            <path d="M17.418,6.109c0.272-0.268,0.709-0.268,0.979,0s0.271,0.701,0,0.969l-7.908,7.83 c-0.27,0.268-0.707,0.268-0.979,0l-7.908-7.83c-0.27-0.268-0.27-0.701,0-0.969c0.271-0.268,0.709-0.268,0.979,0L10,13.25 L17.418,6.109z" />
                                                        </svg>
                                                    </button>
                                                    <button type="button" x-show="isOpen() === false" @click="close" class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                                                        <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                                            <path d="M2.582,13.891c-0.272,0.268-0.709,0.268-0.979,0s-0.271-0.701,0-0.969l7.908-7.83 c0.27-0.268,0.707-0.268,0.979,0l7.908,7.83c0.27,0.268,0.27,0.701,0,0.969c-0.271,0.268-0.709,0.268-0.978,0L10,6.75L2.582,13.891z " />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-full px-4">
                                            <div x-show.transition.origin.top="isOpen()" class="absolute shadow top-100 bg-white z-40 w-full left-0 rounded max-h-select" x-on:click.away="close">
                                                <div class="flex flex-col w-full overflow-y-auto h-64">
                                                    <template x-for="(option,index) in options" :key="option" class="overflow-auto">
                                                        <div class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-gray-100" @click="select(index,$event)">
                                                            <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative">
                                                                <div class="w-full items-center flex justify-between">
                                                                    <div class="mx-2 leading-6" x-model="option" x-text="option.text"></div>
                                                                    <div x-show="option.selected">
                                                                        <svg class="svg-icon" viewBox="0 0 20 20">
                                                                            <path fill="none" d="M7.197,16.963H7.195c-0.204,0-0.399-0.083-0.544-0.227l-6.039-6.082c-0.3-0.302-0.297-0.788,0.003-1.087 C0.919,9.266,1.404,9.269,1.702,9.57l5.495,5.536L18.221,4.083c0.301-0.301,0.787-0.301,1.087,0c0.301,0.3,0.301,0.787,0,1.087 L7.741,16.738C7.596,16.882,7.401,16.963,7.197,16.963z"></path>
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- File upload section -->
                        <div class="mb-4" id="file-upload-section">
                            <label id="file-label" for="file-input" class="block text-gray-700">Upload File</label>
                            <input id="file-input" name="content" type="file" class="w-full mt-1 p-2 border rounded-md"
                                accept="<?= $course['content_type'] === 'document' ? '.pdf,.doc,.docx' : 'video/*' ?>"
                                onchange="<?= $course['content_type'] === 'document' ? 'validateDocumentFile(event)' : 'validateVideoFile(event)' ?>">
                            <?php if ($course['content_type'] === 'video'): ?>
                                <p class="text-sm text-gray-600 mt-2">Current Video: <?= htmlspecialchars($course['content']['video_url']) ?></p>
                            <?php elseif ($course['content_type'] === 'document'): ?>
                                <p class="text-sm text-gray-600 mt-2">Current Document: <?= htmlspecialchars($course['content']['document_url']) ?></p>
                            <?php endif; ?>
                        </div>

                        <input type="hidden" name="content_type" value="<?= htmlspecialchars($course['content_type']) ?>">
                        <button type="submit" class="float-right px-4 py-2 text-sm font-bold text-white bg-[#2E5077] border-2 border-[#2E5077] rounded transition hover:bg-transparent hover:text-[#2E5077]">
                            Update Course
                        </button>
                    </form>

                </div>

            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <script src="/assets/js/tags.js"></script>
</body>

</html>