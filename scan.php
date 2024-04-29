<?php
include('_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
}
?>
<?php include('_header.php'); ?>
<div class="container pt-3">
    <div class="row">
        <div class="col-12 form-auth d-flex justify-content-center text-center">
            <form action="#" onsubmit="return false">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-person-circle mb-2" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                </svg>
                <h1 class="h3 mb-3 fw-normal">Complete QR Code Check</h1>
                <div style="width: 500px" id="reader"></div>
                <p class="mt-5 mb-3 text-body-secondary">© Banking E-Authentication System 2022–2023</p>
            </form>
        </div>
    </div>
</div>
<script src="public/js/html5-qrcode.min.js"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        html5QrcodeScanner.pause();
        var obj = {};
        try {
            obj = JSON.parse(decodedText);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'validate.php');

            xhr.onload = function() {
                if (xhr.status === 200) {
                    var obj = JSON.parse(xhr.responseText);
                    if (obj.status == 'success') {
                        window.location.href = 'success.php';
                    } else {
                        alert(obj.message);
                        html5QrcodeScanner.resume();
                    }
                } else {
                    html5QrcodeScanner.resume();
                }
            };

            const data = new FormData();
            data.append('token', '<?php echo $_GET['token']; ?>');
            data.append('tid', obj.tid);
            data.append('email', obj.email);
            xhr.send(data);
        } catch (error) {}

        // Check email is set or not
        if (obj.email == undefined || obj.tid == undefined) {
            alert('Invalid QR Code');
            html5QrcodeScanner.resume();
            return;
        }
    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {
            fps: 10,
            qrbox: 250
        });
    html5QrcodeScanner.render(onScanSuccess);

    var reader = document.getElementById('reader');

    reader.addEventListener('click', function() {
        if (html5QrcodeScanner.getState() == 3)
            html5QrcodeScanner.resume();
    });
</script>
<?php include('_footer.php'); ?>