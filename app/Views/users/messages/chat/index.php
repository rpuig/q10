<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
   
<body>
    <h1>Chat System</h1>
    <div id="user-list">
        <!-- List of users -->
    </div>
    <div id="chat-modal" style="display: none;">
        <div id="chat-window">
            <div id="chat-messages"></div>
            <input type="text" id="message-input">
            <button id="send-button">Send</button>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let ws = new WebSocket('ws://localhost:8080');
            let currentRecipient = null;

            ws.onopen = function() {
                console.log('Connected to WebSocket server');
            };

            ws.onmessage = function(event) {
                let data = JSON.parse(event.data);
                if (data.sender_id == currentRecipient || data.recipient_id == currentRecipient) {
                    appendMessage(data.message, data.sender_id);
                }
            };

            function openChat(recipientId) {
                currentRecipient = recipientId;
                $('#chat-modal').show();
                loadMessages(recipientId);
            }

            function loadMessages(recipientId) {
                $.get(`/chat/getMessages/${getCurrentUserId()}/${recipientId}`, function(messages) {
                    $('#chat-messages').empty();
                    messages.forEach(function(message) {
                        appendMessage(message.message, message.sender_id);
                    });
                });
            }

            function appendMessage(message, senderId) {
                let messageElement = $('<div>').text(message);
                if (senderId == getCurrentUserId()) {
                    messageElement.addClass('sent');
                } else {
                    messageElement.addClass('received');
                }
                $('#chat-messages').append(messageElement);
            }

            $('#send-button').click(function() {
                let message = $('#message-input').val();
                if (message.trim() !== '') {
                    sendMessage(message);
                    $('#message-input').val('');
                }
            });

            function sendMessage(message) {
                let data = {
                    sender_id: getCurrentUserId(),
                    recipient_id: currentRecipient,
                    message: message
                };
                ws.send(JSON.stringify(data));
                $.post('/chat/saveMessage', data);
                appendMessage(message, getCurrentUserId());
            }

            function getCurrentUserId() {
                // Replace this with your actual method of getting the current user's ID
                return 1;
            }

            // Load user list and set up click events
            $.get('/users/list', function(users) {
                users.forEach(function(user) {
                    let userElement = $('<div>').text(user.name).click(function() {
                        openChat(user.id);
                    });
                    $('#user-list').append(userElement);
                });
            });
        });
    </script>
                
                <script>
        $(document).ready(function() {
            $('#birthDate').datepicker({
                format: 'dd/mm/yyyy'
            });
        });
</script><script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>   
<script src="<?= base_url('assets/js/geo.js') ?>"></script>

<?= $this->endSection() ?>