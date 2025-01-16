<!-- Tag Popup Modal -->
<div id="tagModal" class="fixed inset-0 flex z-50 items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
        <h2 id="modalTitle" class="text-xl font-semibold mb-4">Add Tag</h2>
        <form id="modalForm" action="/admin/addTag" method="POST">
            <!-- CSRF Token -->
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']?>">
            <!-- id tag in case of edit -->
            <input type="hidden" name="tag_id" value="0">
            <div class="mb-4">
                <label for="tag_name" class="block text-sm font-medium text-gray-700">Tag Name</label>
                <input type="text" id="tag_name" name="tag_name" required class="w-full mt-1 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
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
        const modal = document.getElementById('tagModal');
        modal.classList.toggle('hidden');
    }

    // Open the modal for adding or editing a tag
    function openModal(action, tagId = 0, tagName = "") {
        const modal = document.getElementById('tagModal');
        const modalTitle = document.getElementById('modalTitle');
        const submitButton = document.getElementById('submitButton');
        const tagInput = document.getElementById('tag_name');
        const idTagInput = document.querySelector('input[name="tag_id"]');
        const modalForm = document.getElementById('modalForm');

        if (action === "edit") {
            modalTitle.textContent = "Edit Tag";
            submitButton.textContent = "Save Changes";
            idTagInput.value = tagId;
            tagInput.value = tagName;
            modalForm.action = `/admin/editTag/${tagId}`;
        } else {
            modalTitle.textContent = "Add Tag";
            submitButton.textContent = "Add";
            idTagInput.value = 0;
            tagInput.value = ""; // Clear the input field for Add mode
            modalForm.action = "/admin/addTag";
        }

        // Show the modal
        modal.classList.remove('hidden');
    }
</script>