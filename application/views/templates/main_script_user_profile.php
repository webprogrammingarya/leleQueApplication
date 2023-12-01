<script>
    $(document).ready(function(){
        document.addEventListener("DOMContentLoaded", function () {
            var radioPria = document.getElementById("pria");
            var radioWanita = document.getElementById("wanita");
    
            var form = document.querySelector("form");
    
            form.addEventListener("submit", function (event) {
                if (!radioPria.checked && !radioWanita.checked) {
                    event.preventDefault(); // Menghentikan pengiriman formulir jika tidak ada yang dipilih
                    alert("Harap pilih jenis kelamin Anda.");
                }
            });
    
            form.addEventListener("submit", function () {
                if (!radioPria.checked && !radioWanita.checked) {
                    document.querySelector("input[name='jenisKelamin']").value = "";
                }
            });
        });
    });
  </script>