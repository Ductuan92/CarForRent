<body >
    <form class="form-signin" action="/user/login" method="post" style="padding: 0 30rem;">
      <img class="mb-4" style="display: block;margin-left: auto;margin-right: auto;width: 40%;" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal" style="text-align: center">Please sign in</h1>
      <label for="inputUserName" class="sr-only">User Name</label>
      <input type="text" id="inputUserName" class="form-control" name="userName"  placeholder="User Name" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" class="form-control" name="password"  placeholder="Password" required>

      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>

        <?php

        if ($data!=null && array_key_exists('error', $data)) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        ' . $data["error"] . '
    </div>';
        }

        ?>

      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>
  </body>
