
function showToast(message, isSuccess = true) {
	const toastEl = $('#toastNotification');
	const toastBody = $('#toastBody');

	toastBody.html(message);
	toastEl.removeClass('bg-success bg-danger').addClass(isSuccess ? 'bg-success' : 'bg-danger');
	new bootstrap.Toast(toastEl).show();
}

if(typeof toastData !== 'undefined' && toastData.message) {
	showToast(toastData.message, toastData.isSuccess);
}