<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <h1>Login view</h1>
    <form action="{{url("login-proc")}}" method="POST">
        @csrf
        <span>email</span>
        <input type="email" name="email" id="email">
        <span>Password</span>
        <input type="password" name="pass" id="pass">
        <input type="submit" name="" id="" value="login">
    </form>
</body>
</html>