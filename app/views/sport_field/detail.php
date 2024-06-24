<?php
$hiddenSliderSection = true;
$hiddenCategory = true;
require_once __DIR__ . '/../layouts/header.php';
?>
<section class="bg-white">
    <div class="container d-flex">
        <div class="left">
            <?php echo $sportField['Description']; ?>
        </div>

        <div class="right" style="min-width:200px">
            <div class="card" style="width: 18rem;">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>

</section>



<?php
require_once __DIR__ . '/../layouts/footer.php';
?>



<script>
    function replaceImagesSrc() {
        const images = document.getElementsByTagName("img");
        [...images].forEach((img) => {
            img.style.width =  '600px';
            img.style.height = '300px'
            img.src = img.src.replace("/public", "")
        });
    }

    replaceImagesSrc();
</script>