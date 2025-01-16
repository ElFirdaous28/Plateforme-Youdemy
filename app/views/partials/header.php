<!-- Header -->
<header class="fixed top-0 lg:left-64 left-0 right-0 flex items-center justify-between px-4 py-4 bg-gray-50 shadow lg:py-6 z-30">
    <button id="toggleOpen" class="lg:invisible">
        <svg class="w-7 h-7" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M3 5h14a1 1 0 100-2H3a1 1 0 100 2zm0 6h14a1 1 0 100-2H3a1 1 0 100 2zm0 6h14a1 1 0 100-2H3a1 1 0 100 2z"
                clip-rule="evenodd"></path>
        </svg>
    </button>
    <!-- bell and notification -->
    <div class="flex items-center">
        <div x-data="{ dropdownOpen: false }" class="relative">

            <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full"
                style="display: none;"></div>
                <a href="/logout" class="text-[#2E5077] hover:underline font-semibold">Logout</a>


        </div>

        <!-- notifications -->
        <div x-data="{ notificationOpen: false }" class="relative">
            <button @click="notificationOpen = ! notificationOpen"
                class="flex mx-4 text-gray-600 focus:outline-none">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15 17H20L18.5951 15.5951C18.2141 15.2141 18 14.6973 18 14.1585V11C18 8.38757 16.3304 6.16509 14 5.34142V5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5V5.34142C7.66962 6.16509 6 8.38757 6 11V14.1585C6 14.6973 5.78595 15.2141 5.40493 15.5951L4 17H9M15 17V18C15 19.6569 13.6569 21 12 21C10.3431 21 9 19.6569 9 18V17M15 17H9"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                </svg>
            </button>

            <div x-show="notificationOpen" @click="notificationOpen = false"
                class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>

            <div x-show="notificationOpen"
                class="absolute right-0 z-10 mt-5 overflow-hidden bg-white rounded-lg shadow-xl w-80"
                style="width: 20rem; display: none;">
                <div class="h-[50vh] p-1 overflow-y-auto scrollbar-hide">
                    <?php if (!empty($lateReturn)): ?>
                        <?php foreach ($lateReturns as $lateReturn): ?>
                            <?php if ($lateReturn["email_sent"] === 0): ?>
                                <div class="flex justify-between items-center px-4 py-2 bg-white hover:bg-gray-100 rounded-lg shadow-md">
                                    <!-- Book and User Info -->
                                    <div class="flex flex-col gap-1">
                                        <div class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($lateReturn["title"], ENT_QUOTES, 'UTF-8') ?></div>
                                        <div class="text-sm text-gray-600"><?= htmlspecialchars($lateReturn["name"], ENT_QUOTES, 'UTF-8') ?></div>
                                        <div class="text-sm text-gray-500">Return Date: <?= htmlspecialchars($lateReturn["return_date"], ENT_QUOTES, 'UTF-8') ?></div>
                                    </div>
                                    <!-- Email Button -->
                                    <div>
                                        <form action="../../controllers/Borrowings/sendEmail.php" method="POST">
                                            <input type="text" name="username" class="hidden" value="<?= htmlspecialchars($lateReturn["name"]) ?>">
                                            <input type="text" name="user_email" class="hidden" value="<?= htmlspecialchars($lateReturn["email"]) ?>">
                                            <input type="text" name="return_date" class="hidden" value="<?= htmlspecialchars($lateReturn["return_date"]) ?>">
                                            <input type="text" name="borrow_date" class="hidden" value="<?= htmlspecialchars($lateReturn["borrow_date"]) ?>">
                                            <input type="text" name="book_title" class="hidden" value="<?= htmlspecialchars($lateReturn["title"]) ?>">
                                            <input type="text" name="id_borrowing" class="hidden" value="<?= htmlspecialchars($lateReturn["id_borrowing"]) ?>">

                                            <input type="submit" value="Send Email" name="send_email" class="text-indigo-600 hover:text-indigo-800 transition-all cursor-pointer">
                                        </form>
                                    </div>
                                </div>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php else: ?>
                        <div class="text-gray-600 mt-[50%] text-center">No late returns</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>