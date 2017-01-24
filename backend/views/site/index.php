<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>


<div style="margin-top: 50px;">
    
    <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graph x_panel">
            <div class="row x_title">
                <div class="col-md-6">
                    <h3>Customer List <small style="font-style: italic;">Search by: Customer Name/Carplate/Parts Name/Service Name.</small></h3>
                </div>
                <div class="col-md-6">
            
                </div>
            </div>
            <div class="x_content">
                <h3>"Under-Construction."</h3>
            </div>
        </div>
    </div>

    </div>
    <br/>

    <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graph x_panel">
            <div class="row x_title">
                <div class="col-md-6">
                    <h4><i class="fa fa-warning"></i> Pending Quotation Services </h4>
                </div>
            </div>

            <table class="table table-boardered table-striped">
                <thead>
                    <tr class="headings">
                        <td class="tblalign_center" ><b> DATE ISSUE </b></td>
                        <td class="tblalign_center" ><b> BRANCH NAME </b></td>
                        <td class="tblalign_center" ><b> SALES PERSON </b></td>
                        <td class="tblalign_center" ><b> QUOTATION CODE </b></td>
                        <td class="tblalign_center" ><b> CUSTOMER NAME </b></td>
                        <td class="tblalign_center" ><b> SERVICE NAME </b></td>
                        <td class="tblalign_center" ><b> QUANTITY </b></td>
                        <td class="tblalign_center" ><b> SELLING PRICE </b></td>
                        <td class="tblalign_center" ><b> CHECK SERVICE </b></td>
                    </tr>
                </thead>
                <tbody>
                    <?php if( !empty($pendingServices) ): ?>
                        <?php foreach( $pendingServices as $pRow): ?>
                            <tr>
                                <td class="tblalign_center" ><?php echo date('m-d-Y', strtotime($pRow['date_issue']) ); ?></td>
                                <td class="tblalign_center" ><?php echo $pRow['name']; ?></td>
                                <td class="tblalign_center" ><?php echo $pRow['salesPerson']; ?></td>
                                <td class="tblalign_center" ><?php echo $pRow['quotation_code']; ?></td>
                                <td class="tblalign_center" ><?php echo $pRow['fullname']; ?></td>
                                <td class="tblalign_center" ><?php echo $pRow['service_name']; ?></td>
                                <td class="tblalign_center" ><?php echo $pRow['quantity']; ?></td>
                                <td class="tblalign_center" ><?php echo $pRow['selling_price']; ?></td>
                                <td class="tblalign_center" ><a href="?r=quotation/view&id=<?php echo $pRow['quotationId']; ?>" > <i class="fa fa-search"></i> </a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td><span>No Record Found.</span></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    </div>
    <br/>

    <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graph x_panel">
            <div class="row x_title">
                <div class="col-md-6">
                    <h4><i class="fa fa-warning"></i> Pending Invoice Services </h4>
                </div>
            </div>

            <table class="table table-boardered table-striped">
                <thead>
                    <tr class="headings">
                        <td class="tblalign_center" ><b> DATE ISSUE </b></td>
                        <td class="tblalign_center" ><b> BRANCH NAME </b></td>
                        <td class="tblalign_center" ><b> SALES PERSON </b></td>
                        <td class="tblalign_center" ><b> INVOICE NUMBER </b></td>
                        <td class="tblalign_center" ><b> CUSTOMER NAME </b></td>
                        <td class="tblalign_center" ><b> SERVICE NAME </b></td>
                        <td class="tblalign_center" ><b> QUANTITY </b></td>
                        <td class="tblalign_center" ><b> SELLING PRICE </b></td>
                        <td class="tblalign_center" ><b> CHECK SERVICE </b></td>
                    </tr>
                </thead>
                <tbody>
                    <?php if( !empty($pendingInvoiceServices) ): ?>
                        <?php foreach( $pendingInvoiceServices as $iRow): ?>
                            <tr>
                                <td class="tblalign_center" ><?php echo date('m-d-Y', strtotime($iRow['date_issue']) ); ?></td>
                                <td class="tblalign_center" ><?php echo $iRow['name']; ?></td>
                                <td class="tblalign_center" ><?php echo $iRow['salesPerson']; ?></td>
                                <td class="tblalign_center" ><?php echo $iRow['invoice_no']; ?></td>
                                <td class="tblalign_center" ><?php echo $iRow['fullname']; ?></td>
                                <td class="tblalign_center" ><?php echo $iRow['service_name']; ?></td>
                                <td class="tblalign_center" ><?php echo $iRow['quantity']; ?></td>
                                <td class="tblalign_center" ><?php echo $iRow['selling_price']; ?></td>
                                <td class="tblalign_center" ><a href="?r=invoice/view&id=<?php echo $iRow['invoiceId']; ?>" > <i class="fa fa-search"></i> </a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td><span>No Record Found.</span></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    </div>
    <br/>

    <div class="row">

    <div class="col-md-4 col-sm-4 col-xs-12">

    <div class="x_panel">

    <div class="x_title">
        <h5><b><i class="fa fa-cog"></i> Parts in Warning Stock</b></h5>
        <ul class="nav navbar-right panel_toolbox"></ul>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">
        <div class="dashboard-widget-content">

            <ul class="list-unstyled timeline widget">
               <?php if( !empty($getWarningStock) ): ?>
                   <?php foreach( $getWarningStock as $wStock ): ?>        
                        <li>
                            <div class="block">
                                <div class="block_content">
                                    <h2 class="title"><a style="font-size: 11px; text-transform: uppercase; font-family: Tahoma;"><center><?php echo $wStock['product_name']; ?></center></a></h2>
                                </div>
                            </div>
                        </li>   
                    <?php endforeach; ?>
                        <div style="text-align: right;font-style: italic; font-size: 11.5px; font-family: Tahoma;"><a>See All (<?php echo count( $getWarningStock ); ?>)</a></div>
                <?php else: ?>

                    <li>
                        <div class="block">
                            <div class="block_content">
                                <h2 class="title"><a style="font-size: 12px;">No Record Found.</a></h2>
                            </div>
                        </div>
                    </li>  

                <?php endif; ?>
            </ul>

        </div>
    </div>

    </div>

    </div>


    <div class="col-md-4 col-sm-4 col-xs-12">

    <div class="x_panel">

    <div class="x_title">
        <h5><b><i class="fa fa-cog"></i> Parts in Critical Stock</b></h5>
        <ul class="nav navbar-right panel_toolbox"></ul>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">
        <div class="dashboard-widget-content">

            <ul class="list-unstyled timeline widget">
               <?php if( !empty($getCriticalStock) ): ?>
                   <?php foreach( $getCriticalStock as $cStock ): ?>        
                        <li>
                            <div class="block">
                                <div class="block_content">
                                    <h2 class="title"><a style="font-size: 11px; text-transform: uppercase; font-family: Tahoma;"><center><?php echo $cStock['product_name']; ?></center></a></h2>
                                </div>
                            </div>
                        </li>   
                    <?php endforeach; ?>
                        <div style="text-align: right;font-style: italic; font-size: 11.5px; font-family: Tahoma;"><a>See All (<?php echo count( $getCriticalStock ); ?>)</a></div>
                <?php else: ?>

                    <li>
                        <div class="block">
                            <div class="block_content">
                                <h2 class="title"><a style="font-size: 12px;">No Record Found.</a></h2>
                            </div>
                        </div>
                    </li>  

                <?php endif; ?>
            </ul>

        </div>
    </div>

    </div>

    </div>


    <div class="col-md-4 col-sm-4 col-xs-12">

    <div class="x_panel">

    <div class="x_title">
        <h5><b><i class="fa fa-cog"></i> Parts in Zero Stock</b></h5>
        <ul class="nav navbar-right panel_toolbox"></ul>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">
        <div class="dashboard-widget-content">

            <ul class="list-unstyled timeline widget">
               <?php if( !empty($getZeroStock) ): ?>
                   <?php foreach( $getZeroStock as $zStock ): ?>        
                        <li>
                            <div class="block">
                                <div class="block_content">
                                    <h2 class="title"><a style="font-size: 11px; text-transform: uppercase; font-family: Tahoma;"><center><?php echo $zStock['product_name']; ?></center></a></h2>
                                </div>
                            </div>
                        </li>   
                    <?php endforeach; ?>
                        <div style="text-align: right;font-style: italic; font-size: 11.5px; font-family: Tahoma;"><a>See All (<?php echo count( $getZeroStock ); ?>)</a></div>
                <?php else: ?>

                    <li>
                        <div class="block">
                            <div class="block_content">
                                <h2 class="title"><a style="font-size: 12px;">No Record Found.</a></h2>
                            </div>
                        </div>
                    </li>  

                <?php endif; ?>
            </ul>

        </div>
    </div>

    </div>

    </div>
    <br/>

    </div>

