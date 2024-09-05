<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true" data-img="<?=base_url()?>static/app-assets/images/backgrounds/04.jpg">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row position-relative">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="<?=base_url('dashboard')?>">
             <?php if($user->user_role==4){?>
            <img class="brand-logo" alt="Chameleon admin logo" src="<?=$logo?>" onerror="this.src='<?=base_url()?>assets/photo/noimage/logo2.png';" style="width: 80%; max-height: 70px;margin-top:-0.7rem" />
            <?php }else{?>
                <img class="brand-logo img-fluid" alt="Chameleon admin logo" src="<?=$admin_logo?>" onerror="this.src='<?=base_url()?>assets/photo/noimage/logo2.png';" style="width: 80%; max-height: 70px;margin-top:-0.7rem" > 
            <?php }?>
                    <!-- <h3 class="brand-text"><?=$comp?></h3> -->
                </a></li>
            <li class="nav-item d-none d-md-block nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="toggle-icon ft-disc font-medium-3" data-ticon="ft-disc"></i></a></li>
            <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
        </ul>
    </div>
    <div class="navigation-background"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <?=$menu?>


           <!--  <li class="nav-item has-sub hover">
                <a href="#">
                    <i class="la la-building"></i>
                    <span class="menu-title" data-i18n="">Accounts</span>
                </a>
                <ul class="menu-content" style="">
                    <li class="">
                        <a class="menu-item" href="http://localhost/sites/mrs/account">
                            Dashbord
                        </a>
                    </li>
                    <li class="">
                        <a class="menu-item" href="http://localhost/sites/mrs/expenses">
                            Manage Expanses  
                        </a>
                    </li>
                </ul>
            </li> -->
        </ul>
    </div>
</div>
<!-- END: Main Menu-->