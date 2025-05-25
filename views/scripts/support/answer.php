
    <style>
        /* Стили для контейнера формы */
        #reply-form-container-request      {
            display: none;
            max-width: 800px;
            margin: 20px auto;
            padding: 25px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #dee2e6;
        }

        #reply-form-container-request.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }


        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        #reply-form-request  {
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


    <div id="reply-form-container-request">
        <form id="reply-form-request" method="post" action="/admin/send-answer">
            <input type="hidden" name="request_id" id="request-id">

            <div class="form-group">
                <label>Заголовок обращения</label>
                <input type="text" id="request-header" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label>Текст обращения</label>
                <textarea id="request-content" class="form-control" rows="3" readonly></textarea>
            </div>

            <div class="form-group">
                <label for="answer-header">Заголовок ответа</label>
                <input type="text" name="header_answer" id="answer-header" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="reply-content">Ваш ответ</label>
                <textarea name="body_answer" id="reply-content" class="form-control"
                          placeholder="Введите ваш ответ..." rows="4" required></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">Отправить ответ</button>
                <button type="button" id="cancel-reply-btn-request" class="btn btn-danger">Отмена</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const replyBtnsRequest = document.querySelectorAll('.reply-btn-request');
            const cancelReplyBtnRequest = document.getElementById('cancel-reply-btn-request');
            const replyFormContainerRequest = document.getElementById('reply-form-container-request');
            const requestIdField = document.getElementById('request-id');
            const requestHeaderField = document.getElementById('request-header');
            const requestContentField = document.getElementById('request-content');
            const answerHeaderField = document.getElementById('answer-header');
            const replyContentField = document.getElementById('reply-content');

            replyBtnsRequest.forEach(btn => {
                btn.addEventListener('click', function () {
                    // Заполнение данных
                    requestIdField.value = this.dataset.id || '';
                    requestHeaderField.value = this.dataset.header || '';
                    requestContentField.value = this.dataset.content || '';

                    // Очистка полей ответа
                    answerHeaderField.value = '';
                    replyContentField.value = '';

                    // Показ формы
                    replyFormContainerRequest.classList.add('active');
                    replyFormContainerRequest.scrollIntoView({ behavior: 'smooth' });
                });
            });

            cancelReplyBtnRequest.addEventListener('click', function () {
                replyFormContainerRequest.classList.remove('active');
            });
        });
    </script>



