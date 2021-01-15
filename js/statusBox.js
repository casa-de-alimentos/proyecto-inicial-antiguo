const status = document.getElementById('js_statusBox');
const dataStatus = JSON.parse(status.value || '');
console.log(dataStatus);
if (dataStatus && Object.keys(dataStatus).length === 2) {
	M.toast({html: dataStatus.message, classes: `toast__${dataStatus.status}`});
}