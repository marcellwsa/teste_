<?php require_once('../Connections/con_on.php'); ?>
<?php
session_start();
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {
  $updateSQL = sprintf("UPDATE usuarios SET usu_nome=%s, usu_email=%s, usu_senha=%s, usu_telefone=%s, usu_facebook=%s, usu_instagram=%s, usu_twitter=%s, usu_cep=%s, usu_endereco=%s, usu_bairro=%s, usu_cidade=%s, usu_complemento=%s, usu_estado=%s, usu_foto=%s WHERE usu_id=%s",
                       GetSQLValueString($_POST['nome'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['senha'], "text"),
                       GetSQLValueString($_POST['telefone'], "int"),
                       GetSQLValueString($_POST['facebook'], "text"),
                       GetSQLValueString($_POST['instagram'], "text"),
                       GetSQLValueString($_POST['twitter'], "text"),
                       GetSQLValueString($_POST['CEP'], "text"),
                       GetSQLValueString($_POST['endereco'], "text"),
                       GetSQLValueString($_POST['bairro'], "text"),
                       GetSQLValueString($_POST['cidade'], "text"),
                       GetSQLValueString($_POST['complemento'], "text"),
                       GetSQLValueString($_POST['Estado'], "text"),
                       GetSQLValueString($_POST['foto'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_con_on, $con_on);
  $Result1 = mysql_query($updateSQL, $con_on) or die(mysql_error());

  $updateGoTo = "perfil.php?atualiza=ok";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rs_usuario = "-1";
if (isset($_POST['usu_id'])) {
  $colname_rs_usuario = $_POST['usu_id'];
}
mysql_select_db($database_con_on, $con_on);
$query_rs_usuario = sprintf("SELECT * FROM usuarios WHERE usu_id = %s", GetSQLValueString($colname_rs_usuario, "int"));
$rs_usuario = mysql_query($query_rs_usuario, $con_on) or die(mysql_error());
$row_rs_usuario = mysql_fetch_assoc($rs_usuario);
$colname_rs_usuario = "-1";
if (isset($_SESSION['MM_UserId'])) {
  $colname_rs_usuario = $_SESSION['MM_UserId'];
}
mysql_select_db($database_con_on, $con_on);
$query_rs_usuario = sprintf("SELECT usuarios.*, empresa.emp_nome FROM usuarios, empresa WHERE usu_id = %s and usuarios.usu_id_empresa = empresa.emp_id", GetSQLValueString($colname_rs_usuario, "int"));
$rs_usuario = mysql_query($query_rs_usuario, $con_on) or die(mysql_error());
$row_rs_usuario = mysql_fetch_assoc($rs_usuario);
$totalRows_rs_usuario = mysql_num_rows($rs_usuario);

$colname_rs_empresa = $row_rs_usuario['usu_id_empresa'];
//if (isset($_POST['emp_id'])) {
//  $colname_rs_empresa = $_POST['emp_id'];
//}
?>
<!DOCTYPE html>
<html>

<head>

    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ON TECH | Perfil</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/plugins/switchery/switchery.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="img/profile_small.jpg" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $row_rs_usuario['usu_nome']; ?></strong>
                             </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                          <li><a href="profile.html">Profile</a></li>
                            <li><a href="contacts.html">Contacts</a></li>
                            <li><a href="mailbox.html">Mailbox</a></li>
                            <li class="divider"></li>
                            <li><a href="login.html">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
                <li>
                    <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="index.html">Dashboard v.1</a></li>
                        <li><a href="dashboard_2.html">Dashboard v.2</a></li>
                        <li><a href="dashboard_3.html">Dashboard v.3</a></li>
                        <li><a href="dashboard_4_1.html">Dashboard v.4</a></li>
                        <li><a href="dashboard_5.html">Dashboard v.5 <span class="label label-primary pull-right">NEW</span></a></li>
                    </ul>
                </li>
                <li>
                    <a href="layouts.html"><i class="fa fa-diamond"></i> <span class="nav-label">Layouts</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Graphs</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="graph_flot.html">Flot Charts</a></li>
                        <li><a href="graph_morris.html">Morris.js Charts</a></li>
                        <li><a href="graph_rickshaw.html">Rickshaw Charts</a></li>
                        <li><a href="graph_chartjs.html">Chart.js</a></li>
                        <li><a href="graph_chartist.html">Chartist</a></li>
                        <li><a href="c3.html">c3 charts</a></li>
                        <li><a href="graph_peity.html">Peity Charts</a></li>
                        <li><a href="graph_sparkline.html">Sparkline Charts</a></li>
                    </ul>
                </li>
                <li>
                    <a href="mailbox.html"><i class="fa fa-envelope"></i> <span class="nav-label">Mailbox </span><span class="label label-warning pull-right">16/24</span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="mailbox.html">Inbox</a></li>
                        <li><a href="mail_detail.html">Email view</a></li>
                        <li><a href="mail_compose.html">Compose email</a></li>
                        <li><a href="email_template.html">Email templates</a></li>
                    </ul>
                </li>
                <li>
                    <a href="metrics.html"><i class="fa fa-pie-chart"></i> <span class="nav-label">Metrics</span>  </a>
                </li>
                <li>
                    <a href="widgets.html"><i class="fa fa-flask"></i> <span class="nav-label">Widgets</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Forms</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="form_basic.html">Basic form</a></li>
                        <li><a href="form_advanced.html">Advanced Plugins</a></li>
                        <li><a href="form_wizard.html">Wizard</a></li>
                        <li><a href="form_file_upload.html">File Upload</a></li>
                        <li><a href="form_editors.html">Text Editor</a></li>
                        <li><a href="form_markdown.html">Markdown</a></li>
                    </ul>
                </li>
                <li class="active">
                    <a href="#"><i class="fa fa-desktop"></i> <span class="nav-label">App Views</span>  <span class="pull-right label label-primary">SPECIAL</span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="contacts.html">Contacts</a></li>
                        <li class="active"><a href="profile.html">Profile</a></li>
                        <li><a href="profile_2.html">Profile v.2</a></li>
                        <li><a href="contacts_2.html">Contacts v.2</a></li>
                        <li><a href="projects.html">Projects</a></li>
                        <li><a href="project_detail.html">Project detail</a></li>
                        <li><a href="teams_board.html">Teams board</a></li>
                        <li><a href="social_feed.html">Social feed</a></li>
                        <li><a href="clients.html">Clients</a></li>
                        <li><a href="full_height.html">Outlook view</a></li>
                        <li><a href="vote_list.html">Vote list</a></li>
                        <li><a href="file_manager.html">File manager</a></li>
                        <li><a href="calendar.html">Calendar</a></li>
                        <li><a href="issue_tracker.html">Issue tracker</a></li>
                        <li><a href="blog.html">Blog</a></li>
                        <li><a href="article.html">Article</a></li>
                        <li><a href="faq.html">FAQ</a></li>
                        <li><a href="timeline.html">Timeline</a></li>
                        <li><a href="pin_board.html">Pin board</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-files-o"></i> <span class="nav-label">Other Pages</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="search_results.html">Search results</a></li>
                        <li><a href="lockscreen.html">Lockscreen</a></li>
                        <li><a href="invoice.html">Invoice</a></li>
                        <li><a href="login.html">Login</a></li>
                        <li><a href="login_two_columns.html">Login v.2</a></li>
                        <li><a href="forgot_password.html">Forget password</a></li>
                        <li><a href="register.html">Register</a></li>
                        <li><a href="404.html">404 Page</a></li>
                        <li><a href="500.html">500 Page</a></li>
                        <li><a href="empty_page.html">Empty page</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-globe"></i> <span class="nav-label">Miscellaneous</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="toastr_notifications.html">Notification</a></li>
                        <li><a href="nestable_list.html">Nestable list</a></li>
                        <li><a href="agile_board.html">Agile board</a></li>
                        <li><a href="timeline_2.html">Timeline v.2</a></li>
                        <li><a href="diff.html">Diff</a></li>
                        <li><a href="i18support.html">i18 support</a></li>
                        <li><a href="sweetalert.html">Sweet alert</a></li>
                        <li><a href="idle_timer.html">Idle timer</a></li>
                        <li><a href="truncate.html">Truncate</a></li>
                        <li><a href="spinners.html">Spinners</a></li>
                        <li><a href="tinycon.html">Live favicon</a></li>
                        <li><a href="google_maps.html">Google maps</a></li>
                        <li><a href="code_editor.html">Code editor</a></li>
                        <li><a href="modal_window.html">Modal window</a></li>
                        <li><a href="clipboard.html">Clipboard</a></li>
                        <li><a href="forum_main.html">Forum view</a></li>
                        <li><a href="validation.html">Validation</a></li>
                        <li><a href="tree_view.html">Tree view</a></li>
                        <li><a href="loading_buttons.html">Loading buttons</a></li>
                        <li><a href="chat_view.html">Chat view</a></li>
                        <li><a href="masonry.html">Masonry</a></li>
                        <li><a href="tour.html">Tour</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-flask"></i> <span class="nav-label">UI Elements</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="typography.html">Typography</a></li>
                        <li><a href="icons.html">Icons</a></li>
                        <li><a href="draggable_panels.html">Draggable Panels</a></li> <li><a href="resizeable_panels.html">Resizeable Panels</a></li>
                        <li><a href="buttons.html">Buttons</a></li>
                        <li><a href="video.html">Video</a></li>
                        <li><a href="tabs_panels.html">Panels</a></li>
                        <li><a href="tabs.html">Tabs</a></li>
                        <li><a href="notifications.html">Notifications & Tooltips</a></li>
                        <li><a href="badges_labels.html">Badges, Labels, Progress</a></li>
                    </ul>
                </li>

                <li>
                    <a href="grid_options.html"><i class="fa fa-laptop"></i> <span class="nav-label">Grid options</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-table"></i> <span class="nav-label">Tables</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="table_basic.html">Static Tables</a></li>
                        <li><a href="table_data_tables.html">Data Tables</a></li>
                        <li><a href="table_foo_table.html">Foo Tables</a></li>
                        <li><a href="jq_grid.html">jqGrid</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">E-commerce</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="ecommerce_products_grid.html">Products grid</a></li>
                        <li><a href="ecommerce_product_list.html">Products list</a></li>
                        <li><a href="ecommerce_product.html">Product edit</a></li>
                        <li><a href="ecommerce_product_detail.html">Product detail</a></li>
                        <li><a href="ecommerce-cart.html">Cart</a></li>
                        <li><a href="ecommerce-orders.html">Orders</a></li>
                        <li><a href="ecommerce_payments.html">Credit Card form</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-picture-o"></i> <span class="nav-label">Gallery</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="basic_gallery.html">Lightbox Gallery</a></li>
                        <li><a href="slick_carousel.html">Slick Carousel</a></li>
                        <li><a href="carousel.html">Bootstrap Carousel</a></li>

                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">Menu Levels </span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="#">Third Level <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a href="#">Third Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level Item</a>
                                </li>

                            </ul>
                        </li>
                        <li><a href="#">Second Level Item</a></li>
                        <li>
                            <a href="#">Second Level Item</a></li>
                        <li>
                            <a href="#">Second Level Item</a></li>
                    </ul>
                </li>
                <li>
                    <a href="css_animation.html"><i class="fa fa-magic"></i> <span class="nav-label">CSS Animations </span><span class="label label-info pull-right">62</span></a>
                </li>
                <li class="landing_link">
                    <a target="_blank" href="landing.html"><i class="fa fa-star"></i> <span class="nav-label">Landing Page</span> <span class="label label-warning pull-right">NEW</span></a>
                </li>
                <li class="special_link">
                    <a href="package.html"><i class="fa fa-database"></i> <span class="nav-label">Package</span></a>
                </li>
            </ul>

        </div>
    </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="search_results.html">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                </div>
            </form>
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">Welcome to INSPINIA+ Admin Theme.</span>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/a7.jpg">
                                </a>
                                <div class="media-body">
                                    <small class="pull-right">46h ago</small>
                                    <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/a4.jpg">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right text-navy">5h ago</small>
                                    <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/profile.jpg">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right">23h ago</small>
                                    <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                    <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="mailbox.html">
                                    <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="mailbox.html">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="profile.html">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="grid_options.html">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="notifications.html">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>


                <li>
                    <a href="login.html">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>

        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Perfil</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                       
                        <li class="active">
                            <strong>Perfil</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
        
        
        <?php if($_GET['atualiza']){ ?>
        
        <div class="alert alert-info alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                Dados Atualizados com Sucesso!
                            </div>
        <?php } ?>
        
            <div class="row animated fadeInRight">
                
                <div class="col-lg-3">
                        <div class="widget-head-color-box navy-bg p-lg text-center">
                            <div class="m-b-md">
                            <h2 class="font-bold no-margins">
                              <?php echo $_SESSION['MM_UserNome']; ?> </h2>
                                <small><?php echo $row_rs_usuario['usu_profissao']; ?> na <?php echo $row_rs_usuario['emp_nome']; ?></small>
                            </div>
                            <img src="<?php echo $row_rs_usuario['usu_foto']; ?>" class="img-circle circle-border m-b-md" alt="profile" height="150px">
                          <div>
                            <button type="button" class="btn btn-outline btn-default">Alterar Imagem</button>
                            </div>
                        </div>
                        <div class="widget-text-box">
                            

                          <h2>
                                <?php echo $row_rs_usuario['usu_nome']; ?> </h2>
                        <ul class="list-unstyled m-t-md">
                            <li>
                                <span class="fa fa-envelope m-r-xs"></span>
                                <label>Email:</label>
                            <?php echo $row_rs_usuario['usu_email']; ?> </li>
                            <li>
                                <span class="fa fa-home m-r-xs"></span>
                                <label>Endereço:</label>
                            <?php echo $row_rs_usuario['usu_endereco']; ?></li>
                            <li>
                                <span class="fa fa-phone m-r-xs"></span>
                                <label>Telefone:</label>
                            <?php echo $row_rs_usuario['usu_telefone']; ?> </li>
                          </ul>
                        <p>&nbsp;</p>

                    
                    <ul class="folder-list m-b-md" style="padding: 0">
                      <li><a href="profile.html"> <i class="fa fa-inbox "></i> Contratos  </a></li>
                                <li><a href="profile.html"> <i class="fa fa-envelope-o"></i> Atividades</a></li>
                                <li><a href="profile.html"> <i class="fa fa-certificate"></i> Chamados</a></li>
                                <li><a href="profile.html"> <i class="fa fa-file-text-o"></i>Mensagens</a></li>
                                <li><a href="profile.html"> <i class="fa fa-trash-o"></i> Editar</a></li>
                          </ul>
                    
                    
                    
                    
                            
                        </div>
                </div>
                <div class="col-md-9">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Status</h5>
                            
                            <div class="switch pull-right">
                                <div class="onoffswitch">
                                    <input type="checkbox" <?php if($row_rs_usuario['usu_status']){ echo 'checked'; } ?> class="onoffswitch-checkbox" id="example1">
                                    <label class="onoffswitch-label" for="example1">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                            
                        </div>
                        <div class="ibox-content">
                            <h2>Dados Pessoais</h2>
                          <form method="POST" action="<?php echo $editFormAction; ?>" name="form" role="form" id="form" novalidate>
                                  <div class="form-group">
                                    <label>E-mail</label> <input type="email" required class="form-control" name="email" placeholder="Email" value="<?php echo $row_rs_usuario['usu_email']; ?>" aria-required="true"></div>
                                    <div class="form-group">
                                      <label>Senha</label>
                                      <input name="senha" type="password" class="form-control" placeholder="Senha" value="<?php echo $row_rs_usuario['usu_senha']; ?>"></div>
                                      
                                    <div class="form-group">
                                      <label>Nome Completo</label>
                                      <input name="nome" type="text" class="form-control" placeholder="Nome Completo" value="<?php echo $row_rs_usuario['usu_nome']; ?>"></div>
                                    <div class="form-group"><label>Telefone</label> <input name="telefone" type="text" class="form-control" placeholder="Telefone" value="<?php echo $row_rs_usuario['usu_telefone']; ?>"></div>
                                    
                                    <div class="form-group"><label>CEP</label> <input name="CEP" type="text" class="form-control" placeholder="CEP" value="<?php echo $row_rs_usuario['usu_cep']; ?>"></div>
                                    
                                    <div class="form-group"><label>Endereço</label> <input name="endereco" type="text" class="form-control" placeholder="Endereço" value="<?php echo $row_rs_usuario['usu_endereco']; ?>"></div>
                                    
                                    <div class="form-group"><label>Complemento</label> <input name="complemento" type="text" class="form-control" placeholder="Complemento" value="<?php echo $row_rs_usuario['usu_complemento']; ?>"></div>
                                    
                                    <div class="form-group"><label>Bairro</label> <input name="bairro" type="text" class="form-control" placeholder="Bairro" value="<?php echo $row_rs_usuario['usu_bairro']; ?>"></div>
                                    
                                    
                                     <div class="form-group"><label>Cidade</label> <input name="cidade" type="text" class="form-control" placeholder="Cidade" value="<?php echo $row_rs_usuario['usu_cidade']; ?>"></div>
                                    
                                    
                                  <div class="form-group"><label>Estado</label> <input name="Estado" type="text" class="form-control" placeholder="Estado" value="<?php echo $row_rs_usuario['usu_estado']; ?>"></div>
                                  
                                  <div class="form-group"><label>Empresa</label> <input name="empresa" disabled type="text" class="form-control" placeholder="Empresa" value="<?php echo $row_rs_usuario['emp_nome']; ?>"></div>
                                  
                                  <div class="form-group"><label>Profissão</label> <input name="profissao" disabled type="text" class="form-control" placeholder="Profissão" value="<?php echo $row_rs_usuario['usu_profissao']; ?>"></div>
                                    
                                    <p>&nbsp;</p>
                                    <h2>Redes Sociais</h2>
                                    <p>&nbsp;</p>
                                    
                                    
                                  <div class="form-group"><label>Facebook</label> <input name="facebook" type="text" class="form-control" placeholder="Facebook" value="<?php echo $row_rs_usuario['usu_facebook']; ?>"></div>
                                    <div class="form-group"><label>Instagram</label> <input name="instagram" type="text" class="form-control" placeholder="Instagram" value="<?php echo $row_rs_usuario['usu_instagram']; ?>"></div>
                                   
                                   <div class="form-group"><label>Twitter</label> <input name="twitter" type="text" class="form-control" placeholder="Twitter" value="<?php echo $row_rs_usuario['usu_twitter']; ?>"></div>
                                   
                                   
                                   
                                   
                                    <div>
                                        <button class="btn btn-sm btn-primary m-t-n-xs" type="submit"><strong>Salvar</strong></button>
                                    </div>
                                    
                                    <input type="hidden" name="foto" value="<?php echo $row_rs_usuario['usu_foto']; ?>">
                                    
                                    <input type="hidden" name="id" value="<?php echo $row_rs_usuario['usu_id']; ?>">
                                    <input type="hidden" name="MM_update" value="form">
                                    
                                    
                                    
                                    
                          </form>
                      </div>
                    </div>


                </div>
            </div>
        </div>
        <div class="footer">
            <div class="pull-right">
                10GB of <strong>250GB</strong> Free.
            </div>
            <div>
                <strong>Copyright</strong> Example Company &copy; 2014-2015
            </div>
        </div>

        </div>
        </div>



    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Peity -->
    <script src="js/plugins/peity/jquery.peity.min.js"></script>

    <!-- Peity -->
    <script src="js/demo/peity-demo.js"></script>
    
    <!-- switchery -->
    <script src="js/plugins/switchery/switchery.js"></script>

</body>

</html>
<?php
mysql_free_result($rs_usuario);
?>