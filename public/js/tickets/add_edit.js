function disallowFirstSpace(event) {
    var inputField = document.getElementById('title');
    var inputValue = inputField.value;
    if (inputValue[0] === ' ' && inputValue.length === 1) {
        inputField.value = '';
        event.preventDefault();
    }
}
function disallowFirstSpaceTextArea(event, inputElement) {
    var inputValue = inputElement.value;
    if (inputValue.charAt(0) === ' ') {
        inputElement.value = inputValue.slice(1);
        event.preventDefault();
    }
}