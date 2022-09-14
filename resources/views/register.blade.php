<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>
<body>
    <form action="{{ route('register') }}" method="POST">
      @csrf
      <label for="name">Name</label>
      <input type="text" name="name"> 
      <label for="email">Email</label>
      <input type="text" name="email">
      <label for="password">Password</label>
      <input type="password" name="password">
      <label for="confirm_password">Confirm Password</label>
      <input type="password" name="confirm_password">
      <button type="submit">Register</button>
    </form>
</body>

</html>