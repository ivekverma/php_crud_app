<?php
    if(isset($_SESSION['logedin']) && $_SESSION['logedin']==true){
        $logedin=true;   
    }
    else{
        $logedin=false;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        nav{
            width: 100%;
            background-color: black;
            color:white;
            display: flex;
            justify-content: space-between;
            padding: 10px;
            align-items: center;
            padding: 4px;
            padding-left: 20px;
        }

        nav div{
            display:flex;
        }

        a{
            width: 100px;
            height: 40px;
            padding-top: 6px;
            background-color: white;
            border-radius: 7px;
            font-weight: 700;
            text-align: center;
            margin-left: 8px;
            text-decoration: none;
            color: black;
        }

        a:hover{
            color:white;
            background:black;
            border:2px solid white;
        }

        label{
        width:100%;
        }

        .input{
        width: 100%;
        border-radius: 5px;
        margin-top: 2px;
        padding: 3px;
        padding-left: 7px;
        font-size: 17px;
        border:2px solid black;
        }

        .input:hover{
            box-shadow:0 0 5px 3px rgba(0,0,0,0.6);
        }

        button{
            width: 100px;
            height: 40px;
            background-color: white;
            border-radius: 7px;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            color: black;
            margin-top: 10px;
        }

        button:hover{
            background:black;
            color:white;
        }

        .action{
        width: auto;
        padding: 3.5px 8px;
        font-size: 12px;
        height: auto;
        }

        nav .logo h3{
            margin-right:40px;
        }

        .logo h3:hover{
            background-image: linear-gradient(2deg,blue,rgb(1, 255, 1),yellow,red);
            -webkit-background-clip: text;
            color:transparent;
        }

        nav .logo a{
            color:white;
            background:black;
        }

        .red{
        font-size: 14px;
        color: red;
        margin-bottom: 18px;
        font-weight: 500;
        }

    </style>
</head>
<body>
    <nav>
        <div class="logo">
            <h3>iNoteBook</h3>
            <a  href="/php_project/welcome.php">Home</a>
        </div>
        
        <div>
            <?php
                if(!$logedin){
                    echo '
                        <a  href="/php_project/login.php">Login</a>
                        <a  href="/php_project/signup.php">Sign Up</a>
                    ';
                }
                else{
                    echo '
                        <a  href="/php_project/logout.php">LogOut</a>
                    ';
                }
            ?>            
        </div>
    </nav>
</body>
</html>