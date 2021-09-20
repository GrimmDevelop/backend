
export function randomString(length) {
    let mask = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let result = '';
    for (let i = length; i > 0; --i) result += mask[Math.round(Math.random() * mask.length)];
    return result;
}
