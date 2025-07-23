$(document).ready(function() {
	const currentUserId = <?= $currentUserId ?>;
	const otherUserId = <?= $otherUserId ?>;
	let currentPage = 1;

	
	console.log("Chat.js is loaded"); // Debugging statement
	function loadMessages(page = 1) {
			$.get(`/messages/get/${otherUserId}/${page}`, function(data) {
					const messageHtml = data.map(message => `
							<div class="message ${message.sender_id == currentUserId ? 'sent' : 'received'} ${message.sender_gender.toLowerCase()}">
									<img src="/uploads/${message.sender_profile_picture}" alt="${message.sender_name}">
									<div class="text-content">
											<strong>${message.sender_name}:</strong> ${message.message}
									</div>
							</div>`
					).join('');

					if (page === 1) {
							$('#message-container').html(messageHtml);
					} else {
							$('#message-container').prepend(messageHtml);
					}
			});
	}

	$('#message-form').submit(function(e) {
			e.preventDefault();
			const message = $('#message-input').val();

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
							loadMessages();
					},
					error: function(xhr, status, error) {
							console.error('Error sending message:', error);
					}
			});
	});

	$('#message-container').scroll(function() {
			if ($(this).scrollTop() === 0) {
					currentPage++;
					loadMessages(currentPage);
			}
	});

	loadMessages();
});
