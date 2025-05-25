
<style>
    /* Стили для контейнера формы */
    #reply-form-container {
        display: none;
        max-width: 800px;
        margin: 20px auto;
        padding: 25px;
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border: 1px solid #dee2e6;
    }

    #reply-form-container.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    #reply-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #000000;
    }

    .form-control {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 14px;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .btn {
        padding: 8px 20px;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    input[readonly].form-control,
    textarea[readonly].form-control {
        background-color: #e9ecef;
        opacity: 1;
    }

    input[readonly].form-control,
    textarea[readonly].form-control {
        background-color: #e9ecef;
        color: #212529;
        opacity: 1;
    }
</style>

<div id="reply-form-container">
    <form id="reply-form" method="post" action="/admin/add?table=">
        <input type="hidden" name="table_name" id="table">
        <input type="hidden" name="record_id" id="record-id"> <!-- может быть пустым при добавлении -->

        <div id="dynamic-fields-container"></div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">Сохранить</button>
            <button type="button" id="cancel-reply-btn" class="btn btn-danger">Отмена</button>
        </div>
    </form>
</div><script>
    document.addEventListener('DOMContentLoaded', function () {
        const openFormBtns = document.querySelectorAll('.open-form-btn');
        const replyFormContainer = document.getElementById('reply-form-container');
        const replyForm = document.getElementById('reply-form');

        const cancelBtn = document.getElementById('cancel-reply-btn');
        const dynamicFields = document.getElementById('dynamic-fields-container');
        const tableInput = document.getElementById('table');
        const recordIdInput = document.getElementById('record-id');

        openFormBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const table = btn.dataset.table;
                const id = btn.dataset.id || '';
                const fields = JSON.parse(btn.dataset.fields || '[]');
                const primaryFields = JSON.parse(btn.dataset.primary || '[]');
                const values = JSON.parse(btn.dataset.values || '{}'); // ключ-значения текущих данных

                const isEdit = id !== '';

                tableInput.value = table;
                recordIdInput.value = id;
                replyForm.action = `/admin/add?table=${encodeURIComponent(table)}`;

                dynamicFields.innerHTML = '';

                fields.forEach(field => {

                    const formGroup = document.createElement('div');
                    formGroup.className = 'form-group';

                    const label = document.createElement('label');
                    label.textContent = field;
                    formGroup.appendChild(label);

                    const input = document.createElement('input');
                    input.type = 'text';
                    input.name = `fields[${field}]`;
                    input.className = 'form-control';

                    // Если редактируем — вставляем значение
                    if (isEdit && values[field] !== undefined) {
                        input.value = values[field];
                    }

                    // Если это редактирование и поле — первичный ключ → readonly
                    if ( primaryFields.includes(field)) {
                        input.readOnly = true;
                    }
                    else {
                        // Только не readonly поля делаем обязательными
                        input.required = true;
                    }

                    formGroup.appendChild(input);
                    dynamicFields.appendChild(formGroup);
                });

                replyFormContainer.classList.add('active');
                window.scrollTo({ top: replyFormContainer.offsetTop, behavior: 'smooth' });
            });
        });

        cancelBtn.addEventListener('click', () => {
            replyFormContainer.classList.remove('active');
            dynamicFields.innerHTML = '';
            tableInput.value = '';
            recordIdInput.value = '';
        });
    });
</script>


