<!-- Sidebar -->
<div id="sidebar"
    class="fixed top-0 left-0 h-full w-64 bg-white z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 border-r-2">
    <div class="flex items-center justify-center h-20">
        <img src="/assets/images/logo.png" alt="logo" class="w-32" />
    </div>
    <ul class="flex flex-col py-4 pl-4">
        <li>
            <a href="<?php $_SESSION['user_loged_in_role'] === "admin" ? "/admin/dashboard" : ($_SESSION['user_loged_in_role'] === "teacher" ? "/teacher/dashboard" : "/student/dashboard") ?>" class="flex items-center h-12 text-gray-500 hover:text-gray-800">
                <i class="bx bx-home text-lg text-gray-400 w-12"></i>
                <span class="text-sm font-medium">Dashboard</span>
            </a>
        </li>
        <!-- admin links -->
        <?php if ($_SESSION['user_loged_in_role'] === "admin"): ?>
            
            <li>
                <a href="/admin/users" class="flex items-center h-12 text-gray-500 hover:text-gray-800">
                    <i class="bx bx-user text-lg text-gray-400 w-12"></i>
                    <span class="text-sm font-medium">Users</span>
                </a>
            </li>

            <li>
                <a href="#" class="flex items-center h-12 text-gray-500 hover:text-gray-800">
                    <i class="bx bx-book text-lg text-gray-400 w-12"></i>
                    <span class="text-sm font-medium">Courses</span>
                </a>
            </li>

            <li>
                <a href="/admin/categories" class="flex items-center h-12 text-gray-500 hover:text-gray-800">
                    <i class="bx bx-category text-lg text-gray-400 w-12"></i>
                    <span class="text-sm font-medium">Categories</span>
                </a>
            </li>

            <li>
                <a href="#" class="flex items-center h-12 text-gray-500 hover:text-gray-800">
                    <i class="bx bx-tag text-lg text-gray-400 w-12"></i>
                    <span class="text-sm font-medium">Tags</span>
                </a>
            </li>

            <li>
                <a href="/admin/inactiveTeachers" class="flex items-center h-12 text-gray-500 hover:text-gray-800">
                    <i class="bx bx-briefcase text-lg text-gray-400 w-12"></i> <!-- Briefcase Icon for Teachers -->
                    <span class="text-sm font-medium">Inactive Teachers</span>
                </a>
            </li>
            <!-- teacher links -->
        <?php elseif ($_SESSION['user_loged_in_role'] === "teacher"): ?>
            <!-- student links -->
        <?php else: ?>
        <?php endif ?>

    </ul>
</div>