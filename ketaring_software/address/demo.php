<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<input type="file" id="upload" accept="image/*">
<canvas id="canvas" style="display:none;"></canvas>
<img id="result" src="" alt="Processed Image">
<script>
    document.getElementById('upload').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        const img = new Image();
        img.src = e.target.result;

        img.onload = function() {
            const canvas = document.getElementById('canvas');
            const ctx = canvas.getContext('2d');
            
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img, 0, 0);

            // Get image data
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const data = imageData.data;

            // Process the image data to remove background (simple thresholding)
            for (let i = 0; i < data.length; i += 4) {
                const r = data[i];
                const g = data[i + 1];
                const b = data[i + 2];

                // Example condition: if the pixel is close to white, make it transparent
                if (r > 200 && g > 200 && b > 200) {
                    data[i + 3] = 0; // Set alpha to 0 (transparent)
                }
            }

            ctx.putImageData(imageData, 0, 0);

            // Convert canvas to image and display
            const resultImage = document.getElementById('result');
            resultImage.src = canvas.toDataURL('image/png');
        };
    };

    reader.readAsDataURL(file);
});

</script>
</body>
</html>