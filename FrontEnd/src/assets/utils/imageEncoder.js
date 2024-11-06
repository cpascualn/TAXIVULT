export default function encodeImageToBase64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);  // Resultado es la imagen en Base64
        reader.onerror = error => reject(error);
    });
}
