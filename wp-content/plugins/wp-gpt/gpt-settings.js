document.addEventListener('DOMContentLoaded', () => {
    console.log('DOMContentLoaded'); // Add this line
    const saveButton = document.querySelector('#gpt_save_api_key');
    console.log('saveButton:', saveButton); // Add this line

    if (saveButton) {
        saveButton.addEventListener('click', () => {
            console.log('Button clicked'); // Add this line
            const apiKey = document.querySelector('#gpt_api_key').value;
            const data = { gpt_api_key: apiKey };

            fetch(wpApiSettings.root + 'gpt4/v1/update-api-key', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': wpApiSettings.nonce,
                },
                body: JSON.stringify(data),
            })
                .then((response) => {
                    console.log('Response:', response); // Add this line
                    return response.json();
                })
                .then((data) => {
                    console.log('Data:', data); // Add this line
                    if (data.status === 'success') {
                        alert('API key saved successfully.');
                    } else {
                        alert('Error saving API key.');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        });
    }
});
