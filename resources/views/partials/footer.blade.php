<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <div id="yearContainer" style="display:flex">
                    <span id="year"></span> © IT DEPARTMENT INSURAPRIME.
                </div>
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Crafted with <i class="mdi mdi-heart text-danger"></i> by InsuraPrime Dev
                </div>
            </div>
        </div>
    </div>
</footer>
<script>
    var yearElement = document.getElementById('year');
    if (yearElement) {
        yearElement.textContent = new Date().getFullYear();
    }
</script>
