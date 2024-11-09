const IMG_TOKEN = import.meta.env.VITE_IMAGE_DESCRIPTOR_TOKEN;
export default {

    async checkImage(file) {
        try {
            const formData = new FormData();
            formData.append('file', file);


            const response = await fetch(
                "https://api-inference.huggingface.co/models/google/vit-base-patch16-224",
                {
                    headers: {
                        Authorization: `Bearer ${IMG_TOKEN}`,
                    },
                    method: "POST",
                    body: file,
                }
            );
            const result = await response.json();
            return result;
        } catch (err) {
            throw err;
        }
    }
}