<h1 class="text-xl font-semibold pt-4 text-gray-700">Courses</h1>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-10">
    <?php foreach ($courses as $course): ?>
        <div class="bg-white border border-gray-300 rounded-lg shadow-md hover:shadow-xl transition-transform transform hover:scale-105 flex flex-col overflow-hidden">
            <!-- Course Cover -->
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-t-lg">
                <span class="text-gray-400">Course Cover</span>
            </div>
            
            <div class="p-6 flex flex-col flex-grow space-y-4">
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
            <form action="/student/enroll/<?= $course['course_id'] ?>" method="POST" class="mt-auto mb-4 w-11/12 self-center text-center">
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