</div>

<!-- <div class="row top_tiles" style="margin: 10px 0; border: solid 1px red;">
<div class="col-md-3 col-sm-3 col-xs-6 tile">
    <span>Total Sessions</span>
    <h2>231,809</h2>
    <span class="sparkline_one" style="height: 160px;">
<canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
</span>
</div>
<div class="col-md-3 col-sm-3 col-xs-6 tile">
    <span>Total Revenue</span>
    <h2>$ 231,809</h2>
    <span class="sparkline_one" style="height: 160px;">
<canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
</span>
</div>
<div class="col-md-3 col-sm-3 col-xs-6 tile">
    <span>Total Sessions</span>
    <h2>231,809</h2>
    <span class="sparkline_two" style="height: 160px;">
<canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
</span>
</div>
<div class="col-md-3 col-sm-3 col-xs-6 tile">
    <span>Total Sessions</span>
    <h2>231,809</h2>
    <span class="sparkline_one" style="height: 160px;">
<canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
</span>
</div>
</div> -->

<!-- <div class="col-md-4 col-sm-6 col-xs-12">
<div class="x_panel fixed_height_320">
    <div class="x_title">
        <h2>Daily active users <small>Sessions</small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Settings 1</a>
                    </li>
                    <li><a href="#">Settings 2</a>
                    </li>
                </ul>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <table class="tile" style="width:100%">
            <tr>
                <th style="width:37%;">
                    <span>Top 5</span>
                </th>
                <th>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                        <span class="hidden-small">Disbursement</span>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                        <span class="hidden-small">Progress</span>
                    </div>
                </th>
            </tr>
            <tr>
                <td>
                    <canvas id="canvas1" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
                </td>
                <td>
                    <table class="tile_info">
                        <tr>
                            <td>
                                <p><i class="fa fa-square blue"></i>IOS </p>
                            </td>
                            <td>30%</td>
                        </tr>
                        <tr>
                            <td>
                                <p><i class="fa fa-square green"></i>Android </p>
                            </td>
                            <td>10%</td>
                        </tr>
                        <tr>
                            <td>
                                <p><i class="fa fa-square purple"></i>Blackberry </p>
                            </td>
                            <td>20%</td>
                        </tr>
                        <tr>
                            <td>
                                <p><i class="fa fa-square aero"></i>Symbian </p>
                            </td>
                            <td>15%</td>
                        </tr>
                        <tr>
                            <td>
                                <p><i class="fa fa-square red"></i>Others </p>
                            </td>
                            <td>30%</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>
