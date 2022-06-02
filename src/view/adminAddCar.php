<body>
    <form class="form-signin" style="padding: 0 30rem;" action="/cars" method="post" enctype="multipart/form-data">
      <h1 class="h3 mb-3 font-weight-normal" style="text-align: center">Admin page</h1>
        <?php  if(isset($data['error'])){
            echo '<div class="alert alert-danger" role="alert">
        ' . $data['error'] . '
    </div>';
        }
        if(isset($data['success'])){
            echo '<div class="alert alert-success" role="alert">
        ' . $data['success'] . '
    </div>';
        }

             ?>
      <label for="inputBrand" class="sr-only">brand</label>
      <input type="text" style="margin: 1rem" id="inputBrand" class="form-control" name="brand"  placeholder="brand" required autofocus>
      <label for="inputPrice" class="sr-only">Price</label>
      <input type="text" id="inputCarPrice" class="form-control" style="margin: 1rem" name="price"  placeholder="price" required>
        <label for="inputDescription" class="sr-only">description</label>
        <input type="text" id="inputDescription" class="form-control" style="margin: 1rem" name="description"  placeholder="description" required autofocus>
        <input type="file" id="image" style="margin: 1rem" name="image">
        <button class="btn btn-lg btn-primary btn-block" style="margin: 1rem" type="submit">submit</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>
  </body>
