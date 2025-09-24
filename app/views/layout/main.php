<!DOCTYPE html>
<html lang="en">
    <head>
        <title>COCAF CMS | FPG Insurance</title>
        <!-- META DATA -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, maximum-scale=1.0, user-scalable=no" />

        <!-- FAVICON -->
        <link rel="icon" type="image/x-icon" href="/public/img/favicon.ico" />
        <link rel="shortcut icon" type="image/x-icon" href="/public/img/favicon.ico" />
        
        <!-- VENDOR CSS -->
        <link rel="stylesheet" href="/public/lib/font-awesome/css/font-awesome.css" />
        <link rel="stylesheet" href="/public/lib/Ionicons/css/ionicons.css" />
        <link rel="stylesheet" href="/public/lib/perfect-scrollbar/css/perfect-scrollbar.css" />
        <link rel="stylesheet" href="/public/lib/jquery-switchbutton/jquery.switchButton.css" />

        <link rel="stylesheet" href="/public/lib/highlightjs/github.css" />

        <link rel="stylesheet" href="/public/lib/medium-editor/medium-editor.css" />
        <link rel="stylesheet" href="/public/lib/medium-editor/default.css" />
        <link rel="stylesheet" href="/public/lib/summernote/summernote-bs4.css" />

        <link rel="stylesheet" href="/public/lib/datatables/jquery.dataTables.css" />
        <link rel="stylesheet" href="/public/lib/select2/css/select2.min.css" />

        <link rel="stylesheet" href="/public/lib/jquery.steps/jquery.steps.css" />
        <link rel="stylesheet" href="/public/lib/jt.timepicker/jquery.timepicker.css" />
        <link rel="stylesheet" href="/public/lib/fullcalendar/fullcalendar.css" />
        
        <!-- Bracket CSS -->
        <link rel="stylesheet" href="/public/css/bracket.css" />

        <script src="/public/lib/jquery/jquery.js"></script>
        <script src="/public/lib/popper/popper.min.js"></script>
        <script src="/public/lib/bootstrap/js/bootstrap.js"></script>
        <script src="/public/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
        <script src="/public/lib/moment/moment.js"></script>
        <script src="/public/lib/summernote/summernote-bs4.js"></script>
        <script src="/public/lib/jquery-ui/jquery-ui.js"></script>
        <script src="/public/lib/jquery-switchbutton/jquery.switchButton.js"></script>
        <script src="/public/lib/peity/jquery.peity.js"></script>
        <script src="/public/lib/select2/js/select2.min.js"></script>
        <script src="/public/lib/jt.timepicker/jquery.timepicker.js"></script>
        <script src="/public/lib/fullcalendar/fullcalendar.min.js"></script>
        <script src="/public/lib/jquery.maskedinput/jquery.maskedinput.js"></script>

        <script src="/public/js/bracket.js"></script>
        <script src="/public/js/default.js"></script>        
    </head>

    <body id="<?php echo (getVar('controller') ? getVar('controller') : '').'-'.(getVar('view') ? getVar('view') : ''); ?>">
        <?php includeCommon('side-menu'); ?>

        <!-- ########## START: HEAD PANEL ########## -->
        <div class="br-header">
            <div class="br-header-left">
                <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
                <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>
                <!--
                <form id="form_search" action="/motor/search/" method="post">
                    <div class="input-group search">                    
                        <input name="keyword" type="text" class="form-control" placeholder="Keyword..." value="<?php //echo (isset($_POST['keyword']) ? $_POST['keyword'] : ''); ?>">
                       
                        <select name="record" class="form-control" data-placeholder="Choose Record" required> 
                            <option value="Data" <?php //echo (isset($_POST['record']) && $_POST['record'] == 'Data' ? 'selected' : ''); ?> >Data</option>
                            <option value="Module" <?php //echo (isset($_POST['record']) && $_POST['record'] == 'Module' ? 'selected' : ''); ?> >Module</option>                            
                        </select>
                       
                        <span class="input-group-btn">
                            <button name="submit" class="btn bd bg-white tx-gray-600" type="submit"><i class="fa fa-search"></i></button>
                        </span>                    
                    </div>
                </form>
                -->
            </div>
            <div class="br-header-right">
                <nav class="nav">
                    <?php // includeCommon('popup-cart'); ?>
                    <?php // includeCommon('popup-message'); ?>
                    <?php // includeCommon('popup-notification'); ?>
                    <div class="dropdown">
                        <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
                            <span class="logged-name hidden-md-down">
                                <?php echo ACCOUNT_FIRSTNAME.' '.ACCOUNT_LASTNAME; ?>
                                <br>
                                <small>
                                    (<?php echo ucwords(ACCOUNT_USERNAME); ?>)
                                </small>
                            </span>
                            <img src="<?php echo displayImage(ACCOUNT_PHOTO, 'account') ?>" class="wd-32 rounded-circle" />
                            <span class="square-10 bg-success"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-header wd-250">
                            <div class="tx-center">
                                <img src="<?php echo displayImage(ACCOUNT_PHOTO, 'account') ?>" class="wd-80 rounded-circle" />
                                <h6 class="logged-fullname"><?php echo ACCOUNT_FIRSTNAME.' '.ACCOUNT_LASTNAME; ?></h6>
                                <p><?php echo ucwords(ACCOUNT_USERNAME); ?></p>
                            </div>
                            <hr>
                            <ul class="list-unstyled user-profile-nav">
                                <li><a href="/account/profile"><i class="fa fa-user-circle icon"></i> Profile</a></li>
                                <li><a href="/logout"><i class="icon ion-power"></i> Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!--
                <div class="navicon-right">
                    <a id="btnRightMenu" href="" class="pos-relative">
                        <i class="icon ion-ios-chatboxes-outline"></i>
                        <span class="square-8 bg-danger pos-absolute t-10 r--5 rounded-circle"></span>
                    </a>
                </div>
                -->
            </div>
        </div>
        <!-- ########## END: HEAD PANEL ########## -->

        <?php // includeCommon('right-panel'); ?>

        <?php require_once('routes.php'); ?>
    </body>
</html>