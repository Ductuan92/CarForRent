<link href="./assets/css/styles.css" rel="stylesheet">
</head>
<body class="text-center">
    <form class="form-signin" action="/cars" method="post" enctype="multipart/form-data">
      <h1 class="h3 mb-3 font-weight-normal">Admin page</h1>
        <?php if(isset($data['error']))
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        ' . $data['error'] . '
    </div>';
        if(isset($data['success'])){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        ' . $data['success'] . '
    </div>';
        }

             ?>
      <label for="inputBrand" class="sr-only">brand</label>
      <input type="text" id="inputBrand" class="form-control" name="brand"  placeholder="brand" required autofocus>
      <label for="inputPrice" class="sr-only">Price</label>
      <input type="text" id="inputCarPrice" class="form-control" name="price"  placeholder="price" required>
        <label for="inputDescription" class="sr-only">description</label>
        <input type="text" id="inputDescription" class="form-control" name="description"  placeholder="description" required autofocus>
        <input type="file" id="image" name="image">
        <button class="btn btn-lg btn-primary btn-block" type="submit">submit</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>
  </body>
