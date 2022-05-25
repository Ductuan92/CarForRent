<link href="./assets/css/styles.css" rel="stylesheet">
</head>
<body class="text-center">
    <form class="form-signin" action="/admin" method="post">
      <h1 class="h3 mb-3 font-weight-normal">Admin page</h1>
      <label for="inputBrand" class="sr-only">brand</label>
      <input type="text" id="inputBrand" class="form-control" name="brand"  placeholder="brand" required autofocus>
      <label for="inputPrice" class="sr-only">Price</label>
      <input type="text" id="inputCarPrice" class="form-control" name="price"  placeholder="price" required>
        <label for="inputDescription" class="sr-only">description</label>
        <input type="text" id="inputDescription" class="form-control" name="description"  placeholder="description" required autofocus>
        <input type="file" id="image" name="image">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>
  </body>
