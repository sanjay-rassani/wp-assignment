<?php
session_start();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <style>
        img{
            width: 80vw;
        }
    </style>
</head>

<body>
    <?php require_once './header.php' ?>

    <div class="container">


        <h1 id="bloghost-and-todo-web-assignment">BlogHost and Todo Web Assignment</h1>
        <h2 id="implementations">Implementations</h2>
        <ol>
            <li>Like and Dislike functions.<ul>
                    <li>On .../post.php page registered users can like and dislike the post.</li>
                </ul>
            </li>
            <li>Add New or Edit Posts.<ul>
                    <li>Registered user can post new articles and can edit as well.</li>
                </ul>
            </li>
            <li>Enable and disable public visibility.<ul>
                    <li>Users can control the visibility of their post.</li>
                </ul>
            </li>
            <li>Read Posts.<ul>
                    <li>Read count will be updated by +1 when unique user reads post first time only.</li>
                </ul>
            </li>
            <li>Comments.<ul>
                    <li>New comments on post.</li>
                    <li>Comments read section on post page.</li>
                </ul>
            </li>
            <li>User Profile.<ul>
                    <li>Shows totall likes.</li>
                    <li>Shows totall Comments.</li>
                    <li>Shows totall Posts Count.</li>
                </ul>
            </li>
            <li>Registration.<ul>
                    <li>User can register with unique name only.</li>
                </ul>
            </li>
            <li>Todo Session based with following features<ul>
                    <li>Categorised Tasks</li>
                    <li>Custom Prioritised Tasks</li>
                    <li>Checkbox to mark completion.</li>
                    <li>Delete Button to remove task.</li>
                </ul>
            </li>
        </ol>
    </div>
</body>

</html>