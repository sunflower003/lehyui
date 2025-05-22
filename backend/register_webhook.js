const axios = require('axios');

const clientId = 'e2e81d35-6c7c-43fe-9322-52a852192b9e'; 
const apiKey = '316a560b-629e-4d71-a197-74a60510de7c';     
const webhookUrl = 'https://5975-2001-ee0-8203-f7a9-748c-9cff-adfd-b8db.ngrok-free.app/donate/webhook';

axios.post(
    'https://api-merchant.payos.vn/confirm-webhook',
    { webhookUrl },
    {
        headers: {
            'x-client-id': clientId,
            'x-api-key': apiKey,
            'Content-Type': 'application/json'
        }
    }
).then(response => {
    console.log('Đăng ký webhook thành công:', response.data);
}).catch(error => {
    if (error.response) {
        console.error('Lỗi:', error.response.data);
    } else {
        console.error('Lỗi:', error.message);
    }
});