</div> -->

<!-- <div class="col-md-4 col-sm-6 col-xs-12">
<div class="x_panel fixed_height_320">
    <div class="x_title">
        <h2>Daily active users <small>Sessions</small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Settings 1</a>
                    </li>
                    <li><a href="#">Settings 2</a>
                    </li>
                </ul>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="dashboard-widget-content">
            <ul class="quick-list">
                <li><i class="fa fa-calendar-o"></i><a href="#">Settings</a>
                </li>
                <li><i class="fa fa-bars"></i><a href="#">Subscription</a>
                </li>
                <li><i class="fa fa-bar-chart"></i><a href="#">Auto Renewal</a> </li>
                <li><i class="fa fa-line-chart"></i><a href="#">Achievements</a>
                </li>
                <li><i class="fa fa-bar-chart"></i><a href="#">Auto Renewal</a> </li>
                <li><i class="fa fa-line-chart"></i><a href="#">Achievements</a>
                </li>
                <li><i class="fa fa-area-chart"></i><a href="#">Logout</a>
                </li>
            </ul>

            <div class="sidebar-widget">
                <h4>Profile Completion</h4>
                <canvas width="150" height="80" id="foo" class="" style="width: 160px; height: 100px;"></canvas>
                <div class="goal-wrapper">
                    <span class="gauge-value pull-left">$</span>
                    <span id="gauge-text" class="gauge-value pull-left">3,200</span>
                    <span id="goal-text" class="goal-value pull-right">$5,000</span>
                </div>
            </div>
        </div>
    </div>
</div>
</div> -->

<!-- <div class="col-md-4 col-sm-6 col-xs-12 widget_tally_box">
<div class="x_panel">
    <div class="x_title">
        <h2>User Uptake</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Settings 1</a>
                    </li>
                    <li><a href="#">Settings 2</a>
                    </li>
                </ul>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div id="graph_bar" style="width:100%; height:200px;"></div>

        <div class="col-xs-12 bg-white progress_summary">

            <div class="row">
                <div class="progress_title">
                    <span class="left">Escudor Wireless 1.0</span>
                    <span class="right">This sis</span>
                    <div class="clearfix"></div>
                </div>

                <div class="col-xs-2">
                    <span>SSD</span>
                </div>
                <div class="col-xs-8">
                    <div class="progress progress_sm">
                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="89"></div>
                    </div>
                </div>
                <div class="col-xs-2 more_info">
                    <span>89%</span>
                </div>
            </div>
            <div class="row">
                <div class="progress_title">
                    <span class="left">Mobile Access</span>
                    <span class="right">Smart Phone</span>
                    <div class="clearfix"></div>
                </div>

                <div class="col-xs-2">
                    <span>App</span>
                </div>
                <div class="col-xs-8">
                    <div class="progress progress_sm">
                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="79"></div>
                    </div>
                </div>
                <div class="col-xs-2 more_info">
                    <span>79%</span>
                </div>
            </div>
            <div class="row">
                <div class="progress_title">
                    <span class="left">WAN access users</span>
                    <span class="right">Total 69%</span>
                    <div class="clearfix"></div>
                </div>

                <div class="col-xs-2">
                    <span>Usr</span>
                </div>
                <div class="col-xs-8">
                    <div class="progress progress_sm">
                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="69"></div>
                    </div>
                </div>
                <div class="col-xs-2 more_info">
                    <span>69%</span>
                </div>
            </div>

        </div>
    </div>
