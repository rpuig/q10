$(document).ready(function() {
	let currentPage = 1;
	let isLoading = false;

	function scrollToBottom() {
			const messageContainer = $('#message-container');
			setTimeout(function() {
					messageContainer.scrollTop(messageContainer[0].scrollHeight);
			}, 100);
	}
	function addMessageToDOM(messageHtml) {
    const container = $('#message-container');
    const element = $(messageHtml);
    container.append(element);
    setTimeout(() => {
        element.css('opacity', 1); // Trigger animation
    }, 100);
}
	function loadMessages(page = 1) {
    if (isLoading) return;

    isLoading = true;

    $.get(`/messages/conversation/${otherUserId}/${page}`, function(response) {
        console.log(response); // Inspect API response
        const data = response.messages || response; // Adjust based on API structure

        if (!Array.isArray(data)) {
            console.error('Invalid data format:', data);
            isLoading = false;
            return;
        }

        data.sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp)); // Ascending order
        const messageHtml = data.map(message => `
           
					<div class="message ${message.sender_id == currentUserId ? 'sent' : 'received'} ${message.sender_gender.toLowerCase()}">
                <img src="${escapeHtml(message.sender_profile_picture)}" alt="${escapeHtml(message.sender_name)}">
              
								<div class="text-content">
								
                    <strong>${escapeHtml(message.sender_name)}:</strong> ${escapeHtml(message.message)}
                </div>

            </div>`

        ).join('');

        if (page === 1) {
            $('#message-container').html(messageHtml);
            scrollToBottom();
        } else {
            $('#message-container').prepend(messageHtml);
        }

        isLoading = false;
    }).fail(function(xhr, status, error) {
        console.error('Error loading messages:', error);
        isLoading = false;
    });
}


	$('#message-form').submit(function(e) {
			e.preventDefault();
			const message = $('#message-input').val().trim();
			
			if (!message) return;

			$.ajax({
					url: '/messages/send',
					method: 'POST',
					contentType: 'application/json',
					data: JSON.stringify({
							sender_id: currentUserId,
							receiver_id: otherUserId,
							message: message
					}),
					success: function(response) {
							$('#message-input').val('');
							loadMessages(); // Reload messages after sending
					},
					error: function(xhr, status, error) {
							console.error('Error sending message:', error);
							alert('Failed to send message. Please try again.');
					}
			});
	});

	$('#message-container').scroll(function() {
			if ($(this).scrollTop() === 0 && !isLoading) {
					currentPage++;
					loadMessages(currentPage);
			}
	});

	function escapeHtml(text) {
			return $('<div>').text(text).html();
	}

	loadMessages(); // Initial load of messages
});