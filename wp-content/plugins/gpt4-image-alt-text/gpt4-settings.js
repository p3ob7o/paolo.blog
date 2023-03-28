document.addEventListener('DOMContentLoaded', () => {
    const saveButton = document.querySelector('#gpt4_save_api_key');

    if (saveButton) {
        saveButton.addEventListener('click', () => {
            const apiKey = document.querySelector('#gpt4_api_key').value;
            const data = { gpt4_api_key: apiKey };

            fetch(wpApiSettings.root + 'gpt4/v1/update-api-key', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': wpApiSettings.nonce,
                },
                body: JSON.stringify(data),
            })
                .then((response) => response.json())
                .then((data) => {
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
