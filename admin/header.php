<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>No-BS demo</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstrap-flat.css" rel="stylesheet">

        <!-- Add custom CSS here -->
        <link href="css/sb-admin.css" rel="stylesheet">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <!-- Page Specific CSS -->
        <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    </head>

    <body>

        <div id="wrapper">
            <div class="collapse navbar-collapse navbar-ex1-collapse">

                <ul class="nav navbar-nav side-nav">
                    <li class="sidenav-brand hidden-xs">
                        No <strong>BS</strong>
                        <i class="fa fa-power-off pull-right brand-button" onclick="window.location = 'index.php?logout=1'"></i>
                    </li>
                    <?php
                        $admin_helper->renderMenu($admin_menu, $menu);
                    ?>
                </ul>
            </div>
            <!-- Sidebar -->
            <nav class="navbar navbar-inverse navbar-fixed-top visible-xs" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">No <strong>BS</strong></a>
                </div>
                
                <!-- Collect the nav links, forms, and other content for toggling -->



            </nav>

            <div id="page-wrapper">