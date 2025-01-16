<!-- Popup Modal -->
<div id="modal" class="fixed inset-0 flex z-50 items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
        <h2 id="modalTitle" class="text-xl font-semibold mb-4">Add Category</h2>
        <form id="modalForm" action="/admin/addCategory" method="POST">
            <!-- CSRF Token -->
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <!-- ID Category (0 for Add, set dynamically for Edit) -->
            <input type="hidden" name="id_category" value="0">
            <div class="mb-4">
                <label for="category_name" class="block text-sm font-medium text-gray-700">Category Name</label>
                <input type="text" id="category_name" name="category_name" required class="w-full mt-1 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="toggleModal()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 mr-2">
                    Cancel
                </button>
                <button id="submitButton" type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#2E5077] border-2 border-[#2E5077] rounded transition hover:bg-transparent hover:text-[#2E5077]">
                    Add
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Toggle the visibility of the modal
    function toggleModal() {
        const modal = document.getElementById('modal');
        modal.classList.toggle('hidden');
    }

    // Open modal for Add or Edit
    function openModal(action, categoryId = 0, categoryName = "") {
        const modal = document.getElementById('modal');
        const modalTitle = document.getElementById('modalTitle');
        const submitButton = document.getElementById('submitButton');
        const categoryInput = document.getElementById('category_name');
        const idCategoryInput = document.querySelector('input[name="id_category"]');
        const modalForm = document.getElementById('modalForm');

        if (action === "edit") {
            modalTitle.textContent = "Edit Category";
            submitButton.textContent = "Save Changes";
            idCategoryInput.value = categoryId;
            categoryInput.value = categoryName;
            modalForm.action = `/admin/editCategory/${categoryId}`;
        } else {
            modalTitle.textContent = "Add Category";
            submitButton.textContent = "Add";
            idCategoryInput.value = 0;
            categoryInput.value = "";
            modalForm.action = "/admin/addCategory";
        }

        // Show the modal
        modal.classList.remove('hidden');
    }
</script>