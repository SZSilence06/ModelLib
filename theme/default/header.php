<!DOCTYPE html>      
 <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <link rel="stylesheet" href="<?php echo ML_themeDirectory()."/bootstrap-4.0.0-beta.2/css/bootstrap.min.css"; ?>">
        <link rel="stylesheet" href="<?php echo ML_stylesheet();?>"> 
    </head>

    <body>
        <div class="header">
            <div class="logo">
                <image src="<?php echo ML_themeDirectory();?>/img/logo.jpg" alt="This is logo">
            </div>
            <div class="search">
                <input id="search_input" type="text" placeholder="search">
                <button id="search_button" class="button">search</button>
            </div>
            <div class="user">
                
            </div>
        </div>

         <div class="navigator">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="list_models">View Models</a></li>
                <li><a href="post_models">Upload Model</a></li> 
                <li><a href="#">ToDo</a></li>
            </ul>
        </div>
       