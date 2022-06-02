

<header>
    <?php

    if (isset($_SESSION['user'])) {
        echo $_SESSION['user'];
    } ?>


    <main role="main">
        <div class="album py-5 bg-light">

            <h1 align="center">Cars available:</h1>
            <div class="container">

                <div class="row">
                    <?php
                        if(isset($data)){
                            foreach ($data as $car){
                                ?>
                                <div class="col-md-4">
                                    <div class="card mb-4 box-shadow">
                                        <img class="card-img-top"
                                             src="<?php echo $car->getImage()?>"
                                             alt="Card image cap">
                                        <div class="card-body">
                                            <p class="card-text"><?php echo $car->getBrand() ?></p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group" style="bottom: 0;">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">Add</button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">Buy now</button>
                                                </div>
                                                <small class="text-muted"><?php echo $car->getPrice() ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    ?>

                </div>
            </div>
        </div>

    </main>
</header>
    <footer class="text-muted">
        <div class="container">
            <p class="float-right">
                <a href="#">Back to top</a>
            </p>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
</body>
</html>
