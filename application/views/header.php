<style>
      

        .clock {
            position: relative;
            width: 40px;
            height: 40px;
            border: 4px solid #333;
            border-radius: 50%;
            right: 10%;
            margin-top: -1rem;
            margin-right: -1.8rem;
        }

        .hand {
            position: absolute;
            width: 2px;
            height:15px;
            background-color: #333;
            top: 50%;
            left: 50%;
            transform-origin: 50% 100%;
            transform: translate(-100%, -100%) rotate(360deg);
            animation: ring 1s infinite alternate;
        }
        #expiry_btn
        {
            margin-top:-3.4rem;
            float:right !important;
            font-size:0.7rem;
            width:110px
        }

        @keyframes ring {
            0% {
                transform: translate(-50%, -100%) rotate(90deg);
            }
            100% {
                transform: translate(-50%, -100%) rotate(120deg);
            }
        }
    </style>
<!--  BEGIN: Header-->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="collapse navbar-collapse show" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"> </i></a></li>
                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
                    <!-- <li class="dropdown nav-item mega-dropdown d-none d-md-block"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Mega</a>
                        <ul class="mega-dropdown-menu dropdown-menu row">
                            <li class="col-md-2">
                                <h6 class="dropdown-menu-header text-uppercase mb-1"><i class="ft-link"></i> Quick Links</h6>
                                <ul>
                                    <li><a class="my-1" href="chat-application.html"><i class="ft-home"></i> Chat</a></li>
                                    <li><a class="my-1" href="table-bootstrap.html"><i class="ft-grid"></i> Tables</a></li>
                                    <li><a class="my-1" href="chartist-charts.html"><i class="ft-bar-chart"></i> Charts</a></li>
                                    <li><a class="my-1" href="gallery-grid.html"><i class="ft-sidebar"></i> Gallery</a></li>
                                </ul>
                            </li>
                            <li class="col-md-3">
                                <h6 class="dropdown-menu-header text-uppercase mb-1"><i class="ft-star"></i> My Bookmarks</h6>
                                <ul class="ml-2">
                                    <li class="list-style-circle"><a class="my-1" href="card-bootstrap.html">
                                            Cards</a></li>
                                    <li class="list-style-circle"><a class="my-1" href="full-calender.html"> Calender</a></li>
                                    <li class="list-style-circle"><a class="my-1" href="invoice-template.html"> Invoice</a></li>
                                    <li class="list-style-circle"><a class="my-1" href="users-contacts.html"> Contact</a></li>
                                </ul>
                            </li>
                            <li class="col-md-3">
                                <h6 class="dropdown-menu-header text-uppercase"><i class="ft-layers"></i> Recent Products</h6>
                                <div class="carousel slide pt-1" id="carousel-example" data-ride="carousel">
                                    <div class="carousel-inner" role="listbox">
                                        <div class="carousel-item active"><img class="d-block w-100" src="<?=base_url()?>static/app-assets/images/carousel/08.jpg" alt="First slide"></div>
                                        <div class="carousel-item"><img class="d-block w-100" src="<?=base_url()?>static/app-assets/images/carousel/03.jpg" alt="Second slide"></div>
                                        <div class="carousel-item"><img class="d-block w-100" src="<?=base_url()?>static/app-assets/images/carousel/01.jpg" alt="Third slide"></div>
                                    </div><a class="carousel-control-prev" href="#carousel-example" role="button" data-slide="prev"><span class="la la-angle-left" aria-hidden="true"></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#carousel-example" role="button" data-slide="next"><span class="la la-angle-right icon-next" aria-hidden="true"></span><span class="sr-only">Next</span></a>
                                    <h5 class="pt-1">Special title treatment</h5>
                                    <p>Jelly beans sugar plum.</p>
                                </div>
                            </li>
                            <li class="col-md-4">
                                <h6 class="dropdown-menu-header text-uppercase mb-1"><i class="ft-thumbs-up"></i> Get in touch</h6>
                                <form class="form form-horizontal pt-1">
                                    <div class="form-body">
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label" for="inputName1">Name</label>
                                            <div class="col-sm-9">
                                                <div class="position-relative has-icon-left">
                                                    <input class="form-control" id="inputName1" type="text" placeholder="John Doe">
                                                    <div class="form-control-position pl-1"><i class="ft-user"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label" for="inputContact1">Contact</label>
                                            <div class="col-sm-9">
                                                <div class="position-relative has-icon-left">
                                                    <input class="form-control" id="inputContact1" type="text" placeholder="(123)-456-7890">
                                                    <div class="form-control-position pl-1"><i class="ft-smartphone"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label" for="inputEmail1">Email</label>
                                            <div class="col-sm-9">
                                                <div class="position-relative has-icon-left">
                                                    <input class="form-control" id="inputEmail1" type="email" placeholder="john@example.com">
                                                    <div class="form-control-position pl-1"><i class="ft-mail"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label" for="inputMessage1">Message</label>
                                            <div class="col-sm-9">
                                                <div class="position-relative has-icon-left">
                                                    <textarea class="form-control" id="inputMessage1" rows="2" placeholder="Simple Textarea"></textarea>
                                                    <div class="form-control-position pl-1"><i class="ft-message-circle"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 mb-1">
                                                <button class="btn btn-danger float-right" type="button"><i class="ft-arrow-right"></i> Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </li> -->
                    <!-- <li class="dropdown d-none d-md-block mr-1"><a class="dropdown-toggle nav-link" id="apps-navbar-links" href="#" data-toggle="dropdown">
                            Apps</a>
                        <div class="dropdown-menu">
                            <div class="arrow_box"><a class="dropdown-item" href="email-application.html"><i class="ft-user"></i> Email</a><a class="dropdown-item" href="chat-application.html"><i class="ft-mail"></i> Chat</a><a class="dropdown-item" href="project-summary.html"><i class="ft-briefcase"></i> Project Summary </a><a class="dropdown-item" href="full-calender.html"><i class="ft-calendar"></i> Calendar </a></div>
                        </div>
                    </li> -->
                    <li class="nav-item dropdown navbar-search"><a class="nav-link dropdown-toggle hide" data-toggle="dropdown" href="#"><i class="ficon ft-search"></i></a>
                        <ul class="dropdown-menu">
                            <li class="arrow_box">
                                <form>
                                    <div class="input-group search-box">
                                        <div class="position-relative has-icon-right full-width">
                                            <input class="form-control" id="search" type="text" placeholder="Search here...">
                                            <div class="form-control-position navbar-search-close"><i class="ft-x"></i></div>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
              
                <ul class="nav navbar-nav float-right">
                <?php if($user->user_role  !=1 && $user->user_role  !=2){?>
                <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="clock">
                     <div class="hand"></div>
                       </div>
                      </a>
                      
                    </li>
                    <li class="dropdown dropdown-language nav-item" style="width: 360px;"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <div id="countdown" style="font-size:1.4rem"></div>
                       <?php
                        $renewPlanUrl = base_url('renew-plan/' . @$_COOKIE['property_id']);
                        ?>
						 <?php if($user->user_role ==4){?>
                       <span  >
                        <?php if(!empty(@$_COOKIE['property_id'])){?>
                        <a  id="expiry_btn" class="btn btn-sm btn-primary" target="_blank" href="<?php echo $renewPlanUrl; ?>">Manage Plan</a>
                        <?php }else{?>
                    <a  id="expiry_btn" class="btn btn-sm btn-primary" target="_blank" href="<?=base_url('dashboard');?>">Manage Plan</a>
                        <?php }?>
                        </span>
						<?php }?>
                      </a>
                      
                    </li>
                    <?php }?>
                   <!--  <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-bell bell-shake" id="notification-navbar-link"></i><span class="badge badge-pill badge-sm badge-info badge-up badge-glow">5</span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <div class="arrow_box_right">
                                <li class="dropdown-menu-header">
                                    <h6 class="dropdown-header m-0"><span class="grey darken-2">Notifications</span></h6>
                                </li>
                                <li class="scrollable-container media-list w-100"><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i class="ft-plus-square icon-bg-circle bg-cyan"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">You have new order!</h6>
                                                <p class="notification-text font-small-3 text-muted">Lorem ipsum dolor sit amet, consectetuer elit.</p><small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">30 minutes ago</time></small>
                                            </div>
                                        </div>
                                    </a><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i class="ft-download-cloud icon-bg-circle bg-red bg-darken-1"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading red darken-1">99% Server load</h6>
                                                <p class="notification-text font-small-3 text-muted">Aliquam tincidunt mauris eu risus.</p><small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Five hour ago</time></small>
                                            </div>
                                        </div>
                                    </a><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i class="ft-alert-triangle icon-bg-circle bg-yellow bg-darken-3"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading yellow darken-3">Warning notifixation</h6>
                                                <p class="notification-text font-small-3 text-muted">Vestibulum auctor dapibus neque.</p><small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Today</time></small>
                                            </div>
                                        </div>
                                    </a><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i class="ft-check-circle icon-bg-circle bg-cyan"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Complete the task</h6><small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Last week</time></small>
                                            </div>
                                        </div>
                                    </a><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i class="ft-file icon-bg-circle bg-teal"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Generate monthly report</h6><small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Last month</time></small>
                                            </div>
                                        </div>
                                    </a></li>
                                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all notifications</a></li>
                            </div>
                        </ul>
                    </li>-->
                    <li class="dropdown dropdown-notification nav-item">
                        <?php if($user->user_role  !=1 && $user->user_role  !=2){?>
                    <div class="form-group col-12 mt-1 ml-2">
                        <!-- <h6 for="propmaster">Property</h6>                         -->
                        <select id="propmaster" name="propmaster" class="form-control propmaster">
                        <?php
                        $prop_list = 'list';
                        $rows= $this->model->host_propmaster_dropdown($prop_list);
                            echo optionStatus('','-- Select Property --');
                            foreach ($rows as $row) {
                                $title = $row->propname .'( '.$row->propcodename.' ) - '.title('cities',$row->city,'id','name');
                                $select = (@$_COOKIE['property_id'] == $row->id) ? 'selected' : '';
                                echo optionStatus($row->id,$title,$row->status,$select);
                            }
                        ?>
                        </select>
                    </div>
                    <?php }?>
                    </li>
                    <style>
                        span.user-name{
                         display: block;
                          width: 100px;
                        white-space: wrap;
                        margin-top: 10px;
                        }
                    </style>
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"> <span class="avatar avatar-online">
                    <?php if($user->user_role==4){?>
            <img class="brand-logo" alt="Chameleon admin logo" src="<?=$logo?>" onerror="this.src='<?=base_url()?>assets/photo/noimage/logo2.png';" style="width: 100%; max-height: 120px;border-radius:50%" />
            <?php }else{?>
                <img class="brand-logo img-fluid" alt="Chameleon admin logo" src="<?=$admin_logo?>" onerror="this.src='<?=base_url()?>assets/photo/noimage/logo2.png';" style="width: 100%; max-height: 120px;border-radius:50%" > 
            <?php }?>
                        <i></i></span></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="arrow_box_right">
                                <a class="dropdown-item" href="#">
                                    <span class="avatar avatar-online">
                                    <?php if($user->user_role==4){?>
            <img class="brand-logo" alt="Chameleon admin logo" src="<?=$logo?>" onerror="this.src='<?=base_url()?>assets/photo/noimage/logo2.png';" style="width: 100%;height: 40px;border-radius:50%" />
            <?php }else{?>
                <img class="brand-logo img-fluid" alt="Chameleon admin logo" src="<?=$admin_logo?>" onerror="this.src='<?=base_url()?>assets/photo/noimage/logo2.png';" style="width: 100%; max-height: 120px;border-radius:50%" > 
            <?php }?>
                                        <span class="user-name text-bold-700 ml-1">
                                            <?=$user->name?>
                                        </span>
                                    </span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?=base_url('admin_profile')?>">
                                    <i class="ft-user"></i> Edit Profile
                                </a>
                                <?php if($user->user_role==4){?>
                                 <a class="dropdown-item" href="<?=base_url();?>my-plans">
                                    <i class="ft-file"></i> My Plans
                                </a>
                                <?php }?>
                               <!-- <a class="dropdown-item" href="#">
                                    <i class="ft-check-square"></i> Task
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="ft-message-square"></i> Chats
                                </a> -->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?=base_url()?>logout">
                                    <i class="ft-power"></i> Logout 
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- END: Header
                    -->

  <?php if($user->user_role  !=1 && $user->user_role  !=2){ ?>
    <?php
// Assuming this script is embedded in a PHP file, and $package is defined elsewhere.
// If $package is not defined, set default values to prevent errors.
$added = isset($package->added) ? $package->added : '00:00:00';
$no_of_days = isset($package->no_of_days) ? $package->no_of_days : 0;
?>

<script>
var addedDate = new Date('<?= $added ?>');
var property = ('<?= $property ?>');
var targetDate = new Date(addedDate);
if(property===''){
    document.getElementById('countdown').innerHTML = 'Please Select Property';
}else{
targetDate.setDate(targetDate.getDate() + <?= $no_of_days ?>);

if (isNaN(targetDate.getTime())) {
    document.getElementById('countdown').innerHTML = 'Your plan not active';
} else {
    var countdownInterval = setInterval(function() {
        var currentDate = new Date().getTime();
        var remainingTime = targetDate - currentDate;

        if (remainingTime <= 0) {
            clearInterval(countdownInterval);
            document.getElementById('countdown').innerHTML = '<span class="text-warning">Plan expired!</span>';
            // $('#expiry_btn').removeClass('d-none');
        } else {
            var days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
            var hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

            document.getElementById('countdown').innerHTML = days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's';
        }
    }, 1000);
}
}
</script>

<!-- <script>
var targetDate =new Date('<?//= isset($package->added) ? $package->added : '00:00:00'; ?>');
targetDate.setDate(targetDate.getDate() + <?//= isset($package->no_of_days) ? $package->no_of_days : '0'; ?>);
var countdownInterval = setInterval(function() {
    var currentDate = new Date().getTime();

    var remainingTime = targetDate - currentDate;

    var days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
    var hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

    document.getElementById('countdown').innerHTML = days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's';

    if (remainingTime <= 0) {
        clearInterval(countdownInterval);
        document.getElementById('countdown').innerHTML = '<span class="text-warning">Plan expired!</span>';
        $('#expiry_btn').removeClass('d-none');
    }
}, 1000); 
</script>            -->
<?php }?>
<script type="text/javascript">
    setTimeout(function() {
        if (!$('body').hasClass('menu-collapsed')) {
            sidebar_hide();
        }
    }, 1000);

    function setCookie(cname, cvalue, exdays) {
      const d = new Date();
      d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
      let expires = "expires="+d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
      let name = cname + "=";
      let ca = document.cookie.split(';');
      for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }

    $(document).on('change','.propmaster',function(event) {
       var value = $(this).val();
       setCookie('property_id', value, 365);
        const reloadUsingLocationHash = () => { 
      window.location.hash = "reload"; 
    } 
    window.onload = reloadUsingLocationHash(); 
       //$('#tb').load('<?=base_url()?>propCalendar/calendar/'+value);
       // $.post('<?=base_url()?>propCalendar/calendar/'+value)
   })
</script>
