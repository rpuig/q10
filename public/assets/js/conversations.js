$(document).ready(function() {
	function loadConversations() {
			$.ajax({
					url: '/messages/conversations-data',
					method: 'GET',
					dataType: 'json',
					success: function(data) {
							const conversationsHtml = data.map(partner => `
									<a href="/messages/conversation/${partner.userid}" class="list-group-item list-group-item-action d-flex align-items-center" aria-label="Conversation with ${escapeHtml(partner.username)}">
    <img src="${escapeHtml(partner.profile_picture)}" alt="${escapeHtml(partner.username)}'s profile picture" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
    <div class="ms-3">
        <h5 class="mb-1 text-truncate">${escapeHtml(partner.username)}</h5>
    </div>
</a>
							`).join('');

							$('#conversations-container').html(conversationsHtml);
					},
					error: function(xhr, status, error) {
							console.error('Error loading conversations:', error);
							$('#conversations-container').html('<p>Unable to load conversations. Please try again later.</p>');
					}
			});
	}

	function escapeHtml(text) {
			return $('<div>').text(text).html();
	}

	loadConversations();
});