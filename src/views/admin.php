<?php

require_once "bootstrap.php";

/*  LOGOUT   */
session_start();
if (isset($_POST['logout'])) {
    session_start();
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['logged_in']);
    header('Location: http://localhost/CMS');
    exit;
}

/*  LOGIN   */
if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    if ($_POST['username'] == 'Admin' && $_POST['password'] == '1234') {
        $_SESSION['logged_in'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['username'] = 'Admin';
    } else {
        print('<p class="error" style="color: red;">ERROR: Invalid username or password. Please try again.</p>');
    }
}

/*  SUCCESSFULLY LOGGED IN  */
if ($_SESSION['logged_in'] == true) {

    /*  DELETE  */
    if (isset($_POST['delete'])) {
        $page = $entityManager->find('Page', $_POST['delete']);
        $entityManager->remove($page);
        $entityManager->flush();
        crntDir();
    }

    /*  EDIT, ADD NEW PAGE and SHOW PAGES TABLE */
    if (isset($_POST['edit'])) {
        $page = $entityManager->find('Page', $_POST['edit']);
        getAdminNav();
        print('<p class="actionName">Edit pages</p>');
        print('<form class="actions additional" action="" method="POST">
                    <input type="hidden" name="updateId" value="' . $page->getId() . '">
                    <label for="name">Title:</label><br>
                    <input type="text" name="title" value="' . $page->getName() . '"><br>
                    <label for="content">Content:</label><br>
                    <textarea id="content" name="content">' . $page->getContent() . '</textarea><br>
                    <button class="btn btn-primary" type="submit" name="update">Submit</button>
                    <button class="btn btn-danger" type="submit" name="cancel">Cancel</button>
                </form>');
    } elseif (isset($_POST['addNew'])) {
        getAdminNav();
        print('<p class="actionName">Add new page</p>');
        print('<form class="actions additional" action="" method="POST">
                <label for="title">Title:</label><br>
                <input type="hidden" name="title" value="title">
                <input type="text" id="title" name="title"><br>
                <label for="content">Content:</label><br>
                <textarea id="content" name="content"></textarea><br>
                <button class="btn btn-primary" type="submit" name="newPage">Submit</button>
                <button class="btn btn-danger" type="submit" name="cancel">Cancel</button>
            </form>');
    } else {
        // Navigation
        getAdminNav();
        print('<p class="actionName">Manage pages</p>');
        // Table of pages 
        getTable($entityManager);
        // ADD button
        print('<form class="actions addPage" action="" method="POST">
            <button class="btn btn-primary" type="submit" name="addNew">Add New Page</button>
        </form>');
    }

    /*  UPDATE/EDIT  */
    if (isset($_POST['update'])) {
        $page = $entityManager->find('Page', $_POST['updateId']);
        $title = $_POST['title'];
        $content = $_POST['content'];
        $page->setName($title);
        $page->setContent($content);
        $entityManager->flush();
        crntDir();
    }

    /*  ADD NEW PAGE  */
    if (isset($_POST['newPage']) && !empty($_POST['title']) && !empty($_POST['content'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $page = new Page();
        $page->setName($title);
        $page->setContent($content);
        $entityManager->persist($page);
        $entityManager->flush();
        crntDir();
    }

    /*  CANCEL button */
    if (isset($_POST['cancel'])) {
        crntDir();
    }
} else { // print Log In form before Admin logged in 
    print('<form class="loginForm" action="" method="post">
                <input class="loginInput" type="text" name="username" placeholder="username - Admin" required autofocus></br>
                <input class="loginInput" type="password" name="password" placeholder="password - 1234" required><br><br>
                <button class="btn btn-primary" type="submit" name="login">Log In</button>
            </form>');
}

/*  FUNCTIONS   */
// current directory
function crntDir()
{
    header('Location: http://localhost/CMS/admin_page');
}
// print ADMIN navigation
function getAdminNav()
{
    print('<nav class="navigation">
            <div class="nav"><a href="./admin_page">Admin</a></div>
            <div class="nav"><a href="./">View Website</a></div>
            <div class="nav"><form class="logout" action="" method="post">
                <button class="logoutButton" type="submit" name="logout">Logout</button>
            </form></div>
        </nav>');
}

// print Pages table
function getTable($entityManager)
{
    $pages = $entityManager->getRepository("Page")->findAll();
    print('<table class="table table-bordered">
            <thead class="head">
                <tr>
                    <th>Title</th>
                    <th>Actions</th>
                <tr>
            <thead>');
    foreach ($pages as $page) {
        print('<tr>');
        if ($page->getName() == "Home") {
            // print("<button type='submit' name='edit'><a href='?action=edit&id={$page->getId()}'>EDIT</button>");
            print('<td>' . $page->getName() . '</td>
                    <td><form class="actions" action="" method="POST">
                    <button class="btn btn-primary" type="submit" name="edit" value="' . $page->getId() . '">Edit</button>
                </form></td>');
        } else {
            print('<td>' . $page->getName() . '</td>');
            print('<td><form class="actions" action="" method="POST">
                    <button class="btn btn-primary" type="submit" name="edit" value="' . $page->getId() . '">Edit</button>
                    <button class="btn btn-default" type="submit" name="delete" value="' . $page->getId() . '">Delete</button>
                </form></td></tr>');
        }
    }
    print('</table>');
}
