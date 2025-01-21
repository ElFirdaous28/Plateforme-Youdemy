<h1 class="text-xl font-semibold pt-4 text-gray-700">Courses</h1>
<!-- Search and Filter -->
<div class="mt-6 flex flex-wrap items-center justify-between gap-20">
    <!-- Search and Filter Form -->
    <form id="searchForm" action="" method="GET" class="w-full flex gap-4">
        <!-- Search -->
        <div class="flex-grow w-4/5">
            <input
                value="<?php if (isset($_GET['search_value'])) echo htmlspecialchars($_GET['search_value']); ?>"
                type="text"
                name="search_value"
                placeholder="Search by Title, Tag or Teacher name"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                onchange="this.form.submit()" />
        </div>

        <!-- Filter by Category -->
        <div>
            <select
                name="category"
                class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                onchange="this.form.submit()">
                <option value="">All Categories</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category['category_id']) ?>"
                        <?php if (isset($_GET['category']) && $_GET['category'] == $category['category_id']) echo 'selected'; ?>>
                        <?= htmlspecialchars($category['category_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-10">
    <?php foreach ($courses as $course): ?>
        <div class="bg-white border border-gray-300 rounded-lg shadow-md hover:shadow-xl transition-transform transform hover:scale-105 flex flex-col overflow-hidden">
            <!-- Course Cover -->
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-t-lg">
                <span class="text-gray-400">Course Cover</span>
            </div>

            <div class="px-6 py-1 flex flex-col flex-grow">
                <!-- Title -->
                <h3 class="text-xl font-semibold text-gray-700 truncate"><?= htmlspecialchars($course['title']) ?></h3>

                <!-- Description -->
                <p class="text-sm text-gray-600 mt-2 truncate"><?= htmlspecialchars($course['description']) ?></p>

                <!-- Content Type & Category -->
                <div class="mt-2 flex items-center space-x-2">
                    <span class="text-sm text-gray-500"><?= htmlspecialchars($course['content_type']) ?></span>
                    <span class="text-sm text-gray-500">|</span>
                    <span class="text-sm text-gray-500"><?= htmlspecialchars($course['category_name']) ?></span>
                </div>

                <!-- Teacher Name -->
                <p class="text-sm text-gray-600">Instructor: <span class="font-medium"><?= htmlspecialchars($course['teacher_name']) ?></span></p>

                <!-- Tags -->
                <?php if (!empty($course['tags'])): ?>
                    <div class="mt-2">
                        <span class="text-sm text-gray-500">Tags:</span>
                        <div class="flex flex-wrap mt-2 space-2">
                            <?php foreach ($course['tags'] as $tag): ?>
                                <span class="text-xs inline-block bg-gray-200 text-gray-700 py-1 px-2 mb-1 rounded-full"><?= '#' . htmlspecialchars($tag) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Enroll Button -->
            <form action="/student/enroll/<?= $course['course_id'] ?>" method="POST" class="mt-auto mb-2 w-11/12 self-center text-center">
                <?php if (isset($courseEnrolled_in_ids) && in_array($course['course_id'], $courseEnrolled_in_ids)): ?>
                    <button
                        type="submit"
                        class="w-full px-4 py-2 text-sm font-bold text-white bg-[#2E5077] border-2 border-[#2E5077] rounded transition hover:bg-transparent hover:text-[#2E5077] cursor-not-allowed"
                        disabled>
                        Already Enrolled
                    </button>
                <?php else: ?>
                    <button
                        type="submit"
                        class="w-full px-4 py-2 text-sm font-bold text-white bg-[#2E5077] border-2 border-[#2E5077] rounded transition hover:bg-transparent hover:text-[#2E5077]">
                        Enroll Now
                    </button>
                <?php endif; ?>
            </form>
        </div>
    <?php endforeach; ?>
</div>

<!-- Pagination Links -->
<div class="mt-10 flex justify-center space-x-2">
    <?php if ($currentPage > 1): ?>
        <a href="?page=<?= $currentPage - 1 ?>" class="px-3 py-1 bg-gray-200 text-gray-600 rounded">Previous</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>" class="px-3 py-1 <?= $i == $currentPage ? 'bg-[#2E5077] text-white' : 'bg-gray-200 text-gray-600' ?> rounded">
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($currentPage < $totalPages): ?>
        <a href="?page=<?= $currentPage + 1 ?>" class="px-3 py-1 bg-gray-200 text-gray-600 rounded">Next</a>
    <?php endif; ?>
</div>