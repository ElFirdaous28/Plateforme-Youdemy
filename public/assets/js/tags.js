function dropdown() {
    return {
        options: [],
        selected: [],
        show: false,
        open() { this.show = true },
        close() { this.show = false },
        isOpen() { return this.show === true },
        select(index, event) {
            // Prevent selecting the placeholder option
            if (this.options[index].value === "") return;

            if (!this.options[index].selected) {
                this.options[index].selected = true;
                this.options[index].element = event.target;
                this.selected.push(index);
            } else {
                this.selected.splice(this.selected.lastIndexOf(index), 1);
                this.options[index].selected = false;
            }
        },
        remove(index, option) {
            this.options[option].selected = false;
            this.selected.splice(index, 1);
        },
        loadOptions() {
            const options = document.getElementById('tags_select').options;
            for (let i = 0; i < options.length; i++) {
                const isSelected = options[i].hasAttribute('selected');
                this.options.push({
                    value: options[i].value,
                    text: options[i].innerText,
                    selected: isSelected
                });
                if (isSelected) {
                    this.selected.push(i); // Add preselected options to the selected array
                }
            }
        },        
        selectedValues() {
            return this.selected.map((option) => {
                return this.options[option].value;
            });
        }
    }
}

categorySelect = document.getElementById('category_select');
categorySelect.addEventListener("change", () => {
    if (categorySelect.value == "") {
        categorySelect.classList.add("text-gray-400");
    }
    else
        categorySelect.classList.remove("text-gray-400");
})

function validateVideoFile(event) {
    const file = event.target.files[0];
    const fileType = file ? file.type : '';
    const validTypes = ['video/mp4', 'video/webm', 'video/ogg']; // List of accepted video types

    if (!validTypes.includes(fileType)) {
        alert("Please select a valid video file.");
        event.target.value = ''; // Clear the selected file
    }
}
function validateDocumentFile(event) {
    const file = event.target.files[0];
    const fileType = file ? file.name.split('.').pop().toLowerCase() : ''; // Get the file extension
    const validTypes = ['pdf', 'doc', 'docx']; // List of accepted document types

    if (!validTypes.includes(fileType)) {
        alert("Please upload a valid document (PDF, DOC, DOCX).");
        event.target.value = ''; // Clear the selected file
    }
}
