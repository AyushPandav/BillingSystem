<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    .center-this-sec{
       justify-content: center;
       align-items: center;
       margin-top: 20%;
       border: 1px solid black;
       margin-left: 30%;
       margin-right: 30%;
       padding-bottom: 25px;
       border-radius: 30px;
       color: white;
       background-color: rgb(148, 148, 148);
        }
    .proceed{
        text-align: center
    }
    </style>
</head>
<body>
    <section class="center-this-sec">
   <h1 style="text-align: center">Welcome to Our Shop</h1>
   <div class="proceed">
       <a href="{{route('billing.index')}}">Goo to Billing</a>
       <a href="{{route('billing.history')}}">Check History</a>
   </div>
</section>
</body>
</html>