</div>
</div> -->

<!-- start of weather widget -->
<!-- <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Daily active users <small>Sessions</small></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                    </ul>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="temperature"><b>Monday</b>, 07:30 AM
                        <span>F</span>
                        <span><b>C</b>
                </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="weather-icon">
                        <span>
                    <canvas height="84" width="84" id="partly-cloudy-day"></canvas>
                </span>

                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="weather-text">
                        <h2>Texas
                    <br><i>Partly Cloudy Day</i>
                </h2>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="weather-text pull-right">
                    <h3 class="degrees">23</h3>
                </div>
            </div>
            <div class="clearfix"></div>


            <div class="row weather-days">
                <div class="col-sm-2">
                    <div class="daily-weather">
                        <h2 class="day">Mon</h2>
                        <h3 class="degrees">25</h3>
                        <span>
                        <canvas id="clear-day" width="32" height="32">
                        </canvas>

                </span>
                        <h5>15
                    <i>km/h</i>
                </h5>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="daily-weather">
                        <h2 class="day">Tue</h2>
                        <h3 class="degrees">25</h3>
                        <canvas height="32" width="32" id="rain"></canvas>
                        <h5>12
                    <i>km/h</i>
                </h5>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="daily-weather">
                        <h2 class="day">Wed</h2>
                        <h3 class="degrees">27</h3>
                        <canvas height="32" width="32" id="snow"></canvas>
                        <h5>14
                    <i>km/h</i>
                </h5>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="daily-weather">
                        <h2 class="day">Thu</h2>
                        <h3 class="degrees">28</h3>
                        <canvas height="32" width="32" id="sleet"></canvas>
                        <h5>15
                    <i>km/h</i>
                </h5>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="daily-weather">
                        <h2 class="day">Fri</h2>
                        <h3 class="degrees">28</h3>
                        <canvas height="32" width="32" id="wind"></canvas>
                        <h5>11
                    <i>km/h</i>
                </h5>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="daily-weather">
                        <h2 class="day">Sat</h2>
                        <h3 class="degrees">26</h3>
                        <canvas height="32" width="32" id="cloudy"></canvas>
                        <h5>10
                    <i>km/h</i>
                </h5>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

</div> -->
<!-- end of weather widget -->


<!-- <div class="col-md-4 col-sm-6 col-xs-12">
<div class="x_panel fixed_height_320">
    <div class="x_title">
        <h2>Daily active users <small>Sessions</small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Settings 1</a>
                    </li>
                    <li><a href="#">Settings 2</a>
                    </li>
                </ul>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="dashboard-widget-content">
            <ul class="quick-list">
                <li><i class="fa fa-calendar-o"></i><a href="#">Settings</a>
                </li>
                <li><i class="fa fa-bars"></i><a href="#">Subscription</a>
                </li>
                <li><i class="fa fa-bar-chart"></i><a href="#">Auto Renewal</a> </li>
                <li><i class="fa fa-line-chart"></i><a href="#">Achievements</a>
                </li>
                <li><i class="fa fa-bar-chart"></i><a href="#">Auto Renewal</a> </li>
                <li><i class="fa fa-line-chart"></i><a href="#">Achievements</a>
                </li>
                <li><i class="fa fa-area-chart"></i><a href="#">Logout</a>
                </li>
            </ul>

            <div class="sidebar-widget">
                <h4>Profile Completion</h4>
                <canvas width="150" height="80" id="foo2" class="" style="width: 160px; height: 100px;"></canvas>
                <div class="goal-wrapper">
                    <span class="gauge-value pull-left">$</span>
                    <span id="gauge-text2" class="gauge-value pull-left">3,200</span>
                    <span id="goal-text2" class="goal-value pull-right">$5,000</span>
                </div>
            </div>
        </div>
    </div>
</div>
</div> -->

<!-- </div> -